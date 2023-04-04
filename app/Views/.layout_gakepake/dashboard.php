<?= $this->extend('layout/template');?>

<?= $this->section('content');?>
<!-- main content area start -->
<div class="main-content">
    <div class="main-content-inner">
        <div class="card">
            <div class="card-body">
                <div class="row no-gutters">
                    <div class="col-12">                        
                        <div class="add-button d-flex justify-content-center">
                            <!-- Trigger Modal -->
                            <button type="button" class="btn btn-primary mb-3" data-toggle="modal"
                                data-target="#exampleModalLong">Tambah
                                Data</button>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModalLong">
                                <div class="modal-dialog">
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
                                            <form action="/dashboard/add" method="POST">
                                                
                                                <div class="form-group">
                                                    <label for="tanggal"
                                                        class="col-form-label">Tanggal</label>
                                                    <input class="form-control" type="date" value="2018-03-05"
                                                        id="tanggal" name="tanggal">
                                                </div>
                                                <div class="form-group">
                                                    <label for="shift" class="col-form-label">Shift</label>
                                                    <input class="form-control" type="text" value="1"
                                                        id="shift" name="shift">
                                                </div>
                                                <div class="form-group">
                                                    <label for="nama" class="col-form-label">Nama
                                                        Operator</label>
                                                    <input class="form-control" type="text" value="1"
                                                        id="nama" name="nama">
                                                </div>
                                                <div class="form-group">
                                                    <label for="kode_keg" class="col-form-label">Kode
                                                        Kegiatan </label>
                                                    <input class="form-control" type="text" value="1"
                                                        id="kode_keg" name="kode_keg">
                                                </div>
                                                <div class="form-group">
                                                    <label for="mulai" class="col-form-label">Dari
                                                        Jam</label>
                                                    <input class="form-control" type="time" value="13:45:00"
                                                        id="mulai" name="mulai">
                                                </div>
                                                <div class="form-group">
                                                    <label for="panggil_teknik" class="col-form-label">Panggil
                                                        Teknik</label>
                                                    <input class="form-control" type="time" value="13:45:00"
                                                        id="panggil_teknik" name="panggil_teknik">
                                                </div>
                                                <div class="form-group">
                                                    <label for="datang_teknik" class="col-form-label">Teknik
                                                        Datang</label>
                                                    <input class="form-control" type="time" value="13:45:00"
                                                        id="datang_teknik" name="datang_teknik">
                                                </div>
                                                <div class="form-group">
                                                    <label for="selesai" class="col-form-label">Sampai
                                                        Jam</label>
                                                    <input class="form-control" type="time" value="13:45:00"
                                                        id="selesai" name="selesai">
                                                </div>                                                
                                                <div class="form-group">
                                                    <label for="durasi" class="col-form-label">Durasi Menit</label>
                                                    <input class="form-control" type="text" value="1"
                                                        id="durasi" name="durasi">
                                                </div>
                                                <div class="form-group">
                                                    <label for="aktivitas" class="col-form-label">Aktivitas
                                                        Kegiatan </label>
                                                    <input class="form-control" type="text" value="1"
                                                        id="aktivitas" name="aktivitas">
                                                </div>
                                                <div class="form-group">
                                                    <label for="masalah" class="col-form-label">Masalah
                                                        Kegiatan </label>
                                                    <textarea class="form-control" name="masalah" id="masalah"
                                                        aria-label="With textarea"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="tindakan" class="col-form-label">Tindakan
                                                    </label>
                                                    <textarea class="form-control" name="tindakan" id="tindakan"
                                                        aria-label="With textarea"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="no_schedule" class="col-form-label">Nomor
                                                        Schedule </label>
                                                    <input class="form-control" type="text" value="1"
                                                        id="no_schedule" name="no_schedule">
                                                </div>
                                                <div class="form-group">
                                                    <label for="kode_produk" class="col-form-label">Kode
                                                        Produk </label>
                                                    <input class="form-control" type="text" value="1"
                                                        id="kode_produk" name="kode_produk">
                                                </div>
                                                <div class="form-group">
                                                    <label for="batch" class="col-form-label">Batch
                                                        Number</label>
                                                    <input class="form-control" type="text" value="1"
                                                        id="batch" name="batch">
                                                </div>
                                                <div class="form-group">
                                                    <label for="good" class="col-form-label">Good</label>
                                                    <input class="form-control" type="text" value="1"
                                                        id="good" name="good">
                                                </div>
                                                <div class="form-group">
                                                    <label for="defect"
                                                        class="col-form-label">Defect</label>
                                                    <input class="form-control" type="text" value="1"
                                                        id="defect" name="defect">
                                                </div>
                                                <button type="submit" name="submit" id="submit">SUBMIT</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Modal -->
                        </div>
                    </div>
                    <div class="col-12">
                        <h4 class="header-title">Tabel Haha Hihi</h4>
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
                                            <th scope="col">Keterangan</th>
                                            <th scope="col">Kegiatan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($data_mesin as $data) : ?>
                                            <tr>
                                                <th scope="row"><?= $data->tanggal ?></th>    
                                                <td><?= $data->shift ?></td>    
                                                <td><?= $data->nama ?></td>    
                                                <td><?= $data->kode_keg ?></td>    
                                                <td><?= $data->mulai ?></td>    
                                                <td><?= $data->panggil_teknik ?></td>    
                                                <td><?= $data->datang_teknik ?></td>    
                                                <td><?= $data->selesai ?></td>    
                                                <td><?= $data->durasi ?></td>    
                                                <td><?= $data->aktivitas ?></td>    
                                                <td><?= $data->masalah ?></td>    
                                                <td><?= $data->tindakan ?></td>    
                                                <td><?= $data->no_schedule ?></td>    
                                                <td><?= $data->kode_produk ?></td>    
                                                <td><?= $data->batch ?></td>    
                                                <td><?= $data->good ?></td>    
                                                <td><?= $data->defect ?></td>    
                                                <td><?= $data->keterangan ?></td>    
                                                <td><button type="button" class="btn btn-warning" >Edit</button></td>
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
<!-- footer area start-->
<?= $this->endSection();?>


