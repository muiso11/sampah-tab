<!-- main content area start -->
<div class="main-content">
    <div class="main-content-inner">
        <div class="card">
            <div class="card-body">
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
<div class="halo" id="halo"></div>

<script>
    // Variable untuk mendapatkan elemen ID HTML
    var kode_keg = document.getElementById("kode_keg");
    var dari = document.getElementById("dari");
    var sampai = document.getElementById("sampai");        
    const parentElement = document.getElementById("kegiatan");    
    
    // Melakukan pengambilan data API menggunakan AJAX dan menambahkan elemen option ke HTML
    kode_keg.addEventListener('change', function() {
        // Variable untuk mengaktifkan AJAX
        var xhr = new XMLHttpRequest();
        
        // Variable untuk mengambil value dari kode kegiatan pada html
        let selectedValue = this.value;        

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
    });

    uc.addEventListener('click', function() {
        let sDari = dari.value.split(":");
        let sSampai = sampai.value.split(":");        
        
        let jamD = Math.abs(sDari[0]-12);
        let jamS = Math.abs(sSampai[0]-12);        

        let hitung = (jamS * 60 + sSampai[1] * 1) - (jamD * 60 + sDari[1] * 1)

        document.getElementById("durasi").value = hitung;
        console.log(hitung);
    });
    // var selectedValue = selectElement.value;
    // console.log(selectedValue);


</script>
