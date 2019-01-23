<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends CI_Controller
{   
    // Method __construct() adalah method kontruktor. 
    // Method ini akan dieksekusi pertama kali saat Controller diakses

    // Library form_validation akan digunakan untuk memvalidasi input dari form
    public function __construct()
    {
        parent::__construct();
        $this->load->model("produk_model");
        $this->load->library('form_validation');
    }

    // Method index(), akan digunakan untuk mengambil data dari model dengan memanggil method produk_model->getAll()
    // Kemudian kita render kedalam view admin/produk/produk_list
    public function index()
    {
        $data["produk"] = $this->produk_model->getAll();
        $this->load->view("admin/produk/produk_list", $data);
    }

    public function add()
    {
        $produk   = $this->produk_model;
        $validasi = $this->form_validation;
        $validasi->set_rules($produk->rules()); 

        if($validasi->run()){
            $produk->save(); //Method yang ada pada produk_model untuk menyimpan data
            $this->session->set_flashdata('success', 'Berhasil disimpan');
        }
        $this->load->view("admin/produk/produk_insert");
    }

    public function edit($id = null) //nilai id akan didapat dari parameter / argumen pada URL
    {
        if (!isset($id)) redirect('admin/produk');

        $produk   = $this->produk_model;
        $validasi = $this->form_validation;
        $validasi->set_rules($produk->rules()); 

        if($validasi->run()){
            $produk->update(); //Method yang ada pada produk_model untuk mengupdate data
            $this->session->set_flashdata('success', 'Berhasil Update');
        }

        $data["produk"] = $produk->getById($id);
        if(!$data["produk"]) show_404();

        $this->load->view("admin/produk/produk_edit", $data);
    }

    public function delete($id =null)
    {
        if(!isset($id)) show_404();

        if($this->produk_model->delete($id)){
            redirect(site_url('admin/produk'));
        }
    }
}