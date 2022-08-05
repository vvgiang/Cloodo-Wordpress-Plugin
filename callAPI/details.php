<?php 
require_once ('showresults.php');
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" />
<div class="container">
<table class="table table-hover">


					<thead>
                        <h2>LIST PROJECT</h2>
                        <a href="http://localhost/hoanle/wp-admin/themes.php?page=theme-options1&view=post" class="btn btn-info">Add</a>
						<tr>
                            <th>STT</th>
							<th>Id</th>
							<th>Projec_Name</th>
							<th>Start_Date</th>
							<th>Deadline</th>
							<th>Status</th>
							<th>Manipulation</th>
						</tr>
					</thead>
					<tbody>
						<?php $star; foreach($arr['data'] as $row) { $star++; ?>
							<tr>
								
						<td><?= $star;  ?></td>
						<td><?= $row['id'] ?></td>
						<td><?= $row['project_name'] ?> </td>
						<td><?= $row['start_date'] ?></td>
						<td><?= $row['deadline'] ?></td>
						<td><?= $row['status'] ?></td>
						<td>
							<a href="http://localhost/hoanle/wp-admin/themes.php?page=theme-options1&view=edit&id=<?= $row['id'] ?>" class="btn btn-success p-2"><i class="fa-solid fa-pen-to-square"></i></a>
							<a class="delete btn btn-danger p-2"  href="http://localhost/hoanle/wp-admin/themes.php?page=theme-options1&iddel=<?= $row['id'] ?>" onclick="return confirm('bạn có chắc muốn xoá ?')" ><i class="fa-solid fa-trash-can"></i></a>
						</td>
					</tr>
					<?php } ?>

					</tbody>
				</table>
	<div class="container ">
        
        <nav aria-label="Page navigation example">
                  <ul class="pagination">
                           
                            <?php if ($pageNum > 1) { ?>
                        
                                      <li class="page-item"><a class="page-link" href="http://localhost/hoanle/wp-admin/themes.php?page=theme-options1&pageNum=1">
                                                << </a>
                                      </li>
                                      <li class="page-item"><a class="page-link" href="http://localhost/hoanle/wp-admin/themes.php?page=theme-options1&pageNum=<?php echo $pageNum - 1 ?>">
                                                          < </a>
                                      </li>
                            <?php } ?>

                            <?php for ($i = $pre; $i <= $next; $i++) { ?>
                                      <?php if ($i == $pageNum) { ?>
                                                <li class="page-item"><a class="page-link bg-warning" href="http://localhost/hoanle/wp-admin/themes.php?page=theme-options1&pageNum=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                      <?php } else { ?>
                                                <li class="page-item"><a class="page-link" href="http://localhost/hoanle/wp-admin/themes.php?page=theme-options1&pageNum=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                      <?php } ?>


                            <?php } ?>
                            <?php if ($pageNum < $pageSum) { ?>
                                
                                      <li class="page-item"><a class="page-link" href="http://localhost/hoanle/wp-admin/themes.php?page=theme-options1&pageNum=<?php echo $pageNum + 1 ?>"> > </a></li>
                                      <li class="page-item"><a class="page-link" href="http://localhost/hoanle/wp-admin/themes.php?page=theme-options1&pageNum=<?php echo $pageSum ?>"> >> </a></li>
                            <?php } ?>


                           
                  </ul>
        </nav>
	</div>
</div>

