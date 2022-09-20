<div class="temp ">
        <form class="addnew" action="<?php echo esc_url(admin_url('admin.php?')) ?>page=lead&idput=<?php echo esc_attr($row['id']) ?>&pageNum=<?php echo esc_attr($pageNum) ?>" method="POST">
                <div class="row">
                        <div class="edit col-md-12">
                                <h2 class="projecttitle">Edit lead</h2>
                                <div class="form-group">
                                        <input type="text" name="company_name" value="<?php echo esc_attr($row['company_name'])?>" class="form-control" required >
                                        <label class="input">Company Name</label>
                                </div>
                                <div class="form-group">
                                        <input type="text" name="client_name" value="<?php echo esc_attr($row['client_name'])?>" class="form-control" required >
                                        <label class="input">Client Name</label>
                                </div>
                                <div class="form-group">
                                        <input type="number" min="0" name="value" value="<?php echo $row['value'] ? esc_attr($row['value']) : ''?>" class="form-control"  required >
                                        <label class="input">Lead Value</label>
                                </div>
                                <div class="form-group">
                                        <input type="email" name="client_email" value="<?php echo esc_attr($row['client_email'])?>" class="form-control"  required >
                                        <label class="input">Client Email</label>
                                </div>
                                <div class="form-group">
                                <select class="form-control" id="next_follow_up" name="next_follow_up" required>
                                        <option value="yes" <?php echo ($row['next_follow_up']=='yes') ? 'selected' : ''?>>Yes</option>
                                        <option value="no"<?php echo ($row['next_follow_up']=='no') ? 'selected' : ''?>>No</option>
                                </select>
                                <label class="input">Next Follow Up</label>
                                </div>
                                <div class="form-group">
                                        <button class="btn btn-success btn-title" name="submit" type="submit">Save</button>
                                        <button type="button" class="btn btn-secondary btn.btn-title" data-dismiss="modal" onclick="history.back()">Back</button>
                                </div>
                        </div>
                </div>
        </form>
</div>