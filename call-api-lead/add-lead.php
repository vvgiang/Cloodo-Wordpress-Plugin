<form class="temp" action="<?php echo get_site_url() ?>/wp-admin/admin.php?page=lead&idadd=post&pageNum=<?php echo isset($pageSum)? esc_attr($pageSum): '1' ?>" method="POST">
  <div class="container ">
    <div class="row">
      <div class="add_new col-md-8">
        <h2 class="projecttitle">ADD LEAD</h2>
        <div class="form-group">
          <label>COMPANY_NAME</label>
          <input type="text" name="company_name" class="form-control" placeholder="company name" required name="company_name">
        </div>
        <div class="form-group">
          <label>VALUE</label>
          <input type="number" min="0" name="value" class="form-control" placeholder="value" required name="value">
        </div>
        <div class="form-group">
          <label>CLIENT NAME</label>
          <input type="text" name="client_name" class="form-control" placeholder="client name" required name="client_name">
        </div>
        <div class="form-group">
          <label>CLIENT EMAIL</label>
          <input type="email" name="client_email" class="form-control" placeholder="client email" required name="client_email">
        </div>
        <div class="form-group">
          <label>NEXT FOLLOW UP</label>
          <select class="form-control" id="next_follow_up" name="next_follow_up" required>
            <option value="yes">Yes</option>
            <option value="no">No</option>
          </select>
        </div>
        <div class="form-group">
          <button class="btn btn-success" name="submit" type="submit">Save</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="history.back()">Back</button>
        </div>
      </div>
    </div>
  </div>
</form>