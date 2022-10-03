<div class="container">
	<?php if(isset($arr['data'])){ ?>
		<h2 class="projecttitle">LIST LEADS</h2>
		<div class="addlead">
					<label for="show" class="show">
						Show
						<select id="show" name="show" required>
							<option value="10">10</option>
							<option value="25">25</option>
							<option value="50">50</option>
						</select>
					</label>
					<a href="<?php echo esc_url(admin_url('admin.php?')) ?>page=lead&view=post&pageSum=<?php echo isset($nextpage) && $nextpage >0 ? esc_attr( $nextpage ) : 1 ?>" class="btn btn-info btn-addlist">Add lead <i class="fa-solid fa-plus"></i></a>
				</div>
		<div class="table-parent">
			<table class="table table-hover ">
				<thead class="tablehead">
					<tr>
						<th>Stt</th>
						<th>Client Name</th>
						<th>Company Name</th>
						<th>Lead Value</th>
						<th>Create On</th>
						<th>Next Follow Up</th>
						<th>Client Email</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody class="filter_result">
					<?php $start; foreach($arr['data'] as $row) { $start++; ?>
						<tr id ="id-<?php echo esc_attr($row['id']) ?>">		
							<td><?php echo esc_attr($start);  ?></td>
							<td><?php echo esc_attr($row['client_name']) ?> </td>
							<td><?php echo esc_attr($row['company_name']) ?> </td>
							<td><?php echo esc_attr($row['value']) ?> </td>
							<td><?php echo esc_attr(date('d-m-Y'))?> </td>
							<td><?php echo $row['next_follow_up'] ? esc_attr($row['next_follow_up']):""?> </td>
							<td><?php echo esc_attr($row['client_email']) ?></td>
							<td>
								<div class="btn-action" data="<?php echo esc_attr($row['id']) ?>" >
									<i class="fa-solid fa-ellipsis-vertical icon-action"></i>
									<div class="wraper">
										<div class="show-action" id="<?php echo esc_attr($row['id']) ?>">
											<a href="<?php echo esc_url(admin_url('admin.php?')) ?>page=lead&view=edit&id=<?php echo esc_attr($row['id']) ?>&pageNum=<?php echo esc_attr($pageNum) ?>" data-id="<?php echo esc_attr($row['id']) ?>" class="btn-addlist"><i class="icon-edit fa-solid fa-eye-dropper"></i></a>
											<button type="submit" data-toggle="modal" data-target="#exampleModal" class="delete btn-addlist p-2 gethref" data-id="<?php echo esc_attr($row['id']) ?>"  data-href="<?php echo esc_url(admin_url('admin.php?')) ?>page=lead&iddel=<?php echo esc_attr($row['id']) ?>&pageNum=<?php echo esc_attr($pageNum) ?>"><i class="fa-solid fa-trash-can"></i></button>
										</div>
									</div>
								</div>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	<?php }else{ ?>
		<div id="error">
			<h1>Error : API not found</h1>
		</div>
	<?php die(); } ?>
	<nav class="pagina" aria-label="Page navigation example">
			<ul class="pagination">     
				<?php if ($pageNum > 1) { ?>
						<li class="page-item"><a class="page-link" data-Num="<?php echo 1; ?>" href="<?php echo esc_url(admin_url('admin.php?page=lead&pageNum=1')) ?>"> << </a></li>
						<li class="page-item"><a class="page-link" data-Num="<?php echo esc_attr($pageNum) - 1 ?>" href="<?php echo esc_url(admin_url('admin.php?')) ?>page=lead&pageNum=<?php echo esc_attr($pageNum) - 1 ?>"> < </a></li>
				<?php } 
					for ($i = $pre; $i <= $next; $i++) { ?>
						<?php if ($i == $pageNum) { ?>
							<li class="page-item"><a class="page-link bg-warning active" data-Num="<?php echo esc_attr($i) ?>" href="<?php echo esc_url(admin_url('admin.php?')) ?>page=lead&pageNum=<?php echo esc_attr($i); ?>"><?php echo esc_attr($i); ?></a></li>
						<?php } else { ?>
							<li class="page-item"><a class="page-link" data-Num="<?php echo esc_attr($i) ?>" href="<?php echo esc_url(admin_url('admin.php?')) ?>page=lead&pageNum=<?php echo esc_attr($i); ?>"><?php echo esc_attr($i); ?></a></li>
						<?php } ?>
				<?php }
					if ($pageNum < $pageSum) { ?>                            
						<li class="page-item"><a class="page-link" data-Num="<?php echo esc_attr($pageNum) + 1 ?>" href="<?php echo esc_url(admin_url('admin.php?')) ?>page=lead&pageNum=<?php echo esc_attr($pageNum) + 1 ?>"> > </a></li>
						<li class="page-item"><a class="page-link" data-Num="<?php echo esc_attr($pageSum) ?>" href="<?php echo esc_url(admin_url('admin.php?')) ?>page=lead&pageNum=<?php echo esc_attr($pageSum) ?>"> >> </a></li>
				<?php } ?>
			</ul>
		</nav>
</div>



