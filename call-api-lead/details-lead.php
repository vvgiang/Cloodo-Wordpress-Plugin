<div class="container">
<?php if(isset($arr)){ ?>
	<table class="table table-hover">
			<thead>
                        <h2 class="projecttitle">LIST LEADS</h2>
                        <div>
						<a href="<?php echo get_site_url() ?>/wp-admin/admin.php?page=lead&view=post&pageSum=<?php echo isset($nextpage)? esc_attr( $nextpage ) : $pageSum ?>" class="btn btn-info">Add</a>
						</div>
						<div >
							<label for="show" class="show">
								Show
								<select class="form-control" id="show" name="show" required>
										<option value="10">10</option>
										<option value="25">25</option>
										<option value="50">50</option>
								</select>
							</label>
						</div>     
						<tr>
                            <th>STT</th>
							<th>CLIENT NAME</th>
							<th>COMPANY NAME</th>
							<th>LEAD VALUE</th>
							<th>CREATE ON</th>
							<th>NEXT FOLLOW UP</th>
							<th>CLIENT EMAIL</th>
							<th>ACTION</th>
						</tr>
					</thead>
					<tbody class="filter_result">
						<?php $star; foreach($arr['data'] as $row) { $star++; ?>
						<tr>		
							<td><?php echo esc_attr($star);  ?></td>
							<td><?php echo esc_attr($row['client_name']) ?> </td>
							<td><?php echo esc_attr($row['company_name']) ?> </td>
							<td><?php echo esc_attr($row['value']) ?> </td>
							<td><?php echo esc_attr(date('d-m-Y'))?> </td>
							<td><?php echo $row['next_follow_up'] ? esc_attr($row['next_follow_up']):""?> </td>
							<td><?php echo esc_attr($row['client_email']) ?></td>
							<td>
								<a href="<?php echo get_site_url() ?>/wp-admin/admin.php?page=lead&view=edit&id=<?php echo esc_attr($row['id']) ?>&pageNum=<?php echo esc_attr($pageNum) ?>" class="btn btn-success p-2"><i class="fa-solid fa-pen-to-square"></i></a>
								<button type="submit" data-toggle="modal" data-target="#exampleModal" class="delete btn btn-danger p-2 gethref" data-href="<?php echo get_site_url() ?>/wp-admin/admin.php?page=lead&iddel=<?php echo esc_attr($row['id']) ?>&pageNum=<?php echo esc_attr($pageNum) ?>"><i class="fa-solid fa-trash-can"></i></button>
							</td>
						</tr>
					<?php } ?>
					</tbody>
	</table>
<?php }else{ ?>
	<div id="error">
		<h1>Error : API not found</h1>
	</div>
<?php die(); } ?>
	<div class="container ">        
        <nav class="pagina" aria-label="Page navigation example">
                  <ul class="pagination">
                           
                            <?php if ($pageNum > 1) { ?>
                        
                                      <li class="page-item"><a class="page-link" href="<?php echo get_site_url() ?>/wp-admin/admin.php?page=lead&pageNum=1">
                                                << </a>
                                      </li>
                                      <li class="page-item"><a class="page-link" href="<?php echo get_site_url() ?>/wp-admin/admin.php?page=lead&pageNum=<?php echo esc_attr($pageNum) - 1 ?>">
                                                          < </a>
                                      </li>
                            <?php } 

                             	for ($i = $pre; $i <= $next; $i++) { ?>
                                      <?php if ($i == $pageNum) { ?>
                                                <li class="page-item"><a class="page-link bg-warning" href="<?php echo get_site_url() ?>/wp-admin/admin.php?page=lead&pageNum=<?php echo esc_attr($i); ?>"><?php echo esc_attr($i); ?></a></li>
                                      <?php } else { ?>
                                                <li class="page-item"><a class="page-link" href="<?php echo get_site_url() ?>/wp-admin/admin.php?page=lead&pageNum=<?php echo esc_attr($i); ?>"><?php echo esc_attr($i); ?></a></li>
                                      <?php } ?>


                            <?php }
                            	if ($pageNum < $pageSum) { ?>
                                
                                      <li class="page-item"><a class="page-link" href="<?php echo get_site_url() ?>/wp-admin/admin.php?page=lead&pageNum=<?php echo esc_attr($pageNum) + 1 ?>"> > </a></li>
                                      <li class="page-item"><a class="page-link" href="<?php echo get_site_url() ?>/wp-admin/admin.php?page=lead&pageNum=<?php echo esc_attr($pageSum) ?>"> >> </a></li>
                            <?php } ?>
                  </ul>
        </nav>
	</div>
	<form action="" method="GET">
		<button type="submit" name="logout" value="lead" class="logout btn btn-danger">Logout</button>
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



