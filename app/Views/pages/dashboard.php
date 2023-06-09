<!-- main content area start -->
<div class="main-content">
    <div class="main-content-inner">
        <div class="card">
            <div class="card-body">
                <div class="row no-gutters">
                    <?php if(session()->getFlashdata() == !NULL): ?>
                    <div class="col-12">                        
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong><?= session()->getFlashdata('pesan');?></strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span class="fa fa-times"></span>
                            </button>
                        </div>
                    </div>
                    <?php endif;?>
                    <div class="col-12">                        
                        <div class="add-button d-flex justify-content-center">
                            <!-- Trigger Modal -->
                            <button type="button" class="btn btn-primary mb-3" data-toggle="modal"
                                data-target="#tambahData">Tambah
                                Data</button>
                            <!-- <a href="isi_form"><button type="button" class="btn btn-primary mb-3">Tambah Data</button></a> -->
                        </div>
                    </div>
                    <div class="col-12">
                        <?php if($data_form):?> 
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
                                        <?php $i=1; foreach($data_form as $datas) : ?>
                                            <tr>
                                                <td><?= $i++;?></td>   
                                                <?php  $j = 0;foreach($datas as $data ) :?>
                                                    <?php if( $j < 4 ):?>
                                                        <?php $j++;?>                                                        
                                                        <?php continue?>
                                                    <?php else :?>
                                                        <td><?= ($data);?></td>
                                                    <?php endif;?>
                                                <?php endforeach;?>
                                                <td>                                                
                                                        <button type="button" class="btn btn-warning mb-3" data-toggle="modal" data-target="#edit?<?= $datas['id'];?>>">Edit Data</button>                                                    
                                                </td>
                                            </tr>                                                   
                                        <?php endforeach;?>
                                                                                                             
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <form action="form/fix" method="GET">                            
                            <div class="d-flex justify-content-around mt-4">
                                <div class="form-group d-flex">
                                    <label for="tanggal" class="col-form-label" style="margin-right: 20px;">Tanggal: </label>
                                    <input class="form-control" type="date" value="<?= date('Y-m-d')?>" id="tanggal" name="tanggal">
                                </div>
                                <div class="form-group d-flex">
                                    <label for="shift" class="col-form-label" style="margin-right: 20px;">Shift: </label>
                                    <input class="form-control" type="text" id="shift" name="shift" placeholder="">
                                </div>
                                <div class="form-group d-flex">
                                    <label for="nama" class="col-form-label" style="margin-right: 20px;">Nama: </label>
                                    <input class="form-control" type="text" id="nama" name="nama" placeholder="">
                                </div>
                                <input type="hidden" name="status" id="status" value="TRUE">
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