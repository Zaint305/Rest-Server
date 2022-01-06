<?php 
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Alat extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Alat_model', 'alat');
    }

    public function index_get()
    {
        $id = $this->get('kode', true);
        if($id===null){
            $list = $this->alat->get();
            $this->response(['status' => true,'data' => $list],RestController::HTTP_OK);
        }else{
            $data = $this->alat->get($id);
            if($data){
                $this->response(['status' => true,'data' => $data],RestController::HTTP_OK);
            }else{
                $this->response(['status' => false,'msg' => 'Data Tidak Ditemukan'],RestController::HTTP_NOT_FOUND);
            }
        }
        
    }

    public function index_delete()
    {
        $id = $this->delete('kode', true);
        if ($id === null) {
            $this->response(['status' => false, 'msg' => 'Masukkan id yang akan dihapus'], RestController::HTTP_BAD_REQUEST);
        }
        $delete = $this->alat->delete($id);
        if ($delete['status']) {
        $status = (int)$delete['data'];
            if ($status > 0)
                $this->response(['status' => true, ' data ke','msg' => $id . 'telah dihapus'], RestController::HTTP_OK);
            else
                $this->response(['status' => false, 'msg' => 'Tidak ada data yang dihapus'], RestController::HTTP_BAD_REQUEST);
        } else {
             $this->response(['status' => false, 'msg' => $delete['msg']], RestController::HTTP_INTERNAL_ERROR);
        }
    }

    Public function index_post(){
        $data = [
            'kode' => $this->post('kode', true),
            'alat' => $this->post('Alat', true),
            'harga' => $this->post('harga', true),
            'waktu_sewa' => $this->post('waktu_sewa', true)
          ];
          $simpan = $this->alat->add($data);
           if ($simpan['status']) {
               $this->response(['status' => true, 'msg' => $simpan['data'] . ' Data telah ditambahkan'], RestController::HTTP_CREATED);
            } else {
              $this->response(['status' => false, 'msg' => $simpan['msg']], RestController::HTTP_INTERNAL_ERROR);
            }
    }

    public function index_put(){
        $data = [
            'alat' => $this->put('Alat', true),
            'harga' => $this->put('harga', true),
            'waktu_sewa' => $this->put('waktu_sewa', true)
          ];
          $id = $this->put('kode', true);
          if ($id === null) {
            $this->response(['status' => false, 'msg' => 'Masukkan id yang akan dirubah'], RestController::HTTP_BAD_REQUEST);
          }
          $simpan = $this->alat->update($id, $data);
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