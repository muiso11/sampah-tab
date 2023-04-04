<!-- Modal -->
    <div class="modal fade" id="exampleModalLong">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
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
                    <form action="/form/add" method="POST">                            
                    <div class="row">
                        <div class="col-2">
                            <div class="form-group">
                                <label class="col-form-label">Kode Kegiatan</label>
                                <select class="form-control" style="height: 47px;" id="kode_keg">
                                <option> Pilih Kode</option>
                                <?php $kode = NULL;?>
                                    <?php foreach($lovs as $lov):?>
                                        <?php if($kode != $lov['kode_keg']):?>
                                            <option><?= $lov['kode_keg']?></option>
                                        <?php endif;?>
                                        <?php $kode = $lov['kode_keg']?>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label for="dari" class="col-form-label">Dari</label>
                                <input class="form-control" type="time" value="<?= date('H:i')?>" id="dari">
                            </div>
                        </div>                 
                        <div class="col-2">
                            <div class="form-group">
                                <label for="panggil_teknik" class="col-form-label">Panggil Teknik</label>
                                <input class="form-control" type="time" value="<?= date('H:i')?>" id="panggil_teknik">
                            </div>
                        </div>                 
                        <div class="col-2">
                            <div class="form-group">
                                <label for="datang_tekinik" class="col-form-label">Teknik Datang</label>
                                <input class="form-control" type="time" value="<?= date('H:i')?>" id="datang_teknik">
                            </div>
                        </div>                 
                        <div class="col-2">
                            <div class="form-group">
                                <label for="sampai" class="col-form-label">Sampai</label>
                                <input class="form-control" type="time" value="<?= date('H:i')?>" id="sampai">
                            </div>
                        </div>     
                        <div class="col-2">
                            <div class="form-group">
                                <label for="example-text-input" class="col-form-label">Durasi</label>
                                <input class="form-control" type="text" id="durasi" disabled>
                            </div>
                        </div>     
                    <!-- </div>  
                    <div class="row"> -->
                        <div class="col-4">
                            <div class="form-group">
                                <label class="col-form-label">Kegiatan</label>
                                <select class="form-control" style="height: 45px;" id="kegiatan">                                
                                    <!-- <option>Breakdown Mesin ABC Blistering</option>                                         -->
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="example-text-input" class="col-form-label">Masalah</label>
                                <input class="form-control" type="text" id="durasi">                                        
                            </div>                                    
                        </div>  
                        <div class="col-4">
                            <div class="form-group">
                                <label for="example-text-input" class="col-form-label">Tindakan</label>
                                <input class="form-control" type="text" id="durasi">                                        
                            </div>                                    
                        </div>  
                    </div>  

                    <button type="submit" name="submit" id="submit">SUBMIT</button>                        
                </form>
                </div>
            </div>
        </div>
    </div>
<!-- End Modal -->
