<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PenghargaanController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('logged_in' !== TRUE)) {
			redirect('/');
		}
	}

	public function index()
	{
		if ($this->session->userdata('role') === '3') {
			$data = array(
				'title' => "Data Penghargaan"
			);
			$id = $this->session->userdata('id');
			$data['penghargaan']	 	= $this->db->query("SELECT *, penghargaan_pegawai.id as id FROM penghargaan_pegawai INNER JOIN tingkatan ON penghargaan_pegawai.id_tingkatan = tingkatan.id WHERE id_user = $id")->result();
			$this->load->view('pages/Pegawai/penghargaan/index.php', $data);
		} else {
			redirect('/');
		}
	}

	public function create()
	{
		if ($this->session->userdata('role') === '3') {
			$data = array(
				'title' => "Data Penghargaan"
			);
			$data['tingkatan'] 	= $this->db->query("SELECT * FROM tingkatan")->result();
			$this->load->view('pages/Pegawai/penghargaan/add', $data);
		} else {
			redirect('/');
		}
	}

	public function store()
	{
		$nama  	            	= $this->input->post('nama');
		$tahun  	           	= $this->input->post('tahun');
		$pemberi  	        	= $this->input->post('pemberi');
		$id_tingkatan  	    	= $this->input->post('id_tingkatan');
		$max_size				= 3000000;

		if ($_FILES['doc']['size'] < $max_size) {
			$tmp_name 			= $_FILES['doc']['tmp_name'];
			$upload_path		= './assets/img/pegawai/doc_penghargaan/';
			$dname 				= explode(".", $_FILES['doc']['name']);
			$ext 				= end($dname);
			$file_name 	= rand(100, 10000) . "." . $ext;
			move_uploaded_file($tmp_name, "$upload_path/$file_name");
		} else {
			$this->session->set_flashdata('error', 'File terlalu besar');
			redirect('pegawai/penghargaan/create');
		}

		$data = array(
			'id_user'			=> $this->session->userdata('id'),
			'nama'				=> $nama,
			'tahun'				=> $tahun,
			'id_tingkatan'		=> $id_tingkatan,
			'pemberi'			=> $pemberi,
			'doc'				=> $file_name,
		);

		$this->db->insert('penghargaan_pegawai', $data);
		$this->session->set_flashdata('success', 'Data berhasil disimpan');
		redirect('pegawai/penghargaan');
	}

	public function edit($id)
	{
		if ($this->session->userdata('role') === '3') {
			$data = array(
				'title' => "Data Penghargaan"
			);
			$data['penghargaan'] 		= $this->db->query("SELECT * FROM penghargaan_pegawai WHERE id='$id'")->result();
			$data['tingkatan'] 			= $this->db->query("SELECT * FROM tingkatan")->result();
			$this->load->view('pages/Pegawai/penghargaan/edit', $data);
		} else {
			redirect('/');
		}
	}

	public function update()
	{
		$id						= $this->input->post('id');
		$nama  	            	= $this->input->post('nama');
		$tahun  	           	= $this->input->post('tahun');
		$pemberi  	        	= $this->input->post('pemberi');
		$id_tingkatan  	    	= $this->input->post('id_tingkatan');
		$max_size				= 3000000;

		$result					= $this->M_Dosen->check($id, 'penghargaan_pegawai');
		if ($result->num_rows() > 0) {
			$data			= $result->row_array();
			$doc			= $data['doc'];
		}

		if ($_FILES['doc']['size'] > 0) {
			if ($_FILES['doc']['size'] < $max_size) {
				if ($doc != 'default.png') {
					$target_file	= './assets/img/pegawai/doc_penghargaan/' . $doc;
					unlink($target_file);
				}

				$tmp_name 			= $_FILES['doc']['tmp_name'];
				$upload_path		= './assets/img/pegawai/doc_penghargaan/';
				$dname 				= explode(".", $_FILES['doc']['name']);
				$ext 				= end($dname);
				$file_name 	= rand(100, 10000) . "." . $ext;
				move_uploaded_file($tmp_name, "$upload_path/$file_name");

				$data = array(
					'doc'			=> $file_name,
				);
				$where = array('id' => $id);
				$this->db->update('penghargaan_pegawai', $data, $where);
			} else {
				$this->session->set_flashdata('error', 'File terlalu besar');
				redirect('pegawai/penghargaan/create');
			}
		}

		$data = array(
			'id_user'			=> $this->session->userdata('id'),
			'nama'				=> $nama,
			'tahun'				=> $tahun,
			'id_tingkatan'		=> $id_tingkatan,
			'pemberi'			=> $pemberi,
		);

		$where = array('id' => $id);
		$this->db->update('penghargaan_pegawai', $data, $where);
		$this->session->set_flashdata('success', 'Data berhasil diubah');
		redirect('pegawai/penghargaan');
	}

	public function delete($id)
	{
		$result					= $this->M_Dosen->check($id, 'penghargaan_pegawai');
		if ($result->num_rows() > 0) {
			$data			= $result->row_array();
			$doc			= $data['doc'];
		}

		if ($doc != 'default.png') {
			$target_file	= './assets/img/pegawai/doc_penghargaan/' . $doc;
			unlink($target_file);
		}

		$where = array('id' => $id);
		$this->db->delete('penghargaan_pegawai', $data, $where);
		$this->session->set_flashdata('success', 'Data berhasil dihapus');
		redirect('pegawai/penghargaan');
	}
}
