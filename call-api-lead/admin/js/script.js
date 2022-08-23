jQuery(document).ready(function($) {
    $('button.gethref').click(function(){
       var dataHref = $(this).attr('data-href');
       console.log(dataHref);
        $('.posthref').attr('href',dataHref);
    });
    $('#show').change(function(){
        var val = $(this).val();
        // alert(a);
        // $.get('ajax.php',{val:a},function(data){
        // });
        $.ajax({
			url: filter_ajax_object.ajaxurl,
			type: 'post',
            dataType : "json",
			data: { 
                action: 'ajax_demo',
                value : val
            },
            beforeSend: function() {
				/*
				 @ Tạo các hiệu ứng trước khi request gửi đi
				 */
				// $( '#loading').remove();
				$( '.filter_result tr' ).remove();
				$( '.filter_result' ).scrollTop(0);
				$( '.filter_result' ).append( '<div id="loading">Đang lấy dữ liệu lead !</div>' );
			},
			success: function( response ) {
				// Thử nghiệm
                if(response.success) {
                    var data = response.data.body;
                    const obj = JSON.parse(data);
                    var arr = obj.data;
                    console.log(arr);
                    $( '.filter_result' ).find( '#loading' ).remove();
                    var star =0;
                    for(element of arr){
                        star++;
                        $('.filter_result' ).after(`
                        <tr>		
                            <td>${star}</td>
                            <td>${element.client_name}</td>
                            <td>${element.company_name} </td>
                            <td>${element.value} </td>
                            <td><?php echo esc_attr(date('d-m-Y'))?> </td>
                            <td><?php echo $row['next_follow_up'] ? esc_attr($row['next_follow_up']):""?> </td>
                            <td><?php echo esc_attr($row['client_email']) ?></td>
                            <td>
                                <a href="<?php echo get_site_url() ?>/wp-admin/admin.php?page=lead&view=edit&id=<?php echo esc_attr($row['id']) ?>&pageNum=<?php echo esc_attr($pageNum) ?>" class="btn btn-success p-2"><i class="fa-solid fa-pen-to-square"></i></a>
                                <button type="submit" data-toggle="modal" data-target="#exampleModal" class="delete btn btn-danger p-2 gethref" data-href="<?php echo get_site_url() ?>/wp-admin/admin.php?page=lead&iddel=<?php echo esc_attr($row['id']) ?>&pageNum=<?php echo esc_attr($pageNum) ?>"><i class="fa-solid fa-trash-can"></i></button>
                            </td>
                        </tr>
                        `);
                       
                    }
                }
                else {
                    alert('Đã có lỗi xảy ra');
                }
				
			}
		});
    });
});