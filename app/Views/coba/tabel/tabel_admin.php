<!-- main content area start -->
<div class="main-content">
    <div class="main-content-inner">
        <div class="card">
            <div class="card-body">
                <div class="row no-gutters">
                    <div class="col-12">                                                
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
                                                <?php if($session == 1) : ?>
                                                    <th scope="col">Kegiatan</th>                                                
                                                <?php endif;?>
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
                                                        <?php if($session == 1) : ?>
                                                            <button type="button" class="btn btn-warning mb-3" data-toggle="modal" data-target="#edit_<?= $data['id']?>">Edit Data</button>
                                                                                                                    
                                                        <?php endif;?>
                                                    </td>
                                                </tr>                                            
                                            <?php endforeach;?>                                                                                
                                        </tbody>
                                    </table>
                                </div>
                            </div>                        
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- main content area end -->