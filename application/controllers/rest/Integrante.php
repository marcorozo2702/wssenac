<?php
defined('BASEPATH') or exit('No direct script access allowed');
use Restserver\Libraries\REST_Controller;
use Restserver\Libraries\REST_Controller_Definitions;
require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/REST_Controller_Definitions.php';
require APPPATH . '/libraries/Format.php';

class Integrante extends REST_Controller {
    public function __construct() {
        parent::__construct();
    }


    //metodo GET (select) REST
    public function index_get(){
        $id = (int) $this->get('id');
        $this->load->model('Integrante_model');

        if($id<=0){
            $retorno = $this->Integrante_model->getAll();
        } else {
            $retorno = $this->Integrante_model->getOne($id);
        }
        

        $this->set_response($retorno, REST_Controller_Definitions::HTTP_OK);
    }

    //metodo POST (insert)
    // integrante_post significa que este metodo vai ser executado 
    // quando o WS (Web Service) receber uma requisição do tipo 
    // POST na URL 'usuario'
    public function index_post() {
        //Primeiro fazemos a validação, para verificar o preenchimento dos campos
        if ((!$this->post('id_equipe')) || (!$this->post('nome')) || (!$this->post('data_nasc')) | (!$this->post('rg')) | (!$this->post('cpf'))  ) {
                $this->set_response([
                    'status' => false,
                    'error' => 'Campos não preenchidos'
                ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
                return;
            }
            $data = array(
                'id_equipe' => $this->post('id_equipe'),
                'nome' => $this->post('nome'),
                'data_nasc' => $this->post('data_nasc'),
                'rg' => $this->post('rg'),
                'cpf' => $this->post('cpf'),
            );
            //carregamos o model, e mandamos inserir no DB 
            //os dados recebidos via POST
            $this->load->model('Integrante_model', 'im');
            if ($this->im->insert($data)) {
                //deu certo 
                $this->set_response([
                    'status' => true,
                    'message' => 'Successo ao inserir a integrante!'
                ], REST_Controller_Definitions::HTTP_OK);
            } else {
                //deu errado
                $this->set_response([
                    'status' => false,
                    'error' => 'Falha ao inserir a integrante'
                ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            }
        }

    //DELETE
    public function index_delete() {
        $id=(int) $this->get('id');
        if ($id <= 0) {
            $this->set_response([
                'status' => false,
                'message' => 'Parametros obrigatorios não fornecidos'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            return;
        }

        $this->load->model('Integrante_model', 'im');

        if($this->im->delete($id)){
            //deu certo
            $this->set_response([
                'status' => true,
                'message' => /*$id.*/' Sucesso ao deletar integrante!'
            ], REST_Controller_Definitions::HTTP_OK);
        } else{
            //deu errado
            $this->set_response([
                'status' => FALSE,
                'message' =>'Falha ao deletar integrante'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
        }
    }


    //PUT (update)
    // integrante_put significa que este metodo vai ser executado 
    // quando o WS (Web Service) receber uma requisição do tipo 
    // PUT na URL 'usuario'
    public function index_put() {

        $id = (int) $this->get('id');
        //Primeiro fazemos a validação, para verificar o preenchimento dos campos
        if ((!$this->put('id_equipe')) || (!$this->put('nome')) || (!$this->put('data_nasc')) | (!$this->put('rg')) | (!$this->put('cpf')) || ($id <= 0)) {
            $this->set_response([
                'status' => false,
                'error' => 'Campo não preenchidos'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            return;
        }

        $data = array(
            'id_equipe' => $this->put('id_equipe'),
            'nome' => $this->put('nome'),
            'data_nasc' => $this->put('data_nasc'),
            'rg' => $this->put('rg'),
            'cpf' => $this->put('cpf'),
        );
        //carregamos o model, e mandamos inserir no DB 
        //os dados recebidos via PUT
        $this->load->model('Integrante_model', 'im');
        if ($this->im->update($id, $data)) {
            //deu certo 
            $this->set_response([
                'status' => true,
                'message' => 'Successo ao alterar integrante!'
            ], REST_Controller_Definitions::HTTP_OK);
        } else {
            //deu errado
            $this->set_response([
                'status' => false,
                'error' => 'Falha ao alterar integrante'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
        }
    }
}
