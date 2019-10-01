<?php
defined('BASEPATH') or exit('No direct script access allowed');
use Restserver\Libraries\REST_Controller;
use Restserver\Libraries\REST_Controller_Definitions;
require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/REST_Controller_Definitions.php';
require APPPATH . '/libraries/Format.php';

class Prova extends REST_Controller {
    public function __construct() {
        parent::__construct();
    }


    //metodo GET (select) REST
    public function index_get(){
        $id = (int) $this->get('id');
        $this->load->model('Prova_model');

        if($id<=0){
            $retorno = $this->Prova_model->getAll();
        } else {
            $retorno = $this->Prova_model->getOne($id);
        }
        

        $this->set_response($retorno, REST_Controller_Definitions::HTTP_OK);
    }

    //metodo POST (insert)
    // prova_post significa que este metodo vai ser executado 
    // quando o WS (Web Service) receber uma requisição do tipo 
    // POST na URL 'usuario'
    public function index_post() {
        //Primeiro fazemos a validação, para verificar o preenchimento dos campos
        if ((!$this->post('nome')) || (!$this->post('descricao')) || (!$this->post('num_int')) ) {
                $this->set_response([
                    'status' => false,
                    'error' => 'Campo não preenchidos'
                ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
                return;
            }
            $data = array(
                'nome' => $this->post('nome'),
                'descricao' => $this->post('descricao'),
                'num_int' => $this->post('num_int'),
            );
            //carregamos o model, e mandamos inserir no DB 
            //os dados recebidos via POST
            $this->load->model('Prova_model', 'pm');
            if ($this->pm->insert($data)) {
                //deu certo 
                $this->set_response([
                    'status' => true,
                    'message' => 'Successo ao inserir a prova!'
                ], REST_Controller_Definitions::HTTP_OK);
            } else {
                //deu errado
                $this->set_response([
                    'status' => false,
                    'error' => 'Falha ao inserir a prova'
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

        $this->load->model('Prova_model', 'pm');

        if($this->pm->delete($id)){
            //deu certo
            $this->set_response([
                'status' => true,
                'message' => /*$id.*/' Sucesso ao deletar prova!'
            ], REST_Controller_Definitions::HTTP_OK);
        } else{
            //deu errado
            $this->set_response([
                'status' => FALSE,
                'message' =>'Falha ao deletar prova'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
        }
    }


    //PUT (update)
    // prova_put significa que este metodo vai ser executado 
    // quando o WS (Web Service) receber uma requisição do tipo 
    // PUT na URL 'usuario'
    public function index_put() {

        $id = (int) $this->get('id');
        //Primeiro fazemos a validação, para verificar o preenchimento dos campos
        if ((!$this->put('nome')) || (!$this->put('descricao')) || (!$this->put('num_int')) || ($id <= 0)) {
            $this->set_response([
                'status' => false,
                'error' => 'Campo não preenchidos'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            return;
        }

        $data = array(
            'nome' => $this->put('nome'),
            'descricao' => $this->put('descricao'),
            'num_int' => $this->put('num_int'),

        );
        //carregamos o model, e mandamos inserir no DB 
        //os dados recebidos via PUT
        $this->load->model('Prova_model', 'pm');
        if ($this->pm->update($id, $data)) {
            //deu certo 
            $this->set_response([
                'status' => true,
                'message' => 'Successo ao alterar prova!'
            ], REST_Controller_Definitions::HTTP_OK);
        } else {
            //deu errado
            $this->set_response([
                'status' => false,
                'error' => 'Falha ao alterar prova'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
        }
    }
}
