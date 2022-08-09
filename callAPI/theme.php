<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
<?php 
require_once ('css.php');
?>
<form method="post" action="">
  <h3>LOGIN GET TOKEN FORM</h3>
  <div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="text" name="email" id="email" value="<?php echo $email ?? ""; ?>"/>
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" name="password" id="password" value="<?php echo $password ?? ""; ?>"/>
  </div>
  <button type="submit"  name="save" class="btn btn-primary">LOGIN</button>
</form>



