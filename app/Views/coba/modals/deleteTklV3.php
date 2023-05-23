<?php $i=1;foreach($data_form as $dataf) :?>           
    <div class="modal fade" id="delete_<?=$dataf['id'];$i++?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">                    
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="" style="margin:auto">
                    <img src="<?=base_url('img/DeleteIcon.png')?>" alt="delete icon">
                </div>
                <form action="coba/delete" method="POST">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-center" id="isiDelete">
                                <h5>Konfirmasi Hapus Kegiatan</h5>
                                <input type="hidden" name="oldID" id="oldID" value="<?=$dataf['id']?>">    
                                <input type="hidden" name="oldJoin" id="oldJoin" value="<?=$dataf['joinkeg']?>">                                
                                <input type="hidden" name="nomor" id="nomor" value="<?=$i?>">                                
                            </div>                        
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Hapus Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>    
<?php endforeach;?>    