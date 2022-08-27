<div class="login_element">
  <a href="https://erp.cloodo.com/">
    <img src="<?php echo plugin_dir_url(__DIR__).'call-api-lead/admin/image/worksuite-logo.png'?>" class="worksuite-logo">
  </a>
  <?php if(!empty(get_option('user_register')) && !empty(get_option('password'))){ ?>
    <form class="login_form" method="POST" action="">
      <button type="submit"  name="connect" class="btn btn-primary">Connect Now!</button>
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
          Show Form Login And Reset Token !
      </button>
    </form>
    <?php }else{ ?>
      <form class="login_form" method="POST" action="http://localhost/svtest/wp-admin/admin.php?page=Setting">
      <button type="submit"  name="setting" class="btn btn-primary">Auto Create User account !</button>
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        Show Form Login And Reset Token !
      </button>                       
  </form>
    <?php } ?>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <!-- <h5 class="modal-title" id="exampleModalLabel">Modal title</h5> -->
        <h2 class="projecttitle">LOGIN LEAD FORM</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="temple" method="post" action="">
        <div class="modal-body">
              <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="text" name="email" id="email" value="<?php echo isset($email) ? esc_attr($email): ""; ?>"/>
              </div>
              <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" name="password" id="password" value="<?php echo isset($password) ? esc_attr($password): ""; ?>"/>
              </div>
              <p>Don't have an account? <a href="https://erp.cloodo.com/signup" class="text-primary m-l-5 signup"><b>Sign Up</b></a></p>
              
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit"  name="save" class="btn btn-primary">LOGIN</button>
        </div>
      </form>
    </div>
  </div>
</div>


