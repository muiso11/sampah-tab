<!-- main content area start -->
<div class="main-content">
    <div class="main-content-inner">
        <div class="card">
            <div class="card-body">
                <div class="row no-gutters">
                    <div class="col-12">                                                
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
                                            <?php foreach($header as $data) :?> 
                                                <th scope="col"><?=$data['nama_header']?></th>
                                            <?php endforeach;?>                                                                                   
                                            <th scope="col">Kegiatan</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=1; foreach($data_form as $datas) : ?>
                                            <tr>
                                                <td><?= $i++;?></td>   
                                                <?php  $j = 0;foreach($datas as $data ) :?>
                                                    <?php if( $j < 5 ):?>
                                                        <?php $j++;?>                                                        
                                                        <?php continue?>
                                                    <?php else :?>
                                                        <td><?= ($data != NULL ? $data : '-');?></td>
                                                    <?php endif;?>
                                                <?php endforeach;?>
                                                <td>
                                                    <div class="d-flex">
                                                        <button type="button" class="btn btn-danger mb-3 mr-2" data-toggle="modal" data-target="#delete_<?=$datas['id'];?>" onclick="isDelete(<?=$i?>)">Hapus</button>
                                                        <button type="button" class="btn btn-warning mb-3" data-toggle="modal" data-target="#edit_<?=$datas['id'];?>" onclick="isEdit(<?=$datas['id'];?>,<?=$i?>,)">Edit Data</button> 
                                                    </div>                                                
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