<!-- Modal -->
    
    <?php foreach($data_mesin as $data):?>
    <div class="modal fade" id="edit_<?= $data['id']?>">        
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data</h5>
                    <button type="button" class="close"
                        data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info" role="alert">
                        <strong>Perhatikan</strong> Data diatas dengan benar dan
                        sesuai
                        dengan profil anda <br>
                        Jika terdapat kesalahan dapat diubah pada menu
                        <strong>Profil</strong>
                    </div>
                    <form action="/dashboard/edit" method="POST">
                        <input type="hidden" value="<?= $data['id']?>" name="id_data" id="id_data">                                                                        
                        <div class="form-group">
                            <label for="kode_keg" class="col-form-label">Kode
                                Kegiatan </label>
                            <input class="form-control" type="text" value="<?= $data['kode_keg']?>"
                                id="kode_keg" name="kode_keg">
                        </div>
                        <div class="form-group">
                            <label for="dari" class="col-form-label">Dari
                                Jam</label>
                            <input class="form-control" type="time" value="<?= $data['dari']?>"
                                id="dari" name="dari">
                        </div>
                        <div class="form-group">
                            <label for="panggil_teknik" class="col-form-label">Panggil
                                Teknik</label>
                            <input class="form-control" type="time" value="<?= $data['panggil_teknik']?>"
                                id="panggil_teknik" name="panggil_teknik">
                        </div>
                        <div class="form-group">
                            <label for="datang_teknik" class="col-form-label">Teknik
                                Datang</label>
                            <input class="form-control" type="time" value="<?= $data['datang_teknik']?>"
                                id="datang_teknik" name="datang_teknik">
                        </div>
                        <div class="form-group">
                            <label for="selesai" class="col-form-label">Sampai
                                Jam</label>
                            <input class="form-control" type="time" value="<?= $data['selesai']?>"
                                id="selesai" name="selesai">
                        </div>                                                
                        <div class="form-group">
                            <label for="durasi" class="col-form-label">Durasi Menit</label>
                            <input class="form-control" type="text" value="<?= $data['durasi']?>"
                                id="durasi" name="durasi">
                        </div>
                        <div class="form-group">
                            <label for="aktivitas" class="col-form-label">Aktivitas
                                Kegiatan </label>
                            <input class="form-control" type="text" value="<?= $data['aktivitas']?>"
                                id="aktivitas" name="aktivitas">
                        </div>
                        <div class="form-group">
                            <label for="masalah" class="col-form-label">Masalah
                                Kegiatan </label>
                            <textarea class="form-control" name="masalah" id="masalah"  
                                aria-label="With textarea"><?= $data['masalah']?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="tindakan" class="col-form-label">Tindakan
                            </label>
                            <textarea class="form-control" name="tindakan" id="tindakan"
                                aria-label="With textarea"><?= $data['tindakan']?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="no_schedule" class="col-form-label">Nomor
                                Schedule </label>
                            <input class="form-control" type="text" value="<?= $data['no_schedule']?>"
                                id="no_schedule" name="no_schedule">
                        </div>
                        <div class="form-group">
                            <label for="kode_produk" class="col-form-label">Kode
                                Produk </label>
                            <input class="form-control" type="text" value="<?= $data['kode_produk']?>"
                                id="kode_produk" name="kode_produk">
                        </div>
                        <div class="form-group">
                            <label for="batch" class="col-form-label">Batch
                                Number</label>
                            <input class="form-control" type="text" value="<?= $data['batch']?>"
                                id="batch" name="batch">
                        </div>
                        <div class="form-group">
                            <label for="good" class="col-form-label">Good</label>
                            <input class="form-control" type="text" value="<?= $data['good']?>"
                                id="good" name="good">
                        </div>
                        <div class="form-group">
                            <label for="defect"
                                class="col-form-label">Defect</label>
                            <input class="form-control" type="text" value="<?= $data['defect']?>"
                                id="defect" name="defect">
                        </div>
                        <button type="submit" name="submit" id="submit">SUBMIT</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach;?>
<!-- End Modal -->