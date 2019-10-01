<?php

class Integrante_model extends CI_Model {
    
    //get (select --puxar--)
    public function getAll() {
        $query = $this->db->get('integrante');
        return $query->result();
    }


    public function getOne($id) {
        if ($id > 0) {
            $this->db->where('id', $id);
           $query = $this->db->get('integrante');

            return $query->row(0);
        } else {
            return false;
        }
     }

    //post
    public function insert($data = array()) {
        $this->db->insert('integrante', $data);
        return $this->db->affected_rows();
    }

    //delete
    public function delete($id) {
        if ($id > 0) {
            $this->db->where('id', $id);
            $this->db->delete('integrante');
            return $this->db->affected_rows();
        } else {
            return false;
        }
    }

    //put
    public function update($id, $data = array()) {
        if ($id > 0) {
            $this->db->where('id', $id);
            $this->db->update('integrante', $data);
            return $this->db->affected_rows();
        } else {
            return false;
        }
    }
}
?>