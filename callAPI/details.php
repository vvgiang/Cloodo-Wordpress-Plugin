<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" />
<div class="container">
<table class="table table-hover">


					<thead>
                        <h2>LIST PROJECT</h2>
                        <a href="<?php echo get_site_url() ?>/wp-admin/admin.php?page=project_list&view=post" class="btn btn-info">Add</a>
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
							<td><?php echo $star;  ?></td>
							<td><?php echo $row['id'] ?></td>
							<td><?php echo $row['project_name'] ?> </td>
							<td><?php echo date('d-m-Y',strtotime($row['start_date']))?></td>
							<td><?php echo date('d-m-Y',strtotime($row['deadline']))?></td>
							<td><?php echo $row['status'] ?></td>
							<td>
								<a href="<?php echo get_site_url() ?>/wp-admin/admin.php?page=project_list&view=edit&id=<?php echo $row['id'] ?>" class="btn btn-success p-2"><i class="fa-solid fa-pen-to-square"></i></a>
								<a class="delete btn btn-danger p-2"  href="<?php echo get_site_url() ?>/wp-admin/admin.php?page=project_list&iddel=<?php echo $row['id'] ?>" onclick="return confirm('bạn có chắc muốn xoá ?')" ><i class="fa-solid fa-trash-can"></i></a>
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
                                      <li class="page-item"><a class="page-link" href="<?php echo get_site_url() ?>/wp-admin/admin.php?page=project_list&pageNum=<?php echo $pageNum - 1 ?>">
                                                          < </a>
                                      </li>
                            <?php } 

                             	for ($i = $pre; $i <= $next; $i++) { ?>
                                      <?php if ($i == $pageNum) { ?>
                                                <li class="page-item"><a class="page-link bg-warning" href="<?php echo get_site_url() ?>/wp-admin/admin.php?page=project_list&pageNum=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                      <?php } else { ?>
                                                <li class="page-item"><a class="page-link" href="<?php echo get_site_url() ?>/wp-admin/admin.php?page=project_list&pageNum=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                      <?php } ?>


                            <?php }
                            	if ($pageNum < $pageSum) { ?>
                                
                                      <li class="page-item"><a class="page-link" href="<?php echo get_site_url() ?>/wp-admin/admin.php?page=project_list&pageNum=<?php echo $pageNum + 1 ?>"> > </a></li>
                                      <li class="page-item"><a class="page-link" href="<?php echo get_site_url() ?>/wp-admin/admin.php?page=project_list&pageNum=<?php echo $pageSum ?>"> >> </a></li>
                            <?php } ?>
                  </ul>
        </nav>
	</div>
</div>

