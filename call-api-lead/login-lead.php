<div class="login_element">
  <a href="https://erp.cloodo.com/">
    <img src="<?php echo plugin_dir_url(__DIR__).'call-api-lead/admin/image/worksuite-logo.png'?>" class="worksuite-logo">
  </a>
  <?php if(!empty(get_option('token'))){ ?>
    <form class="login_form" method="POST" action="">
      <button type="submit"  name="connect" class="btn btn-primary">Connect Now!</button>
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
      Login and transfer Account !
      </button>
    </form>
    <?php }else{ ?>
      <form class="login_form" method="POST" action="">
      <button type="submit"  name="setting" class="btn btn-primary">Auto Create User account !</button>
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal1">
      Custom create Account !
      </button>                       
  </form>
    <?php } ?>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="projecttitle">LOGIN LEAD FORM</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
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
              <p data-toggle="modal" data-target="#exampleModal1">
              Don't have an account? <a href="#" class="text-primary m-l-5 signup"><b>Sign Up</b></a> !
              </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit"  name="save" class="btn btn-primary">LOGIN</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- ///modal register/// -->
<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="projecttitle">REGISTER LEAD FORM</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
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



