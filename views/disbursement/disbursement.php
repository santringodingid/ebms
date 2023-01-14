<?php $this->load->view('partials/header'); ?>
<?php
if ($step[0] != 0) {
    $currentStep = $step[0];
} else {
    $currentStep = 0;
}
?>
<input type="hidden" id="current-step" value="<?= $currentStep ?>">
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content p-3">
        <?php if ($setting == 'CLOSED') { ?>
            <div class="row mt-3">
                <div class="error-page" style="margin-top: 100px;">
                    <div class="error-content">
                        <h3><i class="fas fa-exclamation-triangle text-danger"></i> Oops! ada masalah nih....</h3>
                        <p>
                            Pencairan uang saku baik tunai maupun non-tunai belum dibuka. Segera atur!! ~<br>
                            <br>
                            <a href="<?= base_url() ?>">Kilik untuk kembali ke Beranda</a>
                        </p>

                    </div>
                </div>
            </div>
        <?php } else { ?>
            <div class="row">
                <div class="col-3">
                    <div class="callout callout-success py-1">
                        <i class="fas fa-info-circle"></i>
                        Pencairan uang saku paket - <?= @$currentStep ?>
                    </div>
                </div>
                <div class="col-8" data-toggle="modal" data-target="#modal-detail" id="show-recap"></div>
                <!-- <div class="col-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="far fa-calendar-alt"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control form-control-sm" id="reservation" placeholder="Semua waktu">
                        <input type="hidden" id="start-date" value="">
                        <input type="hidden" id="end-date" value="">
                    </div>
                </div> -->
            </div>
            <hr class="mt-0">
            <div class="row">
                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="nis">NIS <small class="text-success">Tekan F2 untuk fokus inputan NIS</small> </label>
                                <input autofocus data-inputmask="'mask' : '999999999999999'" data-mask="" type="text" class="form-control" id="nis" name="nis">
                            </div>
                            <div class="form-group">
                                <form id="form-disbursement" autocomplete="off">
                                    <input type="hidden" name="package" id="package" value="0">
                                    <input type="hidden" name="nis_save" id="nis-save" value="0">
                                    <label for="nominal">Nominal</label>
                                    <input readonly type="text" class="form-control indonesian-currency" id="nominal" name="nominal">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-8" id="show-data"></div>
            </div>
        <?php } ?>
    </section>
    <!-- /.content -->
</div>


<div class="modal fade" id="modal-detail">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <input type="text" onkeyup="loadData()" id="changeName" class="form-control form-control-sm" placeholder="Cari nama">
            </div>
            <div class="modal-body" id="show-detail" style="min-height: 45vh; max-height: 85vh; overflow: auto"></div>
        </div>
    </div>
</div>
<?php $this->load->view('partials/footer'); ?>
<script src="<?= base_url('template') ?>/plugins/moment/moment.min.js"></script>
<script src="<?= base_url('template') ?>/plugins/daterangepicker/daterangepicker.js"></script>
<?php $this->load->view('disbursement/js-disbursement'); ?>