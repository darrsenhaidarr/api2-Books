<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\libraries\REST_Controller;

class Books extends REST_Controller {
    function __construct($config = 'rest'){
        parent::__construct($config);
    }


    // Menampilkan Data
    public function index_get(){
        $id = $this->get('id');
        if($id==''){
            $data = $this->db->get('buku')->result();
        } else {
            $this->db->where('id_buku', $id);
            $data = $this->db->get('buku')->result();
        }
        $result = ["took"=>$_SERVER["REQUEST_TIME_FLOAT"],
                    "code"=>200,
                    "message"=>"Response successfully",
                    "data"=>$data];
        $this->response($result, 200);
    }

    // Menambah Data
    public function index_post(){
        $data = array(
            
            'namabuku' => $this->post('namabuku'),
            'kategoribuku' =>$this->post('kategoribuku'),
            'deskripsi' =>$this->post('deskripsi'),
            'pengarang' =>$this->post('pengarang'),
            'thn_buat' =>$this->post('thn_buat')
        );
        $insert=$this->db->insert('buku', $data);
        if($insert){
            $result = ["took"=>$_SERVER["REQUEST_TIME_FLOAT"],
                    "code"=>201,
                    "message"=>"Data has successfully added",
                    "data"=>$data];
            $this->response($result, 201);
        } else {
            $result = ["took"=>$_SERVER["REQUEST_TIME_FLOAT"],
                    "code"=>502,
                    "message"=>"Failed adding data",
                    "data"=>$data];
            $this->response($result, 502);
        }
    }

    //Memperbarui data yang ada
    public function index_put(){
        $id=$this->put('id');
         $data = array(
            'namabuku' => $this->put('namabuku'),
            'kategoribuku' =>$this->put('kategoribuku'),
            'deskripsi' =>$this->put('deskripsi'),
            'pengarang' =>$this->put('pengarang'),
            'thn_buat' =>$this->put('thn_buat')
        );
         $this->db->where('id_buku', $id);
         $update=$this->db->update('buku', $data);
         if($update){
            $this->response($data, 200);
         } else {
            $this->response(array('status' => 'fail', 502));
         }
    }

    //Menghapus data Buku
    public function index_delete(){
        $id=$this->delete('id');
        $this->db->where('id_buku', $id);
        $delete=$this->db->delete('buku');
        if($delete){
            $this->response(array('status' => 'success'), 201);
        }else{
            $this->response(array('status' => 'fail', 502));
        }
    }
}
?>