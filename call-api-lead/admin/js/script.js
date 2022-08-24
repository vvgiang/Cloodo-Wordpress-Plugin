jQuery(document).ready(function($) {
    $('button.gethref').click(function(){
       var dataHref = $(this).attr('data-href');
       console.log(dataHref);
        $('.posthref').attr('href',dataHref);
    });
    $('#show').change(function(){
         flag = false;
        var val = $(this).val() ? $(this).val() : 10;
        $.ajax({
			url: filter_ajax_object.ajaxUrl+'?pageNum='+filter_ajax_object.pageNum,
			type: 'post',
            dataType : "json",
			data: { 
                action: 'ajax_demo',
                value : val,
            },
            beforeSend: function() {
				$( '.filter_result tr').remove();
				$( '.filter_result' ).scrollTop(0);
                $( '.pagina ul' ).remove();
				$( '.filter_result' ).append( '<div id="loading"></div>' );
			},
			success: function( response ) {
                console.log(response);
                if(response.success) {
                    $( '.filter_result' ).find( '#loading' ).remove();
                    // $( '.filter_result tr ').remove();
                    // $( '.pagina ul' ).remove();
                    var siteUrl = filter_ajax_object.getSiteUrl;
                    var pageNum = filter_ajax_object.pageNum;
                    var data = response.data?.body;
                    const obj = JSON.parse(data);
                    var arr = obj.data;
                    console.log(obj);
                    totalSum = obj.meta.paging.total;
                    pageSum = Math.ceil(totalSum/val);
                        around = 3;
                        next = pageNum + around;
                        if (next > pageSum) {
                                next = pageSum;
                        }
                        pre = pageNum - around;
                        if (pre <= 1) pre = 1;
                    var d = new Date();
                    console.log(pageSum);
                    var star = (pageNum -1) * val;
                    for(element of arr){
                        star++;
                        $('.filter_result' ).append(`
                        <tr>		
                            <td>${star}</td>
                            <td>${element.client_name}</td>
                            <td>${element.company_name} </td>
                            <td>${element.value} </td>
                            <td>${d.getDate()}</td>
                            <td>${element.next_follow_up} </td>
                            <td>${element.client_email} </td>
                            <td>
                                <a href="${siteUrl}/wp-admin/admin.php?page=lead&view=edit&id=${element.id}&pageNum=${pageNum}" class="btn btn-success p-2"><i class="fa-solid fa-pen-to-square"></i></a>
                                <button type="submit" data-toggle="modal" data-target="#exampleModal" class="delete btn btn-danger p-2 gethref" data-href="${siteUrl}wp-admin/admin.php?page=lead&iddel=${element.id}&pageNum=${pageNum}"><i class="fa-solid fa-trash-can"></i></button>
                            </td>
                        </tr>
                        `);
                    }
                    $('.pagina').append(`
                    <ul class="pagination">       
                           ${pageNum > 1 ?
                                    (`<li class="page-item"><a class="page-link" href="${siteUrl}/wp-admin/admin.php?page=lead&pageNum=1">
                                                << </a>
                                      </li>
                                      <li class="page-item"><a class="page-link" href="${siteUrl}/wp-admin/admin.php?page=lead&pageNum=${pageNum-1}">
                                                          < </a>
                                      </li>`) : ""
                            } 

                             	for(${i} = ${pre}; ${i} <= ${next}; ${i++}){
                                    ${i== pageNum ? `<li class="page-item"><a class="page-link bg-warning" href="${siteUrl}/wp-admin/admin.php?page=lead&pageNum=${i}">${i}</a></li>`:
                                    `<li class="page-item"><a class="page-link" href="${siteUrl}/wp-admin/admin.php?page=lead&pageNum=${i}">${i}</a></li>`
                                    }
                                     


                            }
                            	if ($pageNum < $pageSum) { ?>
                                
                                      <li class="page-item"><a class="page-link" href="${siteUrl}/wp-admin/admin.php?page=lead&pageNum=<?php echo esc_attr($pageNum) + 1 ?>"> > </a></li>
                                      <li class="page-item"><a class="page-link" href="${siteUrl}/wp-admin/admin.php?page=lead&pageNum=<?php echo esc_attr($pageSum) ?>"> >> </a></li>
                            <?php } ?>
                  </ul>`);
                    if((arr.length) >0){
                        swal({
                            title: "Filter compete !",
                            text: "You clicked the button!",
                            icon: "success",
                        });
                    }else{
                        swal({
                            title: "lead empty!",
                            text: "You clicked the button!",
                            icon: "success",
                        })
                    }
                    flag = true;
                }
                else {
                    swal({
                        title: "Filter Error !",
                        text: "You clicked the button!",
                        icon: "warning",
                    });
                }
			}
		});
        setTimeout(messageError, 4000);
        function messageError() {            
            if(flag == false){
                console.log(flag)
                $( '.filter_result' ).find( '#loading' ).remove();
                swal({
                    title: "Filter Error !",
                    text: "You clicked the button!",
                    icon: "warning",
                });
            }
        }
    });
});