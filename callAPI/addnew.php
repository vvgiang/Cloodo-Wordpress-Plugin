<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" />
   <form action="<?php echo get_site_url() ?>/wp-admin/admin.php?page=project_list&idadd=post" method="POST">
          <div class="container ">
                    <div class="row">
                              <div class="col-md-5">
                                <h2>ADD PROJECT</h2>

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
                                        </div>
                              </div>
                    </div>
          </div>
</form>