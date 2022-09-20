<div class="container">
	<?php if(isset($arr['data'])){ ?>
		<h2 class="projecttitle">LIST PROJECT</h2>
		<div class="addlead">
					<label for="show" class="show">
						Show
						<select id="show" name="show" required>
							<option value="10">10</option>
							<option value="25">25</option>
							<option value="50">50</option>
						</select>
					</label>
					<a href="<?php echo esc_url(admin_url('admin.php?')) ?>page=project_list&view=post&pageSum=<?php echo isset($nextpage)? esc_attr( $nextpage ) : $pageSum ?>" class="btn btn-info btn-addlist">Add project <i class="fa-solid fa-plus"></i></a>
				</div>
		<table class="table table-hover">
			<thead class="tablehead">
				<tr>
					<th>STT</th>
					<th>Id</th>
					<th>Projec Name</th>
					<th>Start Date</th>
					<th>Deadline</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</thead>
						<tbody class="filter_result">
							<?php $start; foreach($arr['data'] as $row) { $start++; ?>
							<tr>		
								<td><?php echo esc_attr($start);  ?></td>
								<td><?php echo esc_attr($row['id']) ?></td>
								<td><?php echo esc_attr($row['project_name']) ?> </td>
								<td><?php echo esc_attr(date('d-m-Y',strtotime($row['start_date'])))?></td>
								<td><?php echo esc_attr(date('d-m-Y',strtotime($row['deadline'])))?></td>
								<td><?php echo esc_attr($row['status']) ?></td>
								<td>
									<a href="<?php echo esc_url(admin_url('admin.php?')) ?>page=project_list&view=edit&id=<?php echo esc_attr($row['id']) ?>&pageNum=<?php echo esc_attr($pageNum) ?>" class="edit btn-addlist p-2"><i class="fa-solid fa-eye-dropper"></i></a>
									<button type="submit" data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="delete btn-addlist p-2 gethref" data-href="<?php echo esc_url(admin_url('admin.php?')) ?>page=project_list&iddel=<?php echo esc_attr($row['id']) ?>&pageNum=<?php echo esc_attr($pageNum) ?>"><i class="fa-solid fa-trash-can"></i></button>
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
	<nav class="pagina" aria-label="Page navigation example">
			<ul class="pagination">     
				<?php if ($pageNum > 1) { ?>
					<li class="page-item"><a class="page-link" href="<?php echo esc_url(admin_url('admin.php?page=project_list&pageNum=1')) ?>"><<</a></li>
					<li class="page-item"><a class="page-link" href="<?php echo esc_url(admin_url('admin.php?')) ?>page=project_list&pageNum=<?php echo esc_attr($pageNum) - 1 ?>"><</a></li>
				<?php } 
					for ($i = $pre; $i <= $next; $i++) { ?>
						<?php if ($i == $pageNum) { ?>
							<li class="page-item"><a class="page-link bg-warning active" href="<?php echo esc_url(admin_url('admin.php?')) ?>page=project_list&pageNum=<?php echo esc_attr($i); ?>"><?php echo esc_attr($i); ?></a></li>
						<?php } else { ?>
							<li class="page-item"><a class="page-link" href="<?php echo esc_url(admin_url('admin.php?')) ?>page=project_list&pageNum=<?php echo esc_attr($i); ?>"><?php echo esc_attr($i); ?></a></li>
						<?php } ?>
				<?php }
					if ($pageNum < $pageSum) { ?>                            
						<li class="page-item"><a class="page-link" href="<?php echo esc_url(admin_url('admin.php?')) ?>page=project_list&pageNum=<?php echo esc_attr($pageNum) + 1 ?>"> > </a></li>
								<li class="page-item"><a class="page-link" href="<?php echo esc_url(admin_url('admin.php?')) ?>page=project_list&pageNum=<?php echo esc_attr($pageSum) ?>"> >> </a></li>
				<?php } ?>
			</ul>
		</nav>
</div>
<!-- modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="staticBackdropLabel">You are sure <b>Delete</b> ?</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			<a class="delete btn btn-danger p-2 posthref"  href="" >Delete</a>
		</div>
		</div>
	</div>
	</div>



