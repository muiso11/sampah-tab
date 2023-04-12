<!-- Modal -->
    <div class="modal fade" id="tambahData">
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
                    <form action="/form/add" method="POST" id="myForm">                            
                    <div class="row">
                        <div class="col-2">
                            <div class="form-group">
                                <label class="col-form-label">Kode Kegiatan</label>
                                <select class="form-control" style="height: 47px;" id="kode_keg" name="kode_keg">
                                <option> Pilih Kode</option>
                                <?php $kode = NULL;?>
                                    <?php foreach($lovs as $lov):?>
                                        <?php if($kode != $lov['kode_keg']):?>
                                            <option value="<?= $lov['kode_keg']?>"><?= $lov['kode_keg']?></option>
                                        <?php endif;?>
                                        <?php $kode = $lov['kode_keg']?>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label for="dari" class="col-form-label">Dari</label>
                                <input class="form-control" type="time" value="<?= date('H:i')?>" id="dari" name="dari">
                            </div>
                        </div>                 
                        <div class="col-2">
                            <div class="form-group">
                                <label for="panggil_teknik" class="col-form-label">Panggil Teknik</label>
                                <input class="form-control" type="time" value="" id="panggil_teknik" name="panggil_teknik">
                            </div>
                        </div>                 
                        <div class="col-2">
                            <div class="form-group">
                                <label for="datang_tekinik" class="col-form-label">Teknik Datang</label>
                                <input class="form-control" type="time" value="" id="datang_teknik" name="datang_teknik">
                            </div>
                        </div>                 
                        <div class="col-2">
                            <div class="form-group">
                                <label for="selesai" class="col-form-label">Selesai</label>
                                <input class="form-control" type="time" value="<?= date('H:i')?>" id="selesai" name="selesai">
                            </div>
                        </div>     
                        <div class="col-2">
                            <div class="form-group">
                                <label for="example-text-input" class="col-form-label">Durasi</label>
                                <input class="form-control" type="text" id="durasi" name="durasi" disabled>
                            </div>
                        </div>                         
                        <div class="col-4">
                            <div class="form-group">
                                <label class="col-form-label">Aktivitas</label>
                                <select class="form-control" style="height: 45px;" id="aktivitas" name="aktivitas">                                
                                    <!-- <option>Breakdown Mesin ABC Blistering</option>                                         -->
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="example-text-input" class="col-form-label">Masalah</label>
                                <input class="form-control" type="text" id="masalah" name="masalah">                                        
                            </div>                                    
                        </div>  
                        <div class="col-4">
                            <div class="form-group">
                                <label for="example-text-input" class="col-form-label">Tindakan</label>
                                <input class="form-control" type="text" id="tindakan" name="tindakan">                                        
                            </div>                                    
                        </div>  
                        <div class="col-12">
                            <div class="row d-flex justify-content-center">                            
                                <div class="col-2">
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">No Schedule</label>
                                        <input class="form-control" type="text" name="no_schedule" id="no_schedule" value="<?=$data_awal['no_schedule']?>" disabled>
                                    </div>                                    
                                </div> 
                                <div class="col-2">
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Kode Produk</label>
                                        <input class="form-control" type="text" name="kode_produk" id="kode_produk" value="<?=$data_awal['kode_produk']?>" disabled>                                        
                                    </div>                                    
                                </div> 
                                <div class="col-2">
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Batch Number</label>
                                        <input class="form-control" type="text" name="batch" id="batch" value="<?=$data_awal['batch']?>" disabled>                                        
                                    </div>                                    
                                </div> 
                                <div class="col-2">
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Good</label>
                                        <input class="form-control" type="text" id="good" name="good" value="0">                                        
                                    </div>                                    
                                </div> 
                                <div class="col-2">
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Defect</label>
                                        <input class="form-control" type="text" id="defect" name="defect" value="0">                                        
                                    </div>                                    
                                </div> 
                            </div>
                        </div>
                         
                    </div>  

                    <button type="submit" name="submit"  onclick="enableAndSubmit()" id="submit">SUBMIT</button>                        
                </form>
                </div>
            </div>
        </div>
    </div>
<!-- End Modal -->
<script>
    var modal = document.getElementById("tambahData");
    
    window.onload = function() {
        // $('#exampleModalLong').modal('show')
    }
    // Variable untuk mendapatkan elemen ID HTML
    var kode_keg = document.getElementById("kode_keg");
    var dari = document.getElementById("dari");
    var selesai = document.getElementById("selesai");        
    const parentElement = document.getElementById("aktivitas");   
    let durasi = document.getElementById("durasi"); 
    let no_schedule = document.getElementById('no_schedule');
    let kode_produk = document.getElementById('kode_produk');
    let batch = document.getElementById('batch');
    let selectedValue;

    // Melakukan pengambilan data API menggunakan AJAX dan menambahkan elemen option ke HTML
    kode_keg.addEventListener('change', function() {
        // Variable untuk mengaktifkan AJAX
        var xhr = new XMLHttpRequest();
        
        // Variable untuk mengambil value dari kode kegiatan pada html
        selectedValue = this.value;           

        // url API
        function getUrl(){
            return 'http://localhost:8080/coba';
            // return 'https://www.blibli.com/backend/search/products?searchTerm=android';
        }

        // Untuk melakukan perulangan data yang diambil dari API
        function displayProducts(data) {
                data.forEach(product => displayProduct(product));
        }
        
        function displayProduct(product) {
            const productLi = document.createElement("option");        
            productLi.textContent = product.aktivitas;
            productLi.value = product.aktivitas;

            // const productUl = document.getElementById("halo");
            // productUl.appendChild(productLi);
            if(product.kode_keg == selectedValue){
                parentElement.appendChild(productLi)
            }        
        }

        xhr.onreadystatechange = function(){
            if(xhr.readyState == 4 && xhr.status == 200){
                console.log('ajax ok');                
                // const newDiv = document.createElement("option");
                // newDiv.textContent = "This is a new div!";
                // parentElement.appendChild(newDiv);
                const data = JSON.parse(xhr.responseText);
                parentElement.textContent = "";
                displayProducts(data);
            }
        }
        const url = getUrl('coba');
        xhr.open('GET',url,true);
        xhr.send();
        console.log(selectedValue);

        if(selectedValue == 7){
            no_schedule.disabled = false;
            kode_produk.disabled = false;
            batch.disabled = false;
        }else{
            no_schedule.disabled = true;
            kode_produk.disabled = true;
            batch.disabled = true;
        }
    });

    modal.addEventListener('click', function() {
        let sDari = dari.value.split(":");
        let sSampai = selesai.value.split(":");        
        
        let jamD = Math.abs(sDari[0]-12);
        let jamS = Math.abs(sSampai[0]-12);        

        let hitung = (jamS * 60 + sSampai[1] * 1) - (jamD * 60 + sDari[1] * 1)

        durasi.value = Math.abs(hitung);
        // document.getElementById("durasi").value = Math.abs(hitung);
        console.log(hitung);
    });
    // var selectedValue = selectElement.value;
    // console.log(selectedValue);

    function enableAndSubmit() { 
        no_schedule.disabled = false;
        kode_produk.disabled = false;
        batch.disabled = false;       
        durasi.disabled = false;
        document.getElementById("myForm").submit();
    }
</script>