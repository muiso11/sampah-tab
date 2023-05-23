<!-- Modal -->
    <div class="modal fade" id="<?=$tittle?>">
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
                    <form action="/<?=$tittle?>/add" method="POST">                            
                    <div class="row d-flex justify-content-center">      
                        <?php $j=0; foreach($header as $datas) : ?>                                                
                            <?php if( $j < $longkap):?>
                                <?php $j++; continue;?>
                            <?php else :?>
                                <div class="<?=$datas['panjang_inputbox']?>">                            
                                    <div class="form-group">
                                        <label for="<?=$datas['nama_header']?>" class="col-form-label"><?=strtoupper(str_replace('_',' ',$datas['nama_header']));?></label>
                                        <?php if($datas['tipe'] == 'OPTION') : ?>
                                            <select class="form-control" style="height: 47px;" id="<?=$datas['nama_header']?>" name="<?=$datas['nama_header']?>">
                                            </select>
                                        <?php elseif($datas['tipe'] == 'TIME'):?>
                                            <input class="form-control" type="time" id="<?=$datas['nama_header']?>" name="<?=$datas['nama_header']?>" value="<?=date('H:i')?>">
                                        <?php else:?>                                            
                                            <input class="form-control" type="text" id="<?=$datas['nama_header']?>" name="<?=$datas['nama_header']?>">
                                        <?php endif;?>
                                    </div>
                                </div>
                                
                            <?php endif;?>
                        <?php endforeach;?>
                    </div>  
                    <button type="submit" name="submit" id="submit" onclick="enableAndSubmit()">SUBMIT</button>                        
                </form>
                </div>
            </div>
        </div>
    </div>
<!-- End Modal -->
<script>
    try{

        // Variable untuk mendapatkan elemen ID HTML
        let modal = document.getElementById('<?=$tittle?>');    
        let kode_kegiatan = document.getElementById("kode_kegiatan");
        let dari = document.getElementById("dari");
        let selesai = document.getElementById("selesai");            
        let panggil_teknik = document.getElementById("panggil_teknik");            
        let datang_teknik = document.getElementById("datang_teknik");            
        let no_schedule = document.getElementById("no_schedule");            
        let batch = document.getElementById("batch");            
        let kode_produk = document.getElementById("kode_produk");            
        let good = document.getElementById("good");            
        let defect = document.getElementById("defect");            
        const parentElement = document.getElementById("aktivitas");            
        let xhr = new XMLHttpRequest();
        let parent = document.getElementById("kode_kegiatan");
        let kode_sebelum = 0;
    
        
        function displayProducts(data) {
                data.lov.forEach(product => displayProduct(product));
        }    
        function displayProduct(product) {
            console.log(product);
            // Ini untuk menambah option Pilih kategori karena option di HTML akan otomatis hilang
            if(kode_sebelum == 0){
                // hilang karena pembuatan option pada const (syntax dibawah)
                const awal = document.createElement("option");
    
                awal.textContent = "Pilih";
                parent.appendChild(awal);
            }
            // tidak tau kenapa tapi harus menggunakan 2 variabel untuk pembuatan option 
            // Jika hanya 1 maka hanya akan keluar 1 dropdown bukan 2
            const productLi = document.createElement("option");        
    
            // untuk memasukkan text dan value kedalam const
            productLi.textContent = product.kode_kegiatan;
            productLi.value = product.kode_kegiatan;        
            
            if(product.kode_kegiatan == kode_sebelum){
                kode_sebelum = product.kode_kegiatan;
            }else{
                parent.appendChild(productLi);
                kode_sebelum = product.kode_kegiatan;                     
            }
        }
    
        xhr.onreadystatechange = function(){            
            if(xhr.readyState == 4 && xhr.status == 200){
                console.log('ajax ok');                
            
                const data = JSON.parse(xhr.responseText);
                parent.textContent = "";                
                displayProducts(data);
            }else if(xhr.readyState < 4){
                console.log();
            }else{
                alert("Error Bang, Sebut saya 3x");    
            }
        }                
        xhr.open('GET','http://localhost:8080/coba',true);
        xhr.send();                                
                
        // Function dibawah Melakukan pengambilan data API menggunakan AJAX dan menambahkan elemen option ke HTML
        // akan aktif ketika ada perubahan pada id kode_kegiatan
        kode_kegiatan.addEventListener('change', function() {        
            let selectedValue = this.value;                
    
            // Untuk melakukan perulangan data yang diambil dari API
            function displayProducts(data) {
                    data.lov.forEach(product => displayProduct(product));
            }
            
            function displayProduct(product) {
                const productLi = document.createElement("option");        
                productLi.textContent = product.aktivitas;
                productLi.value = product.aktivitas;
    
                // const productUl = document.getElementById("halo");
                // productUl.appendChild(productLi);
                if(product.kode_kegiatan == selectedValue){
                    if(product.mesinID == 1 || product.mesinID == <?=session()->get('mesinID')?>)
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
                }else if(xhr.readyState < 4){
                console.log();
                }else{
                    alert("Error Bang, Sebut saya 3x");    
                }
            }        
            xhr.open('GET','http://localhost:8080/coba',true);
            xhr.send();
            console.log(selectedValue);
    
            no_schedule.disabled = true;
            batch.disabled = true;
            kode_produk.disabled = true;
            good.disabled = true;
            defect.disabled = true;
            panggil_teknik.disabled = true;
            datang_teknik.disabled = true;
            durasi.disabled = true;
    
            if(selectedValue == 7){
                no_schedule.disabled = false;
                batch.disabled = false;
                kode_produk.disabled = false;
                good.disabled = false;
                defect.disabled = false;
            }else if(selectedValue == 3){
                panggil_teknik.disabled = false;
                datang_teknik.disabled = false;
            }
        });
        
        modal.addEventListener('click', function() {        
            let waktuD = dari.value.split(":");
            let waktuS = selesai.value.split(":");
            let total;
            if(waktuD[0] > waktuS[0]){
                if(waktuD[0] <= 12){
                    let jamD = parseInt(waktuD[0]);
                    let jamS = parseInt(waktuS[0]);
                    total = (jamS + 12 - jamD);                    
                }else{
                    let jamD = parseInt(waktuD[0]);
                    let jamS = parseInt(waktuS[0]);
                    total = (jamS + 24 - jamD);                    
                }
            }else{
                let jamD = parseInt(waktuD[0]);                
                let jamS = parseInt(waktuS[0]);                        
                total = jamS - jamD;                            
            }            
            console.log(total *60);
            let hitung = Math.abs(waktuS[1] - waktuD[1] + total * 60);
            
            document.getElementById("durasi").value = hitung;
            // console.log(hitung);
        });
        // var selectedValue = selectElement.value;
        // console.log(selectedValue);
        function enableAndSubmit() {                 
            durasi.disabled = false;
            document.getElementById("myForm").submit();
        }
        
    }catch(error){
        alert("ada error bang, panggil saya");
    }
</script>