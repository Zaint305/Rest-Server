<?php

class Mahasiswa_model extends CI_Model
{
    public function get($id = null, $limit = 5, $offset = 0)
    {
        if($id === null){
            return $this->db->get('mahasiswa', $limit, $offset)->result();
        }else{
            return $this->db->get_where('mahasiswa', ['id' => $id])->result_array();
        }
        
    }

    public function delete($id)
  {
    try {
      $this->db->delete('mahasiswa', ['id' => $id]);
      $error = $this->db->error();
      if (!empty($error['code'])) {
        throw new Exception('Terjadi kesalahan: ' . $error['message']);
        return false;
      }
      return ['status' => true, 'data' => $this->db->affected_rows()];
    } catch (Exception $ex) {
      return ['status' => false, 'msg' => $ex->getMessage()];
    }
  }

  public function add($data)
  {
    try {
      $this->db->insert('mahasiswa', $data);
      $error = $this->db->error();
      if (!empty($error['code'])) {
        throw new Exception('Terjadi kesalahan: ' . $error['message']);
        return false;
      }
      return ['status' => true, 'data' => $this->db->affected_rows()];
    } catch (Exception $ex) {
      return ['status' => false, 'msg' => $ex->getMessage()];
    }
  }

  public function update($id, $data)
  {
    try {
      $this->db->update('mahasiswa', $data, ['id' => $id]);
      $error = $this->db->error();
      if (!empty($error['code'])) {
        throw new Exception('Terjadi kesalahan: ' . $error['message']);
        return false;
      }
      return ['status' => true, 'data' => $this->db->affected_rows()];
    } catch (Exception $ex) {
      return ['status' => false, 'msg' => $ex->getMessage()];
    }
  }
}