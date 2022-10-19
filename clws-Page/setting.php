<div class="login_element">
    <b>updating 
Please come back ...</b>
    <!-- <form class="create_form" method="POST" action="">
        <a href="https://erp.cloodo.com/">
            <img src="<?php echo plugins_url('admin/image/worksuite-logo.png', __DIR__)?>" class="worksuite-logo">
        </a>
        <h4 class="title">Hello: <b><?php echo esc_attr(strtoupper($user_login)); ?></b>, welcome to Worksuite</h4>
        <p class="content" style="color:#3e3e3e;font-size: 16px;font-weight: 400;">Have a nice day ! today is : <?php date_default_timezone_set('Asia/Ho_Chi_Minh');echo date('d/m/Y - H:i:s'); ?></p>
            <div class="accountselect">
                <select name="accountselect" class="swap">
                    <?php
                    $result = get_option('clws_info');
                    $tokenId = get_option('clws_token');
                    $dataoption = maybe_unserialize($result);
                    foreach ($dataoption as $row) { ?>
                        <option value="<?php echo $row['token'] ? esc_attr($row['token']) : "" ?>"<?php echo ($tokenId == $row['token']) ? 'selected' : '' ?>><?php echo isset($row['email']) ? esc_attr($row['email']) : '-------------- Select Account -----------' ?></option>
                    <?php } ?>
                </select>
                <button type="button" name="Custom_registration" class="js-getoken btn btn-primary" disabled data-bs-toggle="modal" data-bs-target="#exampleModal3">Account Switch</button>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Account</button>
        </div>
    </form>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header projecttitle">
                    <h4>LOGIN FORM</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="temple" method="post" action="">
                    <div class="modal-body">
                        <div class="mb-3 form-group">
                            <input type="text" required name="email" id="email" value="<?php echo isset($_POST['email']) ? esc_attr($_POST['email']) : ""; ?>"/>
                            <label for="email" class="input">Email</label>
                        </div>
                        <div class="mb-3 form-group">
                            <input type="password" required name="password" id="password" value="<?php echo isset($_POST['password']) ? esc_attr($_POST['password']) : ""; ?>"/>
                            <label for="password" class="input">Password</label>
                        </div>
                            <p data-bs-toggle="modal" data-bs-target="#exampleModal1">Don't have an account? <a href="#" class="text-primary m-l-5 signup"><b>Sign Up</b></a> !</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit"  name="save" class="btn btn-primary js-login">LOGIN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header projecttitle">
                <h4>REGISTER FORM</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <form class="temple" method="post" action="">
                    <div class="modal-body">
                        <div class="mb-3 form-group">
                            <input type="text" required name="company_name" id="company_name" value="<?php echo isset($_POST['company_name']) ? esc_attr($_POST['company_name']) : ""; ?>"/>
                            <label for="company_name" class="input">Company name</label>
                        </div>
                        <div class="mb-3 form-group">
                            <input type="text" required name="email" id="registerEmail" value="<?php echo isset($_POST['email']) ? esc_attr($_POST['email']) : ""; ?>"/>
                            <label for="registerEmail" class="input">Email</label>
                        </div>
                        <div class="mb-3 form-group">
                            <input type="password" required name="password" id="registerPass" value="<?php echo isset($_POST['password']) ? esc_attr($_POST['password']) : ""; ?>"/>
                            <label for="registerPass" class="input">Password</label>
                        </div>
                        <div class="mb-1">
                            <input name="checkbox" required id="terms" type="checkbox" class="checkbox" value="true">
                            <label for="terms" class="checkbox">I agree to<a class="ms-25" href="/">privacy policy &amp; terms</a></label>
                        </div>  
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit"  name="register" class="btn btn-primary js-register">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header projecttitle">
                    <h4>Login to WorkSuite</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="temple" method="post" action="">
                    <div class="modal-body">
                        <div class="clws_iframe">
                            <iframe id="iframeclws" src="<?php echo esc_url(CLWS_IFRAME_URL)?>check-login" width="100%" height="100%" frameborder="0"></iframe>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div> -->
</div>
