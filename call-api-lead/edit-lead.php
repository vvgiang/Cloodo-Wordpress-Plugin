<div class="temp ">
        <form class="addnew" action="<?php echo esc_url(admin_url('admin.php?')) ?>page=lead&idput=<?php echo esc_attr($row['id']) ?>&pageNum=<?php echo esc_attr($pageNum) ?>" method="POST">
                <div class="row">
                        <div class="edit col-md-8">
                                <h2 class="projecttitle">EDIT LEAD</h2>
                                <div class="form-group">
                                        <label>COMPANY NAME</label>
                                        <input type="text" name="company_name" value="<?php echo esc_attr($row['company_name'])?>" class="form-control" placeholder="company name" required >
                                </div>
                                <div class="form-group">
                                        <label>CLIENT NAME</label>
                                        <input type="text" name="client_name" value="<?php echo esc_attr($row['client_name'])?>" class="form-control" placeholder="client name" required >
                                </div>
                                <div class="form-group">
                                        <label>LEAD VALUE</label>
                                        <input type="number" min="0" name="value" value="<?php echo $row['value'] ? esc_attr($row['value']) : ''?>" class="form-control" placeholder="value lead" required >
                                </div>
                                <div class="form-group">
                                        <label>CLIENT EMAIL</label>
                                        <input type="email" name="client_email" value="<?php echo esc_attr($row['client_email'])?>" class="form-control" placeholder="client email" required >
                                </div>
                                <div class="form-group">
                                <label>NEXT FOLLOW UP</label>
                                <select class="form-control" id="next_follow_up" name="next_follow_up" required>
                                        <option value="yes" <?php echo ($row['next_follow_up']=='yes') ? 'selected' : ''?>>Yes</option>
                                        <option value="no"<?php echo ($row['next_follow_up']=='no') ? 'selected' : ''?>>No</option>
                                </select>
                                </div>
                                <div class="form-group">
                                        <button class="btn btn-success" name="submit" type="submit">Save</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="history.back()">Back</button>
                                </div>
                        </div>
                </div>
        </form>
</div>