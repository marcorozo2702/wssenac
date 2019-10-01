<?php
defined('BASEPATH') or exit('No direct script access allowed');
use Restserver\Libraries\REST_Controller;
use Restserver\Libraries\REST_Controller_Definitions;
require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/REST_Controller_Definitions.php';
require APPPATH . '/libraries/Format.php';

class Equipe extends REST_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Equipe_model','em');
    }


    //metodo GET (select) REST
    public function index_get() {
        $id = (int) $this->get('id');
        $this->load->model('Equipe_model');

        if($id<=0){
            $retorno = $this->Equipe_model/*em*/->getAll();
        } else {
            $retorno = $this->Equipe_model->getOne($id);
        }

        $this->set_response($retorno,REST_Controller_Definitions::HTTP_OK);
    }

    // usuario_post significa que este metodo vai ser executado 
    // quando o WS (Web Service) receber uma requisição do tipo 
    // POST na URL 'usuario'
    public function index_post() {
        //Primeiro fazemos a validação, para verificar o preenchimento dos campos
        if ((!$this->post('nome'))) {
            $this->set_response([
                'status' => false,
                'error' => 'Campo não preenchidos'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            return;
        }
        $data = array(
            'nome' => $this->post('nome')
        );
        //carregamos o model, e mandamos inserir no DB 
        //os dados recebidos via POST
        $this->load->model('Equipe_model', 'em');
        if ($this->em->insert($data)) {
            //deu certo 
            $this->set_response([
                'status' => true,
                'message' => 'Sucesso ao inserir equipe!'
            ], REST_Controller_Definitions::HTTP_OK);
        } else {
            //deu errado
            $this->set_response([
                'status' => false,
                'error' => 'Falha ao inserir equipe'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
        }
    }

    //DELETE
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

        $this->load->model('Equipe_model', 'em');

        if($this->em->delete($id)){
            //deu certo
            $this->set_response([
                'status' => true,
                'message' => /*$id.*/'Sucesso ao deletar equipe!'
            ], REST_Controller_Definitions::HTTP_OK);
        } else{
            //deu errado
            $this->set_response([
                'status' => FALSE,
                'message' =>'Falha ao deletar equipe'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
        }
    }


    // usuario_put significa que este metodo vai ser executado 
    // quando o WS (Web Service) receber uma requisição do tipo 
    // PUT na URL 'usuario'
    public function index_put() {

        $id = (int) $this->get('id');
        //Primeiro fazemos a validação, para verificar o preenchimento dos campos
        if ((!$this->put('nome')) || ($id <= 0)) {
            $this->set_response([
                'status' => false,
                'error' => 'Campo não preenchidos'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            return;
        }

        $data = array(
            'nome' => $this->put('nome')

        );
        //carregamos o model, e mandamos inserir no DB 
        //os dados recebidos via PUT
        $this->load->model('Equipe_model', 'em');
        if ($this->em->update($id, $data)) {
            //deu certo 
            $this->set_response([
                'status' => true,
                'message' => 'Sucesso ao alterar equipe!'
            ], REST_Controller_Definitions::HTTP_OK);
        } else {
            //deu errado
            $this->set_response([
                'status' => false,
                'error' => 'Falha ao alterar equipe'
            ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
        }
    }
}
?>