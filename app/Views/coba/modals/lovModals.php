<!-- Modal -->
    <div class="modal fade" id="lov">
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
                    <form action="/lov/add" method="POST">                            
                    <div class="row d-flex justify-content-center">      
                        <div class="col-2">                            
                            <div class="form-group">
                                <label for="" class="col-form-label">Kode Kegiatan</label>
                                <input class="form-control" type="text" id="kode_kegiatan" name="kode_kegiatan">
                            </div>                                    
                        </div>                            
                        <div class="col-2">                            
                            <div class="form-group">
                                <label for="" class="col-form-label">Aktivitas</label>
                                <input class="form-control" type="text" id="aktivitas" name="aktivitas">
                            </div>                                    
                        </div>                            
                        <div class="col-2">                            
                            <div class="form-group">
                                <label for="" class="col-form-label">Durasi</label>
                                <input class="form-control" type="text" id="durasi" name="durasi">
                            </div>                                    
                        </div>                            
                        <div class="col-2">                            
                            <div class="form-group">
                                <label for="" class="col-form-label">Mesin</label>
                                <input class="form-control" type="text" id="mesin" name="mesin">
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
