<form class="temp" method="post" action="<?php echo get_site_url() ?>/wp-admin/admin.php?page=project_list">
  <h2>ADD TOKEN</h2>
  <div class="mb-3">
    <label for="idtoken" class="form-label">ID Token</label>
    <input type="text" name="token" id="idtoken" value="<?php echo $token ?? ""; ?>"/>
  </div>
  <button type="submit"  name="savetoken" class="btn btn-primary">Add token</button>
</form>