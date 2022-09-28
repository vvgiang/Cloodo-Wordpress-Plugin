<div class="container">
	<?php if(isset($data)){ 
		$countries = WC()->countries->get_countries();
		// $array=[];
		// if (($open = fopen(str_replace('\\','/', plugin_dir_path( __DIR__ ).'includes/countrycode.csv'), "r")) !== FALSE) 
		// {
		// 	while (($data = fgetcsv($open, 1000, ",")) !== FALSE) 
		// 	{        
		// 	$array[] = $data; 
		// 	}
		// 	fclose($open);
		// }
		// echo "<pre>";
		// print_r($array);
		// print_r($countries);
		// echo "</pre>";
		?>
		<h2 class="projecttitle"> Views Client</h2>
		<div class="addlead">
					<label for="show" class="show">
						Show
						<select id="show" name="show" required>
							<option value="10">10</option>
							<option value="25">25</option>
							<option value="50">50</option>
						</select>
					</label>
		</div>
		<div class="table-parent">
			<table class="table table-hover ">
				<thead class="tablehead">
					<tr>
						<th>Stt</th>
						<th>Name</th>
						<th>Company Name</th>
						<th>Email</th>
						<th>Mobile</th>
						<th>Create at</th>
						<th>Action</th>
						<!-- <th>Action</th> -->
					</tr>
				</thead>
				<tbody class="filter_result">
					<?php $count = $start; foreach($arr['data'] as $row) { 
						$count++;
						// $AOV = $row['tong'] / $row['oders'];
						$created_at = date('d-m-Y',strtotime($row['created_at']));
						// $date_registered = isset($row['date_registered'])&& $row['date_registered'] != '' ? date('d F,Y',strtotime($row['date_registered'])) : '__';
						?>
						<tr id ="id-<?php echo esc_attr($row['id']) ?>">
							<td><?php echo esc_attr($count);  ?></td>	
							<td><?php echo esc_attr($row['name']);  ?></td>	
							<td><?php echo esc_attr($row['client_details']['company_name']);  ?></td>	
							<td><?php echo esc_attr($row['email']);  ?></td>	
							<td><?php echo esc_attr($row['mobile']);  ?></td>	
							<td><?php echo esc_attr($created_at);  ?></td>	
							<td>
								<div class="btn-action" data="<?php echo esc_attr($row['id']) ?>" >
									<i class="fa-solid fa-ellipsis-vertical icon-action"></i>
									<div class="wraper">
										<div class="show-action" id="<?php echo esc_attr($row['id']) ?>">
											<a href="<?php echo esc_url(admin_url('admin.php?')) ?>page=Client&view=edit&id=<?php echo esc_attr($row['id']) ?>&pageNum=<?php echo esc_attr($pageNum) ?>" data-id="<?php echo esc_attr($row['id']) ?>" class="btn-addlist"><i class="icon-edit fa-solid fa-magnifying-glass"></i></a>
											<button type="submit" data-toggle="modal" data-target="#exampleModal" class="delete btn-addlist p-2 gethref" data-id="<?php echo esc_attr($row['id']) ?>"  data-href="<?php echo esc_url(admin_url('admin.php?')) ?>page=Client&iddel=<?php echo esc_attr($row['id']) ?>&pageNum=<?php echo esc_attr($pageNum) ?>"><i class="fa-solid fa-trash-can"></i></button>
										</div>
									</div>
								</div>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
		<div id="table-details">
			<table class="table table-hover">
				<thead class="tablehead">
					<tr>
						<th>Stt</th>
						<th>Name</th>
						<th>Date created</th>
						<th>Email</th>
						<th>Oders</th>
						<th>Total Spend</th>
						<th>AOV</th>
						<th>Contry/Region</th>
						<th>City</th>
						<th>Poscode</th>
						<!-- <th>Action</th> -->
					</tr>
				</thead>
				<tbody class="filter_result">
					<?php $count = $start; foreach($args as $row) { 
						$count++;
						$AOV = $row['sumtotal'] / $row['oders'];
						$date_created = date('d F, Y',$row['date_created']->getTimestamp());
						?>
						<tr id ="id-<?php echo esc_attr($row['customer_id']) ?>">
							<td><?php echo esc_attr($count);  ?></td>	
							<td><?php echo (isset($row['customer_id']) && $row['customer_id'] != 0) ? '<a href="'.esc_url(admin_url('user-edit.php?user_id=')). esc_attr( $row['customer_id'] ).'">'. esc_attr($row['billing']['first_name'].' '. $row['billing']['last_name']).'</a>' :  esc_attr($row['billing']['first_name'].' '. $row['billing']['last_name']) ?></td>
							<td><?php echo esc_attr($date_created) ?> </td>
							<td><a href="mailto:<?php echo esc_attr(sanitize_email($row['billing']['email']))?>"><?php echo esc_attr(sanitize_email($row['billing']['email']))?></a>  </td>
							<td><?php echo esc_attr($row['oders'])?> </td>
							<td><?php echo esc_attr(number_format($row['sumtotal'],0,'.','.')) ?><span> &#x20ab;</span></td>
							<td><?php echo esc_attr(number_format($AOV,0,'.','.')) ?><span> &#x20ab;</span></td>
							<td><?php echo esc_attr($countries[$row['billing']['country']]) ?></td>
							<td><?php echo esc_attr($row['billing']['city']) ?></td>
							<td><?php echo esc_attr($row['billing']['postcode']) ?></td>
							<!-- <td>
								<a href="<?php echo esc_url(admin_url('admin.php?')) ?>page=Client&view=edit&id=<?php echo esc_attr($row['customer_id']) ?>&pageNum=<?php echo esc_attr($pageNum) ?>" data-id="<?php echo esc_attr($row['customer_id']) ?>" class="edit btn-addlist p-2"><i class="fa-solid fa-eye-dropper"></i></a>
								<button type="submit" data-toggle="modal" data-target="#exampleModal" class="delete btn-addlist p-2 gethref" data-id="<?php echo esc_attr($row['customer_id']) ?>"  data-href="<?php echo esc_url(admin_url('admin.php?')) ?>page=Client&iddel=<?php echo esc_attr($row['customer_id']) ?>&pageNum=<?php echo esc_attr($pageNum) ?>"><i class="fa-solid fa-trash-can"></i></button>
							</td> -->
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>			
	<?php }elseif(!class_exists( 'WooCommerce' )){ ?>
		<div id="error">
			<h1>WooCommerce => <a href="<?php echo esc_url(admin_url('plugin-install.php?s=WooCommerce&tab=search&type=term')) ?>">Activate Now</a></h1>
		</div>
	<?php die(); }else{  ?>
		<div id="error">
			<h1>Empty Client => <a href="<?php echo esc_url(admin_url('admin.php?page=Setting')) ?>">Back to menu</a></h1>
		</div>
	<?php die(); } ?>
	<nav class="pagina" aria-label="Page navigation example">
		<ul class="pagination">     
			<?php if ($pageNum > 1) { ?>
					<li class="page-item"><a class="page-link" data-Num="<?php echo 1; ?>" href="<?php echo esc_url(admin_url('admin.php?page=Client&pageNum=1')) ?>"> << </a></li>
					<li class="page-item"><a class="page-link" data-Num="<?php echo esc_attr($pageNum) - 1 ?>" href="<?php echo esc_url(admin_url('admin.php?')) ?>page=Client&pageNum=<?php echo esc_attr($pageNum) - 1 ?>"> < </a></li>
			<?php } 
				for ($i = $pre; $i <= $next; $i++) { ?>
					<?php if ($i == $pageNum) { ?>
						<li class="page-item"><a class="page-link bg-warning active" data-Num="<?php echo esc_attr($i) ?>" href="<?php echo esc_url(admin_url('admin.php?')) ?>page=Client&pageNum=<?php echo esc_attr($i); ?>"><?php echo esc_attr($i); ?></a></li>
					<?php } else { ?>
						<li class="page-item"><a class="page-link" data-Num="<?php echo esc_attr($i) ?>" href="<?php echo esc_url(admin_url('admin.php?')) ?>page=Client&pageNum=<?php echo esc_attr($i); ?>"><?php echo esc_attr($i); ?></a></li>
					<?php } ?>
			<?php }
				if ($pageNum < $pageSum) { ?>                            
					<li class="page-item"><a class="page-link" data-Num="<?php echo esc_attr($pageNum) + 1 ?>" href="<?php echo esc_url(admin_url('admin.php?')) ?>page=Client&pageNum=<?php echo esc_attr($pageNum) + 1 ?>"> > </a></li>
					<li class="page-item"><a class="page-link" data-Num="<?php echo esc_attr($pageSum) ?>" href="<?php echo esc_url(admin_url('admin.php?')) ?>page=Client&pageNum=<?php echo esc_attr($pageSum) ?>"> >> </a></li>
			<?php } ?>
		</ul>
	</nav>
</div>



