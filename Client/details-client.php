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
                </tr>
                
				<!-- <th>Action</th> -->
			<?php $count = $start; foreach($args as $row) { 
				$count++;
				$AOV = $row['sumtotal'] / $row['oders'];
				$date_created = date('d F, Y',$row['date_created']->getTimestamp());
				?>
				<tr id ="id-<?php echo esc_attr($row['id']) ?>">
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