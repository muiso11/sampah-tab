<!-- main content area start -->
<div class="main-content">
    <div class="main-content-inner">
        <div class="card">
            <div class="card-body">
                <div class="row no-gutters">
                    <div class="col-12">                        
                        <div class="add-button d-flex justify-content-center">
                            <!-- Trigger Modal -->
                            <!-- <button type="button" class="btn btn-primary mb-3" data-toggle="modal"
                                data-target="#exampleModalLong">Tambah
                                Data</button> -->
                            <a href="isi_form"><button type="button" class="btn btn-primary mb-3">Tambah Data</button></a>
                        </div>
                    </div>
                    <div class="col-12">
                        <?php if($data_mesin):?> 
                        <h4 class="header-title">Tabel Haha Hihi</h4>
                        <div class="single-table">
                            <div class="table-responsive">
                                <table class="table text-center">
                                    <thead class="text-uppercase bg-primary">
                                        <tr class="text-white">   
                                            <th scope="col">No</th>                                         
                                            <th scope="col">Kode Keg</th>
                                            <th scope="col">Dari Jam</th>
                                            <th scope="col">Panggil Teknik</th>
                                            <th scope="col">Teknik Datang</th>
                                            <th scope="col">Sampai Jam</th>
                                            <th scope="col">Durasi (Menit)</th>
                                            <th scope="col">Aktivitas Kegiatan</th>
                                            <th scope="col">Masalah</th>
                                            <th scope="col">Tindakan</th>
                                            <th scope="col">Nomor Schedule</th>
                                            <th scope="col">Kode Produk</th>
                                            <th scope="col">Batch Number</th>
                                            <th scope="col">Good</th>
                                            <th scope="col">Defect</th>                                            
                                            <th scope="col">Kegiatan</th>
                                        </tr>
                                    </thead>
                                    <tbody>                                        
                                                                                   
                                        <?php $i=1; foreach($data_mesin as $data) : ?>
                                            <tr>
                                                <td><?= $i++;?></td>                 
                                                <td><?= ($data['kode_keg'] == NULL)?'-':$data['kode_keg']?></td>                
                                                <td><?= ($data['dari'] == NULL)?'-':$data['dari']?></td>                
                                                <td><?= ($data['panggil_teknik'] == NULL)?'-':$data['panggil_teknik']?></td>                
                                                <td><?= ($data['datang_teknik'] == NULL)?'-':$data['datang_teknik']?></td>                
                                                <td><?= ($data['selesai'] == NULL)?'-':$data['selesai']?></td>                
                                                <td><?= ($data['durasi'] == NULL)?'-':$data['durasi']?></td>                
                                                <td><?= ($data['aktivitas'] == NULL)?'-':$data['aktivitas']?></td>                
                                                <td><?= ($data['masalah'] == NULL)?'-':$data['masalah']?></td>                
                                                <td><?= ($data['tindakan'] == NULL)?'-':$data['tindakan']?></td>                
                                                <td><?= ($data['no_schedule'] == NULL)?'-':$data['no_schedule']?></td>                
                                                <td><?= ($data['kode_produk'] == NULL)?'-':$data['kode_produk']?></td>                
                                                <td><?= ($data['batch'] == NULL)?'-':$data['batch']?></td>                
                                                <td><?= ($data['good'] == NULL)?'-':$data['good']?></td>                
                                                <td><?= ($data['defect'] == NULL)?'-':$data['defect']?></td>                                                                                                                  
                                                <td>
                                                    <?php if($data['status'] == 1) : ?>
                                                        <button type="button" class="btn btn-warning mb-3" data-toggle="modal" data-target="#edit_<?= $data['id']?>">Edit Data</button>
                                                    <?php else :?>
                                                        <?= $data['keterangan']?>
                                                    <?php endif;?>
                                                </td>
                                            </tr>                                            
                                        <?php endforeach;?>                                                                                
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <form action="">                            
                            <div class="d-flex justify-content-around mt-4">
                                <div class="form-group d-flex">
                                    <label for="tanggal" class="col-form-label" style="margin-right: 20px;">Tanggal: </label>
                                    <input class="form-control" type="date" value="<?= date('Y-m-d')?>" id="tanggal" name="tanggal">
                                </div>
                                <div class="form-group d-flex">
                                    <label for="shift" class="col-form-label" style="margin-right: 20px;">Shift: </label>
                                    <input class="form-control" type="text" id="shift" name="shift" placeholder="<?= $data_mesin[0]['shift']?>">
                                </div>
                                <div class="form-group d-flex">
                                    <label for="nama" class="col-form-label" style="margin-right: 20px;">Nama: </label>
                                    <input class="form-control" type="text" id="nama" name="nama" placeholder="<?= $data_mesin[0]['nama']?>">
                                </div>
                                <button class="btn btn-success" style="height:45px">Submit!!</button>                                                          
                            </div>
                        </form>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- main content area end -->
<script>
    var modal = document.getElementById("firstM");    
    
    window.onload = function() {
        $('#firstM').modal('show')
    }
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

    modal.addEventListener('click', function() {
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