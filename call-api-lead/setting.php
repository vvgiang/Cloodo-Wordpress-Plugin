<div class="login_element">
<form class="create_form" method="POST" action="">
    <a href="https://erp.cloodo.com/">
        <img src="<?php echo plugin_dir_url(__DIR__).'call-api-lead/admin/image/worksuite-logo.png'?>" class="worksuite-logo">
    </a>
    <h4>Hello: <b><?php echo $user_login; ?></b>, welcome to Worksuite</h4>
    <?php if(!empty(get_option('user_register')) && !empty(get_option('password'))){ 
        if(isset($error) && $res['response']['code'] == '404') {
            echo '<p style="color:red;font-size: 16px;font-weight: 400;">'.$error.' - not found!</p>';
        }
        elseif(isset($error) && $res['response']['code'] == '405'){ 
            echo '<p style="color:red;font-size: 16px;font-weight: 400;">'.$error.' - The account already exists or has not activated email !</p>';
        }
        elseif(isset($success)){
            echo '<p style="color:green;font-size: 16px;font-weight: 400;">Register Successfully - '.$success;
        }else{ ?>
        <p style="color:#3e3e3e;font-size: 16px;font-weight: 400;">Chúc an lành ! hôm nay là : <?php date_default_timezone_set('Asia/Ho_Chi_Minh'); echo date('d/m/Y - H:i:s'); ?></p>
        <button type="submit"  name="Custom_registration" class="btn btn-primary">Another account !</button>
            <?php } ?> 
    <?php }else{ ?>
    <p style="color:#3e3e3e;font-size: 16px;font-weight: 400;" class="card-text">We are helping you to connect your website <b><?php echo get_bloginfo();?></b> with your Account in Wordpress to sign up for WorkSuite and send Email for You!</p>
    <button type="submit"  name="Register_quickly" class="btn btn-primary">Register quickly !</button>
    <?php } ?>
</form>
</div>