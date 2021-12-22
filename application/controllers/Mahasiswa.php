<?php 
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Mahasiswa extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mahasiswa_model', 'mhs');
    }

    public function index_get()
    {
        $id = $this->get('id', true);
        if($id===null){
            $list = $this->mhs->get();
            $this->response(['status' => true,'data' => $list],RestController::HTTP_OK);
        }else{
            $data = $this->mhs->get($id);
            if($data){
                $this->response(['status' => true,'data' => $data],RestController::HTTP_OK);
            }else{
                $this->response(['status' => false,'msg' => 'Data Tidak Ditemukan'],RestController::HTTP_NOT_FOUND);
            }
        }
        
    }

    public function index_delete()
    {
        $id = $this->delete('id', true);
        if ($id === null) {
            $this->response(['status' => false, 'msg' => 'Masukkan id yang akan dihapus'], RestController::HTTP_BAD_REQUEST);
        }
        $delete = $this->mhs->delete($id);
        if ($delete['status']) {
        $status = (int)$delete['data'];
            if ($status > 0)
                $this->response(['status' => true, 'msg' => $id . ' data telah dihapus'], RestController::HTTP_OK);
            else
                $this->response(['status' => false, 'msg' => 'Tidak ada data yang dihapus'], RestController::HTTP_BAD_REQUEST);
        } else {
             $this->response(['status' => false, 'msg' => $delete['msg']], RestController::HTTP_INTERNAL_ERROR);
        }
    }

    Public function index_post(){
        $data = [
            'nrp' => $this->post('nrp', true),
            'nama' => $this->post('nama', true),
            'email' => $this->post('email', true),
            'jurusan' => $this->post('jurusan', true)
          ];
          $simpan = $this->mhs->add($data);
           if ($simpan['status']) {
               $this->response(['status' => true, 'msg' => $simpan['data'] . ' Data telah ditambahkan'], RestController::HTTP_CREATED);
            } else {
              $this->response(['status' => false, 'msg' => $simpan['msg']], RestController::HTTP_INTERNAL_ERROR);
            }
    }

    public function index_put(){
        $data = [
            'nrp' => $this->put('nrp', true),
            'nama' => $this->put('nama', true),
            'email' => $this->put('email', true),
            'jurusan' => $this->put('jurusan', true)
          ];
          $id = $this->put('id', true);
          if ($id === null) {
            $this->response(['status' => false, 'msg' => 'Masukkan id yang akan dirubah'], RestController::HTTP_BAD_REQUEST);
          }
          $simpan = $this->mhs->update($id, $data);
          if ($simpan['status']) {
            $status = (int)$simpan['data'];
            if ($status > 0)
              $this->response(['status' => true, 'msg' => $simpan['data'] . ' Data telah dirubah'], RestController::HTTP_OK);
            else
              $this->response(['status' => false, 'msg' => 'Tidak ada data yang dirubah'], RestController::HTTP_BAD_REQUEST);
          } else {
            $this->response(['status' => false, 'msg' => $simpan['msg']], RestController::HTTP_INTERNAL_ERROR);
          }
    }
}