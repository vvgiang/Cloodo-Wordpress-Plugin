<form class="temp" method="post" action="">
  <h2 class="projecttitle">LOGIN PROJECT FORM</h2>
  <div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="text" name="email" id="email" value="<?php echo isset($email) ? esc_attr($email): ""; ?>"/>
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" name="password" id="password" value="<?php echo isset($password) ? esc_attr($password): ""; ?>"/>
  </div>
  <button type="submit"  name="save" class="btn btn-primary">LOGIN</button>
  <p>Don't have an account? <a href="https://erp.cloodo.com/signup" class="text-primary m-l-5 signup"><b>Sign Up</b></a></p>
</form>



