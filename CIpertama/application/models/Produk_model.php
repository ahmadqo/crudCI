<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Produk_model extends CI_Model
{
    // Nama Table yang akan diakses
    private $_table = "produk"; //private karena hanya digunakan pada class ini saja

    // Properti atau Variable yang dibutuhkan dalam Model ProdukModel ini
    public $produk_id;
    public $nama;
    public $harga;
    public $image = "default.png"; //default.jpg akan menjadi nilai default dari variabel ini
    public $deskripsi;

    // Method ini akan mengembalikan sebuah array yang berisi rules.
    // rules dibutuhkan untuk validasi input. agar nilai dari variabel yang diberikan rules wajib memiliki nilai

    public function rules()
    {
        return[
            [
                'field' => 'nama',
                'label' => 'Nama',
                'rules' => 'required'
            ],
            [
                'field' => 'harga',
                'label' => 'Harga',
                'rules' => 'required'
            ],
            [
                'field' => 'deskripsi',
                'label' => 'Deskripsi',
                'rules' => 'required'
            ]
        ];
    }

    /**
    *Berikut ini fungsi-fungsi yang digunakan untuk CRUD
    *biasanya orang menuliskannya pada Controller. Namun,
    *agar Controller lebih fokus mengatur hubungan Model dengan View, Maka
    *sebaiknya ini kita tulis di Model.
    *Karena nanti pada Controller, kita tinggal validasi inputnya saja.
    */
    public function getAll()
    {
        return $this->db->get($this->_table)->result();
        //fungsi result() digunakan untuk mengambil semua data hasil query
    }

    public function getById($id)
    {
        return $this->db->get_where($this->_table, ["produk_id" => $id])->row();
        // fungsi row() digunakan untuk mengambik satu data dari hasil query
    }

    public function save()
    {
        $post = $this->input->post(); //mengambil input yang dikirim dari form

        $this->produk_id = uniqid();
        $this->nama      = $post["nama"];
        $this->harga     = $post["harga"];
        $this->image     = $this->_uploadImage();
        $this->deskripsi = $post["deskripsi"];
        $this->db->insert($this->_table, $this);
        // this setelah variable _table digunakan untuk mendefinisikan data yang akan disimpan
    }

    public function update()
    {
        $post = $this->input->post();

        $this->produk_id = $post["id"];
        $this->nama      = $post["nama"];
        $this->harga     = $post["harga"];
        
        if(!empty($_FILES["image"]["name"])){
            $this->image = $this->_uploadImage();
        }else{
            $this->image = $post["old_image"];
        }

        $this->deskripsi = $post["deskripsi"];
        $this->db->update($this->_table, $this, array('produk_id' => $post['id']));
    }

    public function delete($id)
    {
        $this->_deleteImage($id);
        return $this->db->delete($this->_table, array('produk_id' => $id));
    }

    /*
    Kenapa method ini diberikan modifier Private?

    Kita tidak akan memanggil method ini dari Controller. Karena itu, kita memberikan modifier private.
    Method ini nantinya akan dipanggil dari class Produk_model(class itu sendiri), pada method save() dan update().
    */
    private function _uploadImage()
    {
        $config['upload_path']      = './upload/produk/'; // Menentukan alamat lokasi file akan terupload
        $config['allowed_types']    = 'gif|jpg|jpeg|png'; // Untuk membatasi tipe file yang boleh diupload
        $config['file_name']        = $this->produk_id;   // Menentukan nama file. kali ini nama file menggunakan produk_id
        $config['overwrite']        = true;               // Overwrite untuk menindih file yang sudah ter-upload saat di-upload file baru(edit data)
        $config['mac_size']         = 1024; // 1 MB       // Batasan ukuran file yang bisa di upload

        $this->load->library('upload', $config); // Load library upload dengan konfigurasi yang sudah ditentukan diatas

        if($this->upload->do_upload('image')){
            return $this->upload->data("file_name");
        }
        
        return "default.png"; // Jika upload gagal maka kita akan mengembalikan nama file menjadi default.png
    }

    // Method untuk menghapus image ketika data produk dihapus
    private function _deleteImage($id)
    {
        $produk = $this->getById($id);
        if($produk->image != "default.png"){
            $filename = explode(".", $produk->image)[0];
            return array_map('unlink', glob(FCPATH."upload/produk/$filename.*"));
        }
    }
    /*
    Disana kita mengambil nama file dengan fungsi explode(). Lalu kita cari file berdasarkan nama tersebut dengan fungsi glob().

    Setelah file-file ditemukan, lalu kita gunakan fungsi array_map() untuk mengeksekusi unlink() pada tiap file yang ditemukan.

    Tanda * setelah $filename artinya semua extensi dipilih. ini nanti akan menghapus dengan nama yang sama walaupun ekstensinya berbeda.

    Karena pada fungsi upload, ketika diedit dan yang di upload berekstensi berbeda dengan yang sudah ada di server..
    ....maka ia akan membuat file baru dengan nama yang sama dan ekstensi yang berbeda.

    overwrite pada konfigurasi upload, hanya akan menindih file dengan nama dan ektensi yang sama.
    */
}