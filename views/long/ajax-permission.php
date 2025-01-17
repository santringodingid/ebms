<?php
    if ($permissions) {
        $text = [
            'ACTIVE' => 'Aktif',
            'DISCIPLINE' => 'Disiplin',
            'LATE' => 'Terlambat',
			'LATE-DONE' => 'Lambat',
            'EXTENDED' => 'Diperpanjang'
        ];

		$textPayment = [
			'POCKET' => 'Uang saku',
			'CASH' => 'Tunai'
		];
    foreach ($permissions as $permission) {
        $avatarPath = FCPATH . 'assets/avatars/' . $permission->student_id . '.jpg';

        if (file_exists($avatarPath) === FALSE || $avatarPath == NULL) {
            $avatar = base_url('assets/avatars/default.jpg');
        } else {
            $avatar = base_url('assets/avatars/' . $permission->student_id . '.jpg');
        }

        $city = str_replace(['Kabupaten', 'Kota '], '', $permission->city);

		$status = $permission->status;
		if ($status === 'LATE' || $status === 'LATE-DONE') {
			$textStatus = showDiff($permission->expired_at, $permission->checked_at);
		} else {
			$textStatus = '';
		}
?>
<div class="col-12">
    <div class="card mb-2" style="height: 65px;">
        <div class="card-body p-0">
            <div class="row h-100 ml-0">
                <div class="col-1 h-100 px-0">
                    <img class="h-100" src="<?= $avatar ?>" alt="IMAGE OF <?= $permission->name ?>" style="border-top-left-radius: 0.25rem; border-bottom-left-radius: 0.25rem;">
                </div>
                <div class="col-11 pl-0">
					<div class="row py-2">
						<div class="col-4">
							<span class="align-middle font-weight-bold"><?= $permission->name ?></span>
							<br>
							<span class="text-muted">
								<?= $permission->village ?>, <?= $city ?>
							</span>
						</div>
						<div class="col-3">
							<span class="align-middle">
								<?= $permission->class.' - '.$permission->level ?> |
								<?= $permission->class_of_formal.' - '.$permission->level_of_formal ?>
							</span>
							<br>
							<span class="text-muted">
								<?= $permission->domicile ?>
							</span>
						</div>
						<div class="col-3">
							<span class="align-middle">Tempo :
								<small class="text-primary">
									<?= datetimeIDShirtFormat($permission->expired_at) ?>
								</small>
							</span>
							<br>
							<span class="text-muted">
								<?= $permission->reason ?>
							</span>
						</div>
						<div class="col-2 pr-4 pt-1 text-right">
							<?php
							if (!$permission->checked_at) {
							?>
							<div class="dropdown pt-1">
								<a class="btn btn-default dropdown-toggle btn-sm btn-block" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Opsi
								</a>

								<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
									<?php
									if ($permission->status === 'PROCESS') {
										?>
										<a class="dropdown-item" target="_blank" href="<?= base_url() ?>long/petition/<?= encrypt_url($permission->id) ?>">Print Angket</a>
										<span class="dropdown-item" style="cursor: pointer" onclick="doActive(<?= $permission->id ?>)">Aktifkan</span>
										<?php
									}elseif ($permission->status === 'ACTIVE') {
										?>
										<a class="dropdown-item" target="_blank" href="<?= base_url() ?>long/license/<?= encrypt_url($permission->id) ?>">Print Surat</a>
										<span class="dropdown-item" style="cursor: pointer" onclick="doBack(<?= $permission->id ?>)">Selesaikan</span>
										<?php
									}elseif ($permission->status === 'LATE') {
										?>
										<span class="dropdown-item" style="cursor: pointer" onclick="doPunishment(<?= $permission->student_id ?>, <?= $permission->id ?>)">Tindakan</span>
										<?php
									}else {
										echo '';
									}
									?>
								</div>
							</div>
							<?php
							}else{
							?>
								<small>
                                        <span class="align-middle">
                                            <?= datetimeIDShirtFormat($permission->checked_at) ?>
                                        </span>
									<div class="text-muted">
										<?= $text[$permission->status] . ' ' . $textStatus; ?>
									</div>
								</small>
							<?php
							}
							 ?>
						</div>
					</div>
                </div>
			</div>
        </div>
    </div>
</div>
<?php
    }
}else{
?>
<div class="col-12 text-center text-danger pt-5">
    <div class="mb-3">
        <i class="fas fa-exclamation fa-4x"></i>
    </div>
    <h6>Tidak ada data untuk ditampilkan</h6>
</div>
<?php
}
?>
