<!-- main content area start -->
<div class="main-content">
    <div class="main-content-inner">
        <div class="card">
            <div class="card-body" style="height: 80vh;">
                <div class="row no-gutters">
                    <?php $j = 0; for($i = 0;$i<round(count($mesin)/5);$i++):?>
                        <div class="col-12 d-flex justify-content-center ">                                                
                            <div class="add-button d-flex justify-content-center">                                
                                <?php while($j < count($mesin)):?>
                                    <a href="tabel-tkl/<?= $mesin[$j]['mesinID']?>">
                                        <button type="submit" class="btn btn-rounded btn m-2"><?php echo ($mesin[$j]['nama_mesin']);$j++;if($j == 5){break;}?></button>                            
                                    </a>
                                <?php endwhile;?>
                            </div>
                        </div>                     
                    <?php endfor;?>                                                                       
                </div>
            </div>
        </div>
    </div>
</div>
<!-- main content area end -->