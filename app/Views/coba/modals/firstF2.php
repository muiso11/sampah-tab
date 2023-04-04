<!-- Modal -->
    <div class="modal fade" id="firstM">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Silahkan Isi Nama</h5>
                    <button type="button" class="close"
                        data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="/form/add" method="POST">                        
                        <div class="form-group">
                            <label for="nama" class="col-form-label">Nama
                                Operator</label>
                            <input class="form-control" type="text" value="Imam"
                                id="nama" name="nama">
                        </div>    
                        <div class="form-group">
                            <label for="shift" class="col-form-label">Shift</label>
                            <input class="form-control" type="text" value="1"
                                id="shift" name="shift">
                        </div>                                            
                        <div class="form-group">
                            <label for="no_schedule" class="col-form-label">Nomor
                                Schedule </label>
                            <input class="form-control" type="text" value="27123612"
                                id="no_schedule" name="no_schedule">
                        </div>
                        <div class="form-group">
                            <label for="kode_produk" class="col-form-label">Kode
                                Produk </label>
                            <input class="form-control" type="text" value="TPGRS"
                                id="kode_produk" name="kode_produk">
                        </div>
                        <div class="form-group">
                            <label for="batch" class="col-form-label">Batch
                                Number</label>
                            <input class="form-control" type="text" value="123122"
                                id="batch" name="batch">
                        </div>                        
                        <button type="submit" name="submit" id="submit">SUBMIT</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!-- End Modal -->
