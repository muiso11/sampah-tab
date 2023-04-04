    <!-- login area start -->
    <div class="login-area">
        <div class="container">
            <div class="login-box ptb--100">
                <form action="login" method="POST">
                    <div class="login-form-head">
                        <h4>Sign In</h4>
                        <p>Hello there, Sign in and start managing your Admin Template</p>
                        <?php if(session()->getFlashdata('error')):?>
                            <div class="alert alert-warning">
                                <?= session()->getFlashdata('error')?>
                            </div>
                        <?php endif;?>
                    </div>
                    <div class="login-form-body">
                        <div class="form-gp">
                            <!-- <label for="nama">Username</label> -->
                            <input type="text" id="nama" name="nama" placeholder="Masukkan Username..." value="<?= session()->getFlashdata('username')?>">
                            <i class="ti-email"></i>
                            <div class="text-danger"></div>
                        </div>
                        <div class="form-gp">
                            <!-- <label for="exampleInputPassword1">Password</label> -->
                            <input type="password" id="password" name="password" placeholder="Masukkan Password...">
                            <i class="ti-lock"></i>
                            <div class="text-danger"></div>
                        </div>
                        <div class="submit-btn-area">
                            <button id="login" type="submit" name="login" value="login">Submit <i class="ti-arrow-right"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- login area end -->
