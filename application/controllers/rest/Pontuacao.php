<?php
defined('BASEPATH') or exit('No direct script access allowed');
use Restserver\Libraries\REST_Controller;
use Restserver\Libraries\REST_Controller_Definitions;
require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/REST_Controller_Definitions.php';
require APPPATH . '/libraries/Format.php';

class Pontuacao extends REST_Controller {
    public function __construct() {
        parent::__construct(); 
        // load do model no contruct para n precisar chamar sempre
        $this->load->model('Pontuacao_model','pm');
        //hora padrao definida com o fuso horario de SP
        date_default_timezone_set('America/Sao_Paulo');
    }

        //metodo GET (select) REST
        public function index_get(){
            $id = (int) $this->get('id');
            $this->load->model('Pontuacao_model');

            if($id<=0){
                $retorno = $this->Pontuacao_model->getAll();
            } else {
                $retorno = $this->Pontuacao_model->getOne($id);
            }
            

            $this->set_response($retorno, REST_Controller_Definitions::HTTP_OK);
        }

    //metodo POST(insert no db)
    // pontuacao_post significa que este metodo vai ser executado 
        // quando o WS (Web Service) receber uma requisição do tipo 
        // POST na URL 'usuario'
    public function index_post() {

        //verifica se os campos foram preenchidos (no envio dos dados)
        if ((!$this->post('id_equipe')) || (!$this->post('id_prova')) || (!$this->post('id_usuario') || (!$this->post('pontos'))) ) {
            $this->set_response([
                'status' => false,
                'error' => 'Campo não preenchidos'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            return;
        }

        //cria um array para inserir os dados nos campos correspondentes do banco de dados
        $data = array(
            'id_equipe' => $this->post('id_equipe'),
            'id_prova' => $this->post('id_prova'),
            'id_usuario' => $this->post('id_usuario'),
            'pontos' => $this->post('pontos'),
            'data_hora' => date('Y-m-d H:i:s')
        );
        //carregamos o model, e mandamos inserir no DB 
            //os dados recebidos via POST
            $this->load->model('Pontuacao_model', 'pm');
            if ($this->pm->insert($data)) {
                //deu certo 
                $this->set_response([
                    'status' => true,
                    'message' => 'Successo ao inserir pontuação!'
                ], REST_Controller_Definitions::HTTP_OK);
            } else {
                //deu errado
                $this->set_response([
                    'status' => false,
                    'error' => 'Falha ao inserir pontuação'
                ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            }
    }
    public function index_delete() {
        $id=(int) $this->get('id');
        if ($id <= 0) {
            $this->set_response([
                'status' => false,
                'message' => 'Parametros obrigatorios não fornecidos'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            return;
        }

        $this->load->model('Pontuacao_model', 'pm');

        if($this->pm->delete($id)){
            //deu certo
            $this->set_response([
                'status' => true,
                'message' => /*$id.*/'Sucesso ao deletar pontuação!'
            ], REST_Controller_Definitions::HTTP_OK);
        } else{
            //deu errado
            $this->set_response([
                'status' => FALSE,
                'message' =>'Falha ao deletar pontuação'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
        }
    }
    
    // usuario_put significa que este metodo vai ser executado 
    // quando o WS (Web Service) receber uma requisição do tipo 
    // PUT na URL 'usuario'
    public function index_put($id) {
        $id = (int) $this->get('id');
            //Primeiro fazemos a validação, para verificar o preenchimento dos campos
            if ((!$this->put('id_equipe')) || (!$this->put('id_prova')) || (!$this->put('id_usuario')) || (!$this->put('pontos')) || ($id <= 0)) {
                $this->set_response([
                    'status' => false,
                    'error' => 'Campo não preenchidos'
                ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
                return;
            }
        $data = array(
            'id_equipe' => $this->put('id_equipe'),
            'id_prova' => $this->put('id_prova'),
            'id_usuario' => $this->put('id_usuario'),
            'pontos' => $this->put('pontos'),
            'data_hora' => date('Y-m-d H:i:s')
        );
        //carregamos o model, e mandamos inserir no DB 
        //os dados recebidos via PUT
        $this->load->model('Pontuacao_model', 'pm');
        if ($this->pm->update($id, $data)) {
            //deu certo 
            $this->set_response([
                'status' => true,
                'message' => 'Successo ao alterar pontuação!'
            ], REST_Controller_Definitions::HTTP_OK);
        } else {
            //deu errado
            $this->set_response([
                'status' => false,
                'error' => 'Falha ao alterar pontuação'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
        }
    }
}

?>