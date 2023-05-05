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
                    <form action="/<?=$tittle?>/add" method="POST">                            
                    <div class="row d-flex justify-content-center">      
                        <?php $j=0; foreach($header as $datas) : ?>                                                
                            <?php if( $j < $longkap):?>                                                                                                                
                                <?php $j++; continue;?>
                            <?php else :?>
                                <div class="col-2">                            
                                    <div class="form-group">
                                        <label for="<?=$datas?>" class="col-form-label"><?=strtoupper(str_replace('_',' ',$datas));?></label>
                                        <input class="form-control" type="text" id="<?=$datas?>" name="<?=$datas?>">
                                    </div>                                    
                                </div>
                            <?php endif;?>
                        <?php endforeach;?>                                                                                                                     
                    </div>  
                    <button type="submit" name="submit" id="submit">SUBMIT</button>                        
                </form>
                </div>
            </div>
        </div>
    </div>
<!-- End Modal -->
