<div class="container">
<table class="table table-hover">
			<thead>
                        <h2>LIST PROJECT</h2>
						<div>
						<a href="<?php echo get_site_url() ?>/wp-admin/admin.php?page=project_list&view=post&pageSum=<?php echo isset($nextpage)? esc_attr( $nextpage ) : $pageSum ?>" class="btn btn-info">Add</a>
						</div>
						<tr>
                            <th>STT</th>
							<th>Id</th>
							<th>Projec_Name</th>
							<th>Start_Date</th>
							<th>Deadline</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php $star; foreach($arr['data'] as $row) { $star++; ?>
						<tr>		
							<td><?php echo esc_attr($star);  ?></td>
							<td><?php echo esc_attr($row['id']) ?></td>
							<td><?php echo esc_attr($row['project_name']) ?> </td>
							<td><?php echo esc_attr(date('d-m-Y',strtotime($row['start_date'])))?></td>
							<td><?php echo esc_attr(date('d-m-Y',strtotime($row['deadline'])))?></td>
							<td><?php echo esc_attr($row['status']) ?></td>
							<td>
								<a href="<?php echo get_site_url() ?>/wp-admin/admin.php?page=project_list&view=edit&id=<?php echo esc_attr($row['id']) ?>&pageNum=<?php echo esc_attr($pageNum) ?>" class="btn btn-success p-2"><i class="fa-solid fa-pen-to-square"></i></a>
								<button type="submit" data-toggle="modal" data-target="#exampleModal" class="delete btn btn-danger p-2 gethref" data-href="<?php echo get_site_url() ?>/wp-admin/admin.php?page=project_list&iddel=<?php echo esc_attr($row['id']) ?>&pageNum=<?php echo esc_attr($pageNum) ?>"><i class="fa-solid fa-trash-can"></i></button>
							</td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
	<div class="container ">        
        <nav aria-label="Page navigation example">
                  <ul class="pagination">
                           
                            <?php if ($pageNum > 1) { ?>
                        
                                      <li class="page-item"><a class="page-link" href="<?php echo get_site_url() ?>/wp-admin/admin.php?page=project_list&pageNum=1">
                                                << </a>
                                      </li>
                                      <li class="page-item"><a class="page-link" href="<?php echo get_site_url() ?>/wp-admin/admin.php?page=project_list&pageNum=<?php echo esc_attr($pageNum) - 1 ?>">
                                                          < </a>
                                      </li>
                            <?php } 

                             	for ($i = $pre; $i <= $next; $i++) { ?>
                                      <?php if ($i == $pageNum) { ?>
                                                <li class="page-item"><a class="page-link bg-warning" href="<?php echo get_site_url() ?>/wp-admin/admin.php?page=project_list&pageNum=<?php echo esc_attr($i); ?>"><?php echo esc_attr($i); ?></a></li>
                                      <?php } else { ?>
                                                <li class="page-item"><a class="page-link" href="<?php echo get_site_url() ?>/wp-admin/admin.php?page=project_list&pageNum=<?php echo esc_attr($i); ?>"><?php echo esc_attr($i); ?></a></li>
                                      <?php } ?>


                            <?php }
                            	if ($pageNum < $pageSum) { ?>
                                
                                      <li class="page-item"><a class="page-link" href="<?php echo get_site_url() ?>/wp-admin/admin.php?page=project_list&pageNum=<?php echo esc_attr($pageNum) + 1 ?>"> > </a></li>
                                      <li class="page-item"><a class="page-link" href="<?php echo get_site_url() ?>/wp-admin/admin.php?page=project_list&pageNum=<?php echo esc_attr($pageSum) ?>"> >> </a></li>
                            <?php } ?>
                  </ul>
        </nav>
	</div>
	<form action="" method="GET">
		<button type="submit" name="logout" value="project" class="logout btn btn-danger">Logout</button>
	</form>
	<!-- Modal -->
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">you are sure <b>delete</b> ?</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<a class="delete btn btn-danger p-2 posthref"  href="" >Delete</a>
		  </div>
		</div>
	  </div>
	</div>
</div>



