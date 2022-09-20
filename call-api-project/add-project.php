  <!-- <form class="temp" action="<?php echo esc_url(admin_url('admin.php?')) ?>page=project_list&idadd=post&pageNum=<?php echo isset($pageSum)? esc_attr($pageSum): '1' ?>" method="POST">
          <div class="container ">
                    <div class="row">
                              <div class="add_new col-md-8">
                                <h2 class="projecttitle">ADD PROJECT</h2>
                                        <div class="form-group">
                                                  <label>Projec_name</label>
                                                  <input type="text" name="project_name" class="form-control" placeholder="projecname" required name="project_name">
                                        </div>
                                        <div class="form-group">
                                                  <label>start_date</label>
                                                  <input type="date" name="start_date" class="form-control" placeholder="start_date" required name="start_date">
                                        </div>
                                        <div class="form-group">
                                                  <label>deadline</label>
                                                  <input type="date" name="deadline" class="form-control" placeholder="deadline" required name="deadline">
                                        </div>
                                        <div class="form-group">
                                                  <label>status</label>
                                                  <select class="form-control" id="status" name="status" required>
                                                            <option value="in progress">In Progress</option>
                                                            <option value="on hold">On Hold</option>
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
/////////////////// -->
<div class="temp">
  <form class="addnew" action="<?php echo esc_url(admin_url('admin.php?')) ?>page=project_list&idadd=post&pageNum=<?php echo isset($pageSum)? esc_attr($pageSum): '1' ?>" method="POST">
    <div class="row">
      <div class="add_new col-md-12">
        <p class="projecttitle ">Add New project</p>
        <div class="form-group">
          <input id="Projec_name" type="text" name="Projec_name" class="form-control"  required >
          <label class="input" for="Projec_name">Projec Name</label>
        </div>
        <div class="form-group">
          <input id="start_date" type="date"  name="start_date" class="form-control"  required>
          <label class="input" for="start_date">Start Date</label>
        </div>
        <div class="form-group">
          <input id="deadline" type="date" name="deadline" class="form-control"  required>
          <label class="input" for="deadline">eadline</label>
        </div>
        <div class="form-group">
          <select class="form-control" id="status" name="status" required>
            <option value="in progress">In Progress</option>
            <option value="on hold">On Hold</option>
          </select>
          <label class="input" for="status">Status</label>
        </div>
        <div class="form-group">
          <button class="btn btn-success btn-title" name="submit" type="submit">Save</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="history.back()">Back</button>
        </div>
      </div>
    </div>
  </form>
</div>
