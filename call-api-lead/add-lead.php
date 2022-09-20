<div class="temp">
  <form class="addnew" action="<?php echo esc_url(admin_url('admin.php?')) ?>page=lead&idadd=post&pageNum=<?php echo isset($pageSum ) ? esc_attr($pageSum): '1' ?>" method="POST">
    <div class="row">
      <div class="add_new col-md-12">
        <p class="projecttitle ">Add New Lead</p>
        <div class="form-group">
          <input id="company_name" type="text" name="company_name" class="form-control"  required name="company_name">
          <label class="input" for="company_name">Company Name</label>
        </div>
        <div class="form-group">
          <input id="value" type="number" min="0" name="value" class="form-control"  required name="value">
          <label class="input" for="value"> Lead Value</label>
        </div>
        <div class="form-group">
          <input id="client_name" type="text" name="client_name" class="form-control"  required name="client_name">
          <label class="input" for="client_name">Client Name</label>
        </div>
        <div class="form-group">
          <input id="client_email" type="email" name="client_email" class="form-control" required name="client_email">
          <label class="input" for="client_email">Client Email</label>
        </div>
        <div class="form-group">
          <select class="form-control" id="next_follow_up" name="next_follow_up" required>
            <option value="yes">Yes</option>
            <option value="no">No</option>
          </select>
          <label class="input" for="next_follow_up">Next Follow Up</label>
        </div>
        <div class="form-group">
          <button class="btn btn-success btn-title" name="submit" type="submit">Save</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="history.back()">Back</button>
        </div>
      </div>
    </div>
  </form>
</div>
