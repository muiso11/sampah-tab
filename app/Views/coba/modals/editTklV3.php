<?php foreach($data_form as $dataf) :?>           
    <div class="modal fade" id="edit_<?=$dataf['id']?>">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Edit Modal</h5>                        
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
                    <form action="/coba/edit" method="POST" id="editTKL" onsubmit="return editTKL()">                            
                        <div class="row d-flex justify-content-center" id="hiddenInput">
                            <input type="hidden" value="<?= $dataf['id']?>" name="old_id">      
                            <input type="hidden" value="<?= $dataf['joinkeg']?>" name="joinkeg">                             
                            <?php $j=0; foreach($header as $datas) : ?>                                                
                                <?php if( $j < $longkap):?>
                                    <?php $j++; continue;?>
                                <?php else :?>
                                    <div class="<?=$datas['panjang_inputbox']?>" id="<?=$dataf['id']?>form<?=$datas['nama_header']?>">                            
                                        <div class="form-group">
                                            <label for="<?=$datas['nama_header']?>" class="col-form-label"><?=strtoupper(str_replace('_',' ',$datas['nama_header']));?></label>
                                            <?php if($datas['tipe'] == 'OPTION') : ?>
                                                <select class="form-control" style="height: 47px;" id="<?=$dataf['id']?><?=$datas['nama_header']?>" name="<?=$datas['nama_header']?>">
                                                </select>
                                            <?php elseif($datas['tipe'] == 'TIME'):?>
                                                <input class="form-control" type="time" id="<?=$dataf['id']?><?=$datas['nama_header']?>" name="<?=$datas['nama_header']?>" value="<?=$dataf[$datas['nama_header']];?>">
                                            <?php else:?>                                            
                                                <input class="form-control" type="text" id="<?=$dataf['id']?><?=$datas['nama_header']?>" name="<?=$datas['nama_header']?>" value="<?=$dataf[$datas['nama_header']];?>">
                                            <?php endif;?>
                                        </div>
                                    </div>
                                    
                                <?php endif;?>
                            <?php endforeach;?>
                        </div>  
                        <button type="submit" name="submit" id="buttonEditTKL">SUBMIT</button>                        
                    </form>
                </div>
            </div>
        </div>
    </div>    
