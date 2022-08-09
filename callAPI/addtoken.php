<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
<h1>ADD TOKEN</h1>
<form method="post" action="<?php echo get_site_url() ?>/wp-admin/admin.php?page=project_list">
  <div class="mb-3">
    <label for="idtoken" class="form-label">ID Token</label>
    <input type="text" name="token" id="idtoken" value="<?php echo $token ?? ""; ?>"/>
  </div>
  <button type="submit"  name="savetoken" class="btn btn-primary">Add token</button>
</form>