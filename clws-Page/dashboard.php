<?php 
    // update_option('admin_email','hoanl1a121test@gmail.test.com');
    // delete_option( 'token' );
    // delete_option( 'info' );
    if (!empty(get_option('token'))) { ?>
    <div class="clws_iframe">
        <iframe id="iframeclws" src="<?php echo esc_url(CLWS_IFRAME_URL)?>check-login" width="100%" height="100%" frameborder="0"></iframe>
    </div>
    <?php } else {?>
        <div class="login_element">
            <form class="create_form" method="POST" action="">
                <a href="https://erp.cloodo.com/">
                    <img src="<?php echo plugins_url('admin/image/worksuite-logo.png', __DIR__)?>" class="worksuite-logo">
                </a>
                <h4 class="title">Hello: <b><?php echo esc_attr(strtoupper($user_login)); ?></b>, welcome to Worksuite</h4>
                <p style="color:#3e3e3e;font-size: 16px;font-weight: 400;" class="card-text">We are helping you to connect your website <b><?php echo esc_attr($namesite);?></b> with your Account in Wordpress to sign up for WorkSuite and send Email for You!</p>
                <button type="submit" name="Register_quickly" class="btn btn-primary js-register-quickly" >Register quickly !</button>
                <!-- <button type="button" name="Custom_registration" class="js-getoken btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal2">Account Switch</button> -->
            </form> 
        </div>
    <?php } ?>
    