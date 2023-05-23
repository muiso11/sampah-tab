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
                    <form action="/coba/add" method="POST" id="addTKL" onsubmit="return addTKL()">                            
                    <div class="row d-flex justify-content-center">      
                        <?php $j=0; foreach($header as $datas) : ?>                                                
                            <?php if( $j < $longkap):?>
                                <?php $j++; continue;?>
                            <?php else :?>
                                <div class="<?=$datas['panjang_inputbox']?>" id="form<?=$datas['nama_header']?>">                            
                                   <div class="form-group">
                                        <label for="<?=$datas['nama_header']?>" class="col-form-label"><?=strtoupper(str_replace('_',' ',$datas['nama_header']));?></label>
                                        <?php if($datas['tipe'] == 'OPTION') : ?>
                                            <select class="form-control" style="height: 47px;" id="<?=$datas['nama_header']?>" name="<?=$datas['nama_header']?>">
                                            </select>
                                        <?php elseif($datas['tipe'] == 'TIME'):?>
                                            <input class="form-control" type="time" id="<?=$datas['nama_header']?>" name="<?=$datas['nama_header']?>" value="<?= ($datas['nama_header'] == 'dari' || $datas['nama_header'] == 'selesai' ? $dari : '')?>">
                                        <?php else:?>                                            
                                            <input class="form-control" type="text" id="<?=$datas['nama_header']?>" name="<?=$datas['nama_header']?>">
                                        <?php endif;?>
                                    </div>
                                </div>
                                
                            <?php endif;?>
                        <?php endforeach;?>
                    </div>  
                    <button type="submit" name="submit" id="submitTKL">SUBMIT</button>                        
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
        let formNo = document.getElementById("formno_schedule");            
        let formBatch = document.getElementById("formbatch");            
        let formKode = document.getElementById("formkode_produk");            
        let good = document.getElementById("good");            
        let defect = document.getElementById("defect");            
        let addsubmit = document.getElementById("submitTKL");            
        const aktivitas = document.getElementById("aktivitas");            
        let xhr = new XMLHttpRequest();
        let parent = document.getElementById("kode_kegiatan");
        let kode_sebelum = 0;
        let kodeNo = 0;
        var getDurasi = 0;
    
                
        function getKodeKegiatan(product) {                       
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
        function getNoSchedule(product){                
                if(kodeNo == 0){
                    let optPilih            = document.createElement("option");                                    
                    optPilih.textContent    = "Pilih";
                    optPilih.id             = "optNo";         
                    no_schedule.appendChild(optPilih);
                    kodeNo = 1;
                }        
                let optNoSchedule = document.createElement("option");                                            

                optNoSchedule.textContent   = product.no_schedule;
                optNoSchedule.value         = product.no_schedule;                                                       
                    
                no_schedule.appendChild(optNoSchedule);
            }
    
        xhr.onreadystatechange = function(){            
            if(xhr.readyState == 4 && xhr.status == 200){
                // console.log('ajax ok');                
            
                const data = JSON.parse(xhr.responseText);
                parent.textContent = "";                
                data.lov.forEach(product => getKodeKegiatan(product));
                // console.log(data.form.no_schedule);
                data.form.forEach(product => getNoSchedule(product));
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
            let inpNoSchedule   = document.createElement("input");
            let inpKodeProduk   = document.createElement("input");
            let inpBatch        = document.createElement("input");            
            
            function getAktivitas(product) {
                const optAktivitas = document.createElement("option");        
                optAktivitas.textContent = product.aktivitas;
                optAktivitas.value = product.aktivitas;
    
                // const productUl = document.getElementById("halo");
                // productUl.appendChild(optAktivitas);
                if(product.kode_kegiatan == selectedValue){
                    if(product.mesinID == 1 || product.mesinID == <?=session()->get('mesinID')?>){
                        getDurasi = product.durasi;                        
                        aktivitas.appendChild(optAktivitas);
                    }
                }        
            }            
    
            xhr.onreadystatechange = function(){
                if(xhr.readyState == 4 && xhr.status == 200){                    
                    const data = JSON.parse(xhr.responseText);
                    aktivitas.textContent = "";
                    data.lov.forEach(product => getAktivitas(product));                                        
                }else if(xhr.readyState < 4){
                    console.log();
                }else{
                    alert("Error Bang, Sebut saya 3x");    
                }
            }        
            xhr.open('GET','http://localhost:8080/coba',true);
            xhr.send();            
                        
            $("#newNo").remove();
            $("#newKode").remove();
            $("#newBatch").remove();
            good.disabled = true;
            defect.disabled = true;
            panggil_teknik.disabled = true;
            datang_teknik.disabled = true;
            durasi.disabled = true;
    
            if(selectedValue == 7){        
                inpNoSchedule.placeholder   = "No Schedule Baru";
                inpKodeProduk.placeholder   = "Kode Produk Baru";
                inpBatch.placeholder        = "Batch Baru";
    
                inpNoSchedule.classList   = "form-control";
                inpKodeProduk.classList   = "form-control";
                inpBatch.classList        = "form-control";
                
                inpNoSchedule.id   = "newNo";
                inpKodeProduk.id   = "newKode";
                inpBatch.id        = "newBatch";
    
                inpNoSchedule.name   = "newNo";
                inpKodeProduk.name   = "newKode";
                inpBatch.name        = "newBatch";
                
                formNo.appendChild(inpNoSchedule);
                formKode.appendChild(inpKodeProduk);
                formBatch.appendChild(inpBatch);                                                         
                good.disabled = false;
                defect.disabled = false;
            }else if(selectedValue == 3){
                panggil_teknik.disabled = false;
                datang_teknik.disabled = false;
            }
        });

        no_schedule.addEventListener('change',function(){   
            $("#optKodeProduk").remove();                
            $("#optBatch").remove();                
            let selectNo = this.value;
            
            function getBatch(product) {                           
                // console.log(product);                    
                let optKodeProduk = document.createElement("option");
                let optBatch = document.createElement("option");                           
                
                optKodeProduk.textContent    = product.kode_produk;
                optKodeProduk.value          = product.kode_produk;
                optKodeProduk.id             = "optKodeProduk";
                optBatch.textContent         = product.batch;
                optBatch.value               = product.batch;
                optBatch.id                  = "optBatch";

                if(product.no_schedule == selectNo){                            
                    kode_produk.appendChild(optKodeProduk);
                    batch.appendChild(optBatch);
                }
            }

            xhr.onreadystatechange = function(){
                if(xhr.readyState == 4 && xhr.status == 200){                                                        
                    const data = JSON.parse(xhr.responseText);                            
                    data.form.forEach(product => getBatch(product));                                       
                }else if(xhr.readyState < 4){                        
                }else{
                    alert("Error Bang, Sebut saya 3x");    
                }
            } 
            xhr.open('GET','http://localhost:8080/coba',true);
            xhr.send();
        })
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
            // console.log(total *60);
            let hitung = waktuS[1] - waktuD[1] + total * 60;
            
            document.getElementById("durasi").value = hitung;
            if(hitung > getDurasi || hitung <= 0){
                addsubmit.disabled = true;
                durasi.style.backgroundColor = "red";
            }else{
                durasi.style.backgroundColor = "white";
                addsubmit.disabled = false;
            }
            // console.log(hitung);
        });
        // var selectedValue = selectElement.value;
        // console.log(selectedValue);        
        function addTKL() {
            var submitButton = document.getElementById("submitTKL"); 
            durasi.disabled = false;       
            submitButton.disabled = true;
            return true; // Proceed with form submission
        }
    }catch(error){
        alert("ada error bang, panggil saya");
    }
</script>