<div class="login_element">
    <form class="create_form" method="POST" action="">
        <a href="https://erp.cloodo.com/">
            <img src="<?php echo plugins_url( 'admin/image/worksuite-logo.png', __DIR__ )?>" class="worksuite-logo">
        </a>
        <h4>Hello: <b><?php echo esc_attr(strtoupper($user_login)); ?></b>, welcome to Worksuite</h4>
        <?php if(!empty(get_option('token'))){ ?>
                <p style="color:#3e3e3e;font-size: 16px;font-weight: 400;">Have a nice day ! today is : <?php date_default_timezone_set('Asia/Ho_Chi_Minh'); echo date('d/m/Y - H:i:s'); ?></p>
            <div class="accountselect">
                <select name="accountselect" class="swap">
                    <?php 
                        $result = get_option( 'info' );
                        $tokenId = get_option( 'token' );
                        $dataoption = maybe_unserialize( $result );
                        foreach ( $dataoption as $row ) { ?>
                        <option value="<?php echo $row['token'] ? esc_attr($row['token']) :"" ?>"<?php echo ($tokenId == $row['token'])? 'selected' : '' ?>><?php echo isset($row['email']) ?  esc_attr($row['email']) : '-------------- Select Account -----------' ?></option>
                    <?php } ?>
                </select>
                    <button type="submit"  name="Custom_registration" class="btn btn-primary">Account Switch</button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Account</button>
            </div>
    </form>
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="projecttitle">LOGIN LEAD FORM</h2>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form class="temple" method="post" action="">
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="text" name="email" id="email" value="<?php echo isset($_POST['email']) ? esc_attr($_POST['email']): ""; ?>"/>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" name="password" id="password" value="<?php echo isset($_POST['password']) ? esc_attr($_POST['password']): ""; ?>"/>
                                    </div>
                                        <p data-bs-toggle="modal" data-bs-target="#exampleModal1">Don't have an account? <a href="#" class="text-primary m-l-5 signup"><b>Sign Up</b></a> !</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit"  name="save" class="btn btn-primary">LOGIN</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h2 class="projecttitle">REGISTER LEAD FORM</h2>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                            <form class="temple" method="post" action="">
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="company_name" class="form-label">Company name</label>
                                        <input type="text" name="company_name" id="company_name" value="<?php echo isset($_POST['company_name']) ? esc_attr($_POST['company_name']): ""; ?>"/>
                                    </div>
                                    <div class="mb-3">
                                        <label for="registerEmail" class="form-label">Email</label>
                                        <input type="text" name="email" id="registerEmail" value="<?php echo isset($_POST['email']) ? esc_attr($_POST['email']): ""; ?>"/>
                                    </div>
                                    <div class="mb-3">
                                        <label for="registerPass" class="form-label">Password</label>
                                        <input type="password" name="password" id="registerPass" value="<?php echo isset($_POST['password']) ? esc_attr($_POST['password']): ""; ?>"/>
                                    </div>
                                    <div class="mb-1">
                                        <input name="checkbox" id="terms" type="checkbox" class="checkbox" value="true">
                                        <label for="terms" class="checkbox">I agree to<a class="ms-25" href="/">privacy policy &amp; terms</a></label>
                                    </div>  
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit"  name="register" class="btn btn-primary">Register</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php }else{ ?>
            <form class="create_form" method="POST" action="">
                <p style="color:#3e3e3e;font-size: 16px;font-weight: 400;" class="card-text">We are helping you to connect your website <b><?php echo esc_url(get_bloginfo());?></b> with your Account in Wordpress to sign up for WorkSuite and send Email for You!</p>
                <button type="submit"  name="Register_quickly" class="btn btn-primary">Register quickly !</button>
            </form>
        <?php } ?>
</div>
