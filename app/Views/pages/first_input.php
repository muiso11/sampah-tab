<!-- main content area start -->
<div class="main-content">
    <div class="main-content-inner">
        <div class="card">
            <div class="card-body">
                <div class="row no-gutters">
                    <div class="col-12">   
                        <form action="/first/add" method="POST" id="form" onsubmit="return submitForm()">                        
                            <div class="form-group">
                                <label for="tanggal"
                                    class="col-form-label">Tanggal</label>
                                <input class="form-control" type="date" value="<?= date('Y-m-d')?>"
                                    id="tanggal" name="tanggal">
                            </div>
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
                                <input class="form-control" type="text" value="42132"
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
                                <input class="form-control" type="text" value="1242132"
                                    id="batch" name="batch">
                            </div>                        
                            <button type="submit" name="submit" id="firstForm">SUBMIT</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function submitForm() {
        var submitButton = document.getElementById("firstForm");        
        submitButton.disabled = true;
        return true; // Proceed with form submission
    }
</script>