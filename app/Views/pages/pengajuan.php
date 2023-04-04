<!-- main content area start -->
<div class="main-content">
    <div class="main-content-inner">
        <div class="card">
            <div class="card-body">
                <div class="row no-gutters">                    
                    <div class="col-12">
                        <h4 class="header-title">Pengajuan Edit</h4>
                        <div class="single-table">
                            <div class="table-responsive">
                                <table class="table text-center">
                                    <thead class="text-uppercase bg-primary">
                                        <tr class="text-white">
                                            <th scope="col">Tanggal</th>
                                            <th scope="col">Shift</th>
                                            <th scope="col">Nama Operator</th>
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
                                            <th scope="col">Alasan</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($data_pengajuan as $data) : ?>
                                            <tr>
                                                <th scope="row"><?= $data['tanggal'] ?></th>    
                                                <td><?= $data['shift'] ?></td>    
                                                <td><?= $data['nama'] ?></td>    
                                                <td><?= $data['kode_keg'] ?></td>    
                                                <td><?= $data['mulai'] ?></td>    
                                                <td><?= $data['panggil_teknik'] ?></td>    
                                                <td><?= $data['datang_teknik'] ?></td>    
                                                <td><?= $data['selesai'] ?></td>    
                                                <td><?= $data['durasi'] ?></td>    
                                                <td><?= $data['aktivitas'] ?></td>    
                                                <td><?= $data['masalah'] ?></td>    
                                                <td><?= $data['tindakan'] ?></td>    
                                                <td><?= $data['no_schedule'] ?></td>    
                                                <td><?= $data['kode_produk'] ?></td>    
                                                <td><?= $data['batch'] ?></td>    
                                                <td><?= $data['good'] ?></td>    
                                                <td><?= $data['defect'] ?></td>     
                                                <td><?= $data['alasan'] ?></td>                                                     
                                                <td>
                                                    <button class="btn btn-danger mb-3">Tolak</button>
                                                    <button class="btn btn-success mb-3">Setuju</button>
                                                </td>
                                            </tr>
                                        <?php endforeach;?>                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- main content area end -->



