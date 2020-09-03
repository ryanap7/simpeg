<?php
defined('BASEPATH') or exit('No direct script access allowed');
$data['admin'] = $this->db->get_where('pegawai', ['id_pegawai' => $this->session->userdata('id')])->row_array();
$this->load->view('dist/_partials/header', $data);
?>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Tambah Potongan</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>Isi Data Potongan</h4>
                        </div>
                        <div class="card-body">
                            <form method="post" class="needs-validation" action="<?php echo site_url('admin/potongan/store') ?>" novalidate="">
                                <div class="form-group">
                                    <label for="id">ID Potongan <sup class="text-danger">*</sup></label>
                                    <input id="id" type="text" class="form-control" name="id" tabindex="1" value="<?= $newCode ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="name">Nama Potongan <sup class="text-danger">*</sup></label>
                                    <input id="name" type="text" class="form-control" name="name" tabindex="1" placeholder="Masukkan nama potongan" required autofocus>
                                    <div class="invalid-feedback">
                                        Masukkan nama potongan terlebih dahulu
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="potongan">Besar Potongan <sup class="text-danger">*</sup></label>
                                    <div class="input-group">
                                        <input id="potongan" type="text" name="potongan" tabindex="1" class="form-control currency" required>
                                        <div class="invalid-feedback">
                                            Please fill in nominal
                                        </div>
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                %
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                        Simpan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php $this->load->view('dist/_partials/footer'); ?>