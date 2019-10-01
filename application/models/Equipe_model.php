<?php

class Equipe_model extends CI_Model {
    const table = 'equipe';
    
    //get (select --puxar--)
    public function getAll() {
        $query = $this->db->get('equipe');
        return $query->result();
    }

    public function getOne($id) {
        if ($id > 0) {
            $this->db->where('id', $id);
           $query = $this->db->get('equipe');

            return $query->row(0);
        } else {
            return false;
        }
     }

    //post
    public function insert($data = array()) {
        $this->db->insert('equipe', $data);
        return $this->db->affected_rows();
    }

    //delete
    //recebe o id passado pela url como parametro
    public function delete($id) {
        if ($id > 0) {
            $this->db->where('id', $id);
            $this->db->delete('equipe');
            return $this->db->affected_rows();
        } else {
            return false;
        }
    }

    //put
    public function update($id, $data = array()) {
        if ($id > 0) {
            $this->db->where('id', $id);
            $this->db->update('equipe', $data);
            return $this->db->affected_rows();
        } else {
            return false;
        }
    }
}
?>