<?php endforeach;?>
    <script>             
        // function disableButton(){
        //     let button = document.getElementById("submit");
        //     let form = document.getElementById("editForm");            
        //     let createInput = document.createElement("input");        
                
        //     createInput.type = 'hidden';
        //     createInput.value = oldNo-1;
        //     createInput.name = 'nomor';

        //     formNo.appendChild(createInput);                 
                
        //     durasi.disabled = false;                    
        //     form.submit();
        // }
        try{            
                        
            function isEdit(oldId,oldNo){                   
                // let hiddenInput = document.getElementById("hiddenInput");
                let editmodal = document.getElementById("edit_"+oldId);
                let kode_kegiatan = document.getElementById(oldId+"kode_kegiatan");
                let dari = document.getElementById(oldId+"dari");
                let selesai = document.getElementById(oldId+"selesai");            
                let panggil_teknik = document.getElementById(oldId+"panggil_teknik");            
                let datang_teknik = document.getElementById(oldId+"datang_teknik");            
                let no_schedule = document.getElementById(oldId+"no_schedule");            
                let batch = document.getElementById(oldId+"batch");            
                let kode_produk = document.getElementById(oldId+"kode_produk");            
                let formNo = document.getElementById(oldId+"formno_schedule");            
                let formBatch = document.getElementById(oldId+"formbatch");            
                let formKode = document.getElementById(oldId+"formkode_produk");            
                let good = document.getElementById(oldId+"good");            
                let defect = document.getElementById(oldId+"defect");            
                const aktivitas = document.getElementById(oldId+"aktivitas");            
                let parent = document.getElementById(oldId+"kode_kegiatan");
                let durasi = document.getElementById(oldId+"durasi");                
                let submitButton = document.getElementById("buttonEditTKL");
                                
                // Untuk AJAX
                let xhr = new XMLHttpRequest();
                // Untuk Menyimpan Nilai Sementara
                let kode_sebelum = 0;                    
                let getDurasi = 0;                    
                
                for(let i = 0; i < 10; i++){
                    $("#option_keg").remove();
                    $("#optNo").remove();
                    $("#editNoSchedule").remove();                    
                }
                                
                function getKodeKegiatan(product) {                           
                    // Ini untuk menambah option Pilih kategori karena option di HTML akan otomatis hilang
                    if(kode_sebelum == 0){                                        
                        // hilang karena pembuatan option pada const (syntax dibawah)
                        const awal = document.createElement("option");    

                        awal.textContent = "Pilih";
                        awal.id = "option_keg";
                        parent.appendChild(awal);
                    }                    
                    // tidak tau kenapa tapi harus menggunakan 2 variabel untuk pembuatan option 
                    // Jika hanya 1 maka hanya akan keluar 1 dropdown bukan 2
                    const productLi = document.createElement("option");        
                    
                    // untuk memasukkan text dan value kedalam const
                    productLi.textContent = product.kode_kegiatan;
                    productLi.value = product.kode_kegiatan;                    
                    productLi.id = "option_keg";                    
                    
                    if(product.kode_kegiatan == kode_sebelum){
                        kode_sebelum = product.kode_kegiatan;
                    }else{
                        parent.appendChild(productLi);
                        kode_sebelum = product.kode_kegiatan;                     
                    }
                }

                function getNoSchedule(product){                     
                    if(kode_sebelum == 0){
                        let optPilih            = document.createElement("option");                                    
                        optPilih.textContent    = "Pilih";
                        optPilih.id             = "optNo";         
                        no_schedule.appendChild(optPilih);
                        kode_sebelum = 1;
                    }        
                    let optNoSchedule = document.createElement("option");                                            
    
                    optNoSchedule.textContent   = product.no_schedule;
                    optNoSchedule.value         = product.no_schedule;                                                       
                    optNoSchedule.id         = 'editNoSchedule';
                        
                    no_schedule.appendChild(optNoSchedule);                    
                }                    

                xhr.onreadystatechange = function(){                        
                    if(xhr.readyState == 4 && xhr.status == 200){                        
                        
                        const data = JSON.parse(xhr.responseText);                       
                        data.lov.forEach(product => getKodeKegiatan(product)); 
                        kode_sebelum = 0;                       
                        data.form.forEach(product => getNoSchedule(product));                    
                    }else if(xhr.readyState < 4){    
                        
                    }else{
                        alert("Error Bang, Sebut saya 3x");    
                    }
                }

                xhr.open('GET','http://localhost:8080/coba',true);
                xhr.send();                                                                           
                
                if(oldNo == 2){
                    $("#newNo").remove();
                    $("#newKode").remove();
                    $("#newBatch").remove();

                    let inpNoSchedule   = document.createElement("input");
                    let inpKodeProduk   = document.createElement("input");
                    let inpBatch        = document.createElement("input");                    
    
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
                }                

                no_schedule.addEventListener('change',function(){   
                    $("#optKodeProduk").remove();                
                    $("#optBatch").remove();                
                    let selectNo = this.value;
                    
                    function getBatch(product) {                           
                        console.log(product);                    
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
                });
                kode_kegiatan.addEventListener('change', function() {                       
                    let selectedValue = this.value;                                                                         
                    // Variable untuk membuat element input
                    let inpNoSchedule   = document.createElement("input");
                    let inpKodeProduk   = document.createElement("input");
                    let inpBatch        = document.createElement("input");
    
                    function getAktivitas(product) {                    
                        const optAktivitas = document.createElement("option");        
                        optAktivitas.textContent = product.aktivitas;
                        optAktivitas.value = product.aktivitas;
            
                        // const productUl = document.getElementById(oldId+"halo");
                        // productUl.appendChild(optAktivitas);
                        if(product.kode_kegiatan == selectedValue){
                            if(product.mesinID == 1 || product.mesinID == <?=session()->get('mesinID')?>)
                                getDurasi = product.durasi;
                                aktivitas.appendChild(optAktivitas)
                        }        
                    }            
            
                    xhr.onreadystatechange = function(){
                        if(xhr.readyState == 4 && xhr.status == 200){                            
                            // const newDiv = document.createElement("option");
                            // newDiv.textContent = "This is a new div!";
                            // aktivitas.appendChild(newDiv);
                            const data = JSON.parse(xhr.responseText);
                            aktivitas.textContent = "";
                            data.lov.forEach(product => getAktivitas(product));
                        }else if(xhr.readyState < 4){                        
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
    
                    if(selectedValue == 7 || oldNo == 2){
    
                        // Untuk Menambahkan Element Input Kedalam Halaman WEB Dengan DOM
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
    
                        if(oldNo == 2 && selectedValue != 7){
                            good.disabled = true;
                            defect.disabled = true;
                        }else{
                            good.disabled = false;
                            defect.disabled = false;
                        }
                    }else if(selectedValue == 3){
                        panggil_teknik.disabled = false;
                        datang_teknik.disabled = false;
                    }
                });                    

                editmodal.addEventListener('click', function() {        
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
                    console.log(hitung);
                    
                    durasi.value = hitung;
                    if(hitung > getDurasi || hitung <= 0){
                        submitButton.disabled = true;
                        durasi.style.backgroundColor = "red";
                    }else{
                        durasi.style.backgroundColor = "white";
                        submitButton.disabled = false;
                    }
                });                                
                submitButton.addEventListener('click',function(){                    
                    let createInput = document.createElement("input");
                    createInput.type = 'hidden';
                    createInput.value = oldNo-1;
                    createInput.name = 'nomor';

                    formNo.appendChild(createInput);    
                    durasi.disabled = false;                                    
                });                
            }                                                                        
            
        }catch(error){
            alert("ada error bang, panggil saya"+error);
    }    
</script>