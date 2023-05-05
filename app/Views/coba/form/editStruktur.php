<!-- main content area start -->
<div class="main-content mt-3">
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
                                data-target="#<?=$tittle?>">Tambah
                                Data</button>
                            <!-- <a href="isi_form"><button type="button" class="btn btn-primary mb-3">Tambah Data</button></a> -->
                        </div>
                    </div>
                    <div class="col-12">                    
                        <h4 class="header-title"><?= $tittle?></h4>
                        <div class="single-table">
                            <div class="table-responsive">
                                <table class="table text-center">
                                    <thead class="text-uppercase bg-primary">                                        
                                        <tr class="text-white">   
                                            <th scope="col">NO</th>
                                            <?php $j=0; foreach($header as $datas) : ?>                                                
                                                <?php if( $j < $longkap ):?>
                                                    <?php $j++; continue;?>
                                                <?php else :?>
                                                    <th scope="col"><?= str_replace('_',' ',$datas);?></th>
                                                <?php endif;?>
                                            <?php endforeach;?>
                                            <th scope="col">Kegiatan</th>
                                        </tr>
                                    </thead>
                                    <tbody>                                                                                                                           
                                        <?php $i=1; foreach($body as $datas) : ?>                                            
                                            <tr>
                                                <td><?= $i++;?></td>   
                                                <?php  $j = 0;foreach($datas as $data ) :?>
                                                    <?php if( $j < $longkap ):?>
                                                        <?php $j++; continue;?>
                                                    <?php else :?>                                                    
                                                        <td><?=strtoupper(str_replace('_',' ',$data));?></td>
                                                    <?php endif;?>
                                                <?php endforeach;?>
                                                <?php if($datas['edit'] == 't') :?>
                                                <td>                                                    
                                                    <a href="<?=$tittle?>/delete?id=<?=$datas['id'];?>"><button type="button" class="btn btn-danger mb-3">Hapus</button></a>
                                                    <button type="button" class="btn btn-warning mb-3" data-toggle="modal" data-target="#edit_<?= $datas['id'];?>">Edit</button>
                                                </td>
                                                <?php else :?>
                                                    <td>-</td>
                                                <?php endif;?>
                                            </tr>                                                                                        
                                        <?php endforeach;?>                                                                                
                                    </tbody>
                                </table>
                            </div>
                        </div>                                                                
                    </div> 
                    <div class="col-12">
                        <h4 class="header-title">Panjang Input Box</h4>                         
                        <div class="row">
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="" class="col-form-label">Model 1</label>
                                    <input class="form-control" type="text" id="" name="">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="" class="col-form-label">Model 2</label>
                                    <input class="form-control" type="text" id="" name="">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="" class="col-form-label">Model 3</label>
                                    <input class="form-control" type="text" id="" name="">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="" class="col-form-label">Model 4</label>
                                    <input class="form-control" type="text" id="" name="">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="" class="col-form-label">Model 5</label>
                                    <input class="form-control" type="text" id="" name="">
                                </div>
                            </div>
                        </div>
                    </div>              
                    <div class="col-12">                        
                        <div class="add-button d-flex justify-content-center">
                            <!-- Trigger Modal -->
                            <button type="button" class="btn btn-primary mb-3" data-toggle="modal"
                                data-target="#lov">Tambah
                                Data</button>
                            <!-- <a href="isi_form"><button type="button" class="btn btn-primary mb-3">Tambah Data</button></a> -->
                        </div>
                    </div>
                    <div class="col-12">                    
                        <h4 class="header-title">Lov</h4>
                        <div class="single-table">
                            <div class="table-responsive">
                                <table class="table text-center">
                                    <thead class="text-uppercase bg-primary">                                        
                                        <tr class="text-white">   
                                            <th scope="col">NO</th>                                            
                                            <th scope="col">Kode Kegiatan</th>                                            
                                            <th scope="col">Aktivitas</th>                                            
                                            <th scope="col">Durasi</th>                                            
                                            <th scope="col">Mesin</th>                                            
                                            <th scope="col">Kegiatan</th>
                                        </tr>
                                    </thead>
                                    <tbody>                                                                                                                           
                                        <?php $i=1; foreach($lov as $datas) : ?>                                            
                                            <tr>
                                                <td><?= $i++;?></td>   
                                                <?php  $j = 0;foreach($datas as $data ) :?>
                                                    <?php if( $j < 1 ):?>
                                                        <?php $j++; continue;?>
                                                    <?php else :?>                                                    
                                                        <td><?=strtoupper(str_replace('_',' ',$data));?></td>
                                                    <?php endif;?>
                                                <?php endforeach;?>                                                
                                                <td>                                                    
                                                    <a href="<?=$tittle?>/delete?id=<?=$datas['id'];?>"><button type="button" class="btn btn-danger mb-3">Hapus</button></a>
                                                    <button type="button" class="btn btn-warning mb-3" data-toggle="modal" data-target="#edit_<?= $datas['id'];?>">Edit</button>
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