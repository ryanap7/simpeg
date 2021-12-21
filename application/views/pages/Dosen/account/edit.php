<?php
defined('BASEPATH') or exit('No direct script access allowed');
$data['admin'] = $this->db->get_where('users', ['id' => $this->session->userdata('id')])->row_array();
$this->load->view('dist/_partials/header', $data);
?>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Data Akun</h1>
        </div>
        <?php if ($this->session->flashdata('success')) { ?>
            <div class="alert alert-primary alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                        <span>×</span>
                    </button>
                    <?= $this->session->flashdata('success'); ?>
                </div>
            </div>
        <?php } ?>
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>Isi Data</h4>
                        </div>
                        <div class="card-body">
                            <?php foreach ($dosen as $data) : ?>
                                <form method="post" class="needs-validation" action="<?php echo site_url('dosen/account/update') ?>" novalidate="">
                                    <input type="hidden" name="id" value="<?= $data->id ?>">
                                    <div class="form-group">
                                        <label for="name">Nama<sup class="text-danger">*</sup></label>
                                        <input id="name" type="text" class="form-control" name="name" tabindex="1" value="<?= $data->nama ?>" required autofocus>
                                        <div class="invalid-feedback">
                                            Masukkan Nama terlebih dahulu
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="username">Username<sup class="text-danger">*</sup></label>
                                        <input id="username" type="text" class="form-control" name="username" tabindex="1" placeholder="Masukkan Username anda" value="<?= $data->username ?>" required>
                                        <div class="invalid-feedback">
                                            Masukkan Username terlebih dahulu
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tgl">Tanggal Lahir<sup class="text-danger">*</sup></label>
                                        <input id="tgl" type="date" class="form-control" name="tgl" value="<?= $data->tgl_lahir ?>" tabindex="1" required>
                                        <div class="invalid-feedback">
                                            Masukkan tanggal lahir terlebih dahulu
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Fakultas<sup class="text-danger">*</sup></label>
                                        <select class="form-control selectric" id="id_fakultas" name="id_fakultas">
                                            <option value="" selected disabled>-- Pilih Fakultas --</option>
                                            <?php
                                            foreach ($fakultas as $d) : ?>
                                                <option <?php if ($data->id_fakultas == $d->id) : echo 'selected'; ?><?php endif; ?> value=<?= $d->id ?>> <?= $d->name ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Program Studi<sup class="text-danger">*</sup></label>
                                        <select class="form-control selectric" id="id_prodi" name="id_prodi">
                                            <option value="" selected disabled>-- Pilih Program Studi --</option>
                                            <?php
                                            foreach ($prodi as $d) : ?>
                                                <option <?php if ($data->id_prodi == $d->id) : echo 'selected'; ?><?php endif; ?> value=<?= $d->id ?>> <?= $d->nama_prodi ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                            Simpan
                                        </button>
                                    </div>
                                </form>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php $this->load->view('dist/_partials/footer'); ?>