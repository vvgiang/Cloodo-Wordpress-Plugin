                    <form class="temp" action="<?php echo get_site_url() ?>/wp-admin/admin.php?page=project_list&idput=<?php echo esc_attr($row['id']) ?>&pageNum=<?php echo esc_attr($pageNum) ?>" method="POST">
                        <div class="container ">
                                <div class="row">
                                            <div class="edit col-md-8">
                                            <h2 class="projecttitle">EDIT PROJECT</h2>
                                                    <div class="form-group">
                                                                <label>Projec_name</label>
                                                                <input type="text" name="project_name" value="<?php echo esc_attr($row['project_name'])?>" class="form-control" placeholder="projecname" required name="project_name">
                                                    </div>
                                                    <div class="form-group">
                                                                <label>start_date</label>
                                                                <input type="date" name="start_date" value="<?php echo esc_attr(date('Y-m-d',strtotime($row['start_date'])))?>" class="form-control" placeholder="start_date" required name="start_date">
                                                    </div>
                                                    <div class="form-group">
                                                                <label>deadline</label>
                                                                <input type="date" name="deadline" value="<?php echo esc_attr(date('Y-m-d',strtotime($row['deadline'])))?>" class="form-control" placeholder="deadline" required name="deadline">
                                                    </div>
                                                    <div class="form-group">
                                                                <label>status</label>
                                                                <select class="form-control" id="status" name="status" required>
                                                                        <option value="in progress" <?php echo (esc_attr($row['status'])=='in progress')? esc_attr('selected') : ''?>>In Progress</option>
                                                                        <option value="on hold"<?php echo (esc_attr($row['status'])=='on hold')? esc_attr('selected') : ''?>>On Hold</option>
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