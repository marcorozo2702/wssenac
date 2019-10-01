<?php
    /** 
    * Implementação da API REST usando a biblioteca do link abaixo
    * Essa biblioteca possui quatro arquivos distintos:
    * 1 - REST_Controller na pasta libraries, que altera o comportamento 
    *     padrão das controllers padrões do CodeIgniter
    * 2 - REST_Controller_Definition na pasta lbraries, que trata algumas 
    *     definições para o REST_Controller, trabalha como um arquivo 
    *     de padrões auxiliando o controller principal
    * 3 - Format na pasta libraries, que faz o parsing (conversão) dos
    *     diferentes tipos de dados (JASON, XML, CSV e etc)
    * 4 - rest.php na pasta config, para as configrações desta biblioteca
    *
    *
    * @author       Marco Antonio Rozo
    * @link         https://github.com/chriskacerguis/codeigniter-restserver
    *
    */ 
    use Restserver\Libraries\REST_Controller;
    use Restserver\Libraries\REST_Controller_Definitions;


    require APPPATH . '/libraries/REST_Controller.php';
    require APPPATH . '/libraries/REST_Controller_Definitions.php';
    require APPPATH . '/libraries/Format.php';

    class Usuario extends REST_Controller {

        public function __construct(){
            parent::__construct();
        }

        // nome dos metodos sempre vem acompanhado do tipo de requisição
        // ou seja, contato_get significa que é uma requisição do tipo GET
        //e o usuario vai requisitar apenas /contato na URL
        public function contato_get(){
            $retorno = [
                'status' =>true,
                'nome' => 'Marco',
                'telefone' => '91950620',
                'error' => ''
            ];

            $this->set_response($retorno, REST_Controller_Definitions::HTTP_OK);
        }


        public function index_get(){
            $id = (int) $this->get('id');
            $this->load->model('Usuario_model');

            if($id<=0){
                $retorno = $this->Usuario_model->getAll();
            } else {
                $retorno = $this->Usuario_model->getOne($id);
            }
            

            $this->set_response($retorno, REST_Controller_Definitions::HTTP_OK);
        }

        // usuario_post significa que este metodo vai ser executado 
        // quando o WS (Web Service) receber uma requisição do tipo 
        // POST na URL 'usuario'
        public function index_post() {
            //Primeiro fazemos a validação, para verificar o preenchimento dos campos
            if ((!$this->post('nome')) || (!$this->post('senha')) || (!$this->post('nivel')) ) {
                $this->set_response([
                    'status' => false,
                    'error' => 'Campo não preenchidos'
                ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
                return;
            }
            $data = array(
                'nome' => $this->post('nome'),
                'senha' => $this->post('senha'),
                'nivel' => $this->post('nivel'),
            );
            //carregamos o model, e mandamos inserir no DB 
            //os dados recebidos via POST
            $this->load->model('Usuario_model', 'us');
            if ($this->us->insert($data)) {
                //deu certo 
                $this->set_response([
                    'status' => true,
                    'message' => 'Usuário inserido com successo !'
                ], REST_Controller_Definitions::HTTP_OK);
            } else {
                //deu errado
                $this->set_response([
                    'status' => false,
                    'error' => 'Falha ao inserir usuário'
                ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            }
        }

        //deletar
        public function index_delete() {
            $id=(int) $this->get('id');
            if ($id <= 0) {
                $this->set_response([
                    'status' => false,
                    'message' => 'Parametros obrigatorios não fornecidos'
                ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
                return;
            }

            $this->load->model('Usuario_model', 'us');

            if($this->us->delete($id)){
                //deu certo
                $this->set_response([
                    'status' => true,
                    'message' => /*$id.*/' Usuario deletado com sucesso!'
                ], REST_Controller_Definitions::HTTP_OK);
            } else{
                //deu errado
                $this->set_response([
                    'status' => FALSE,
                    'message' =>'Falha ao deletar usuario'
                ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            }
        }

        // usuario_put significa que este metodo vai ser executado 
        // quando o WS (Web Service) receber uma requisição do tipo 
        // PUT na URL 'usuario'
        public function index_put() {

            $id = (int) $this->get('id');
            //Primeiro fazemos a validação, para verificar o preenchimento dos campos
            if ((!$this->put('nome')) || (!$this->put('senha')) || (!$this->put('nivel')) || ($id <= 0)) {
                $this->set_response([
                    'status' => false,
                    'error' => 'Campo não preenchidos'
                ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
                return;
            }

            $data = array(
                'nome' => $this->put('nome'),
                'senha' => $this->put('senha'),
                'nivel' => $this->put('nivel'),

            );
            //carregamos o model, e mandamos inserir no DB 
            //os dados recebidos via PUT
            $this->load->model('Usuario_model', 'us');
            if ($this->us->update($id, $data)) {
                //deu certo 
                $this->set_response([
                    'status' => true,
                    'message' => 'Usuário alterado com successo !'
                ], REST_Controller_Definitions::HTTP_OK);
            } else {
                //deu errado
                $this->set_response([
                    'status' => false,
                    'error' => 'Falha ao alterar usuário'
                ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            }
        }
    }
?>