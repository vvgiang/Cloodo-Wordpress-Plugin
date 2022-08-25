jQuery(document).ready(function($) {
    $(document).on('click','button.gethref',function(){
        const iddel = $(this).attr('data-id') ? $(this).attr('data-id'): '';
        const val = $('#show').val() ? $('#show').val() : 10;
        const value = Number(val);
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this imaginary file!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url:filter_ajax_object.ajaxUrl+'?iddel='+iddel,
                    dataType:'json',
                    data:{ 
                        action: 'ajax_demo',
                        value:value
                    },
                    beforeSend:function(){
                        $('.filter_result' ).append( '<div id="loading"></div>' );
                    },
                    success:function(response){
                        if(response.success){
                            $('.filter_result').find('#loading').remove();
                            $('#id-'+iddel).remove();
                            swal("Poof! Your imaginary file has been deleted!", {
                                icon: "success",
                            });
                        }else {
                            swal({
                                title: "Delete fail !",
                                text: "You clicked the button!",
                                icon: "warning",
                            });
                        }
                    },
                });
            } else {
                swal("Your imaginary file is safe!");
            }
        });
    });
    $('#show').change(function(){
        flag = false;
        const val = $(this).val() ? $(this).val() : 10;
        const pageN = $('bg-warning').attr('data-num') ? $('bg-warning').attr('data-num'): 1;
        const pageNum = Number(pageN);
        $.ajax({
			url: filter_ajax_object.ajaxUrl+'?pageNum='+pageNum,
			type: 'post',
            dataType : "json",
			data: { 
                action: 'ajax_demo',
                value : val,
            },
            beforeSend: function() 
            {
				$( '.filter_result tr').remove();
				$( '.filter_result' ).scrollTop(0);
                $( '.pagina ul' ).remove();
				$( '.filter_result' ).append( '<div id="loading"></div>' );
			},
			success: function( response ) 
            {
                if(response.success) {
                    $( '.filter_result' ).find( '#loading' ).remove();
                    const siteUrl = filter_ajax_object.getSiteUrl;
                    const data = response.data?.body;
                    const obj = JSON.parse(data);
                    const arr = obj.data;
                    const totalSum = obj.meta.paging.total;
                    const pageSum = Math.ceil(totalSum/val);
                    const around = 3;
                    let next = pageNum + around;
                    if (next > pageSum) {
                        next = pageSum;
                    }
                    let pre = pageNum - around;
                    if (pre <= 1) pre = 1;
                    const d = new Date();
                    console.log(typeof(pageNum));
                    var start = (pageNum -1) * val;
                    for(element of arr){
                        start++;
                        $('.filter_result' ).append(`
                        <tr id ="id-${element.id}">		
                            <td>${start}</td>
                            <td>${element.client_name}</td>
                            <td>${element.company_name} </td>
                            <td>${element.value} </td>
                            <td>${d.getDate()}</td>
                            <td>${element.next_follow_up} </td>
                            <td>${element.client_email} </td>
                            <td>
                                <a href="${siteUrl}/wp-admin/admin.php?page=lead&view=edit&id=${element.id}&pageNum=${pageNum}" data-id="${element.id}" class="btn btn-success p-2"><i class="fa-solid fa-pen-to-square"></i></a>
                                <button type="submit" data-toggle="modal" data-target="#exampleModal" class="delete btn btn-danger p-2 gethref" data-id="${element.id}" data-href="${siteUrl}wp-admin/admin.php?page=lead&iddel=${element.id}&pageNum=${pageNum}"><i class="fa-solid fa-trash-can"></i></button>
                            </td>
                        </tr>
                        `);
                    }
                    function fname(){
                        let output ='';
                        for(let i=pre; i <= next; i++){
                            output += `${i == pageNum ? 
                                (`<li class="page-item"><a class="page-link bg-warning" data-Num="${i}" href="${siteUrl}/wp-admin/admin.php?page=lead&pageNum=${i}">${i}</a></li>`):
                                (`<li class="page-item"><a class="page-link" data-Num="${i}" href="${siteUrl}/wp-admin/admin.php?page=lead&pageNum=${i}">${i}</a></li>`)
                            }`
                        }
                        return output;
                    }
                    $('.pagina').append(`
                    <ul class="pagination">       
                            ${pageNum > 1 ?
                                (`<li class="page-item"><a class="page-link" data-Num="1" href="${siteUrl}/wp-admin/admin.php?page=lead&pageNum=1"> << </a></li>
                                <li class="page-item"><a class="page-link" data-Num="${pageNum-1}" href="${siteUrl}/wp-admin/admin.php?page=lead&pageNum=${pageNum-1}"> < </a></li>`) : ""
                            }
                            ${fname()}
                            ${pageNum < pageSum ?               
                                (`<li class="page-item"><a class="page-link" data-Num="${pageNum+1}" href="${siteUrl}/wp-admin/admin.php?page=lead&pageNum=${pageNum+1}"> > </a></li>
                                <li class="page-item"><a class="page-link" data-Num="${pageSum}" href="${siteUrl}/wp-admin/admin.php?page=lead&pageNum=${pageSum}"> >> </a></li>`) : ""
                            }
                    </ul>`);
                    flag = true;
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
                }
                else {
                    swal({
                        title: "Filter Error1 !",
                        text: "You clicked the button!",
                        icon: "warning",
                    });
                }
			}
		});
        setTimeout(messageError, 10000);
        function messageError() 
        {            
            if(flag == false){
                $( '.filter_result' ).find( '#loading' ).remove();
                swal({
                    title: "Filter Error !",
                    text: "You clicked the button!",
                    icon: "warning",
                });
            }
        }
    });
    $(document).on('click','.page-link',function(e)
    {
        e.preventDefault();
        flag = false;
        const pageN = $(this).attr('data-Num') ? $(this).attr('data-Num'): 1;
        const pageNum = Number(pageN);
        const val = $('#show').val() ? $('#show').val() : 10;
        const value = Number(val);
        $.ajax({
			url: filter_ajax_object.ajaxUrl+'?pageNum='+pageNum,
			type: 'post',
            dataType : "json",
			data: { 
                action: 'ajax_demo',
                value : value,
            },
            beforeSend: function() {		
				$( '.filter_result' ).scrollTop(0);
				$( '.filter_result' ).append( '<div id="loading"></div>' );
			},
			success: function( response ) {
                if(response.success) {
                    $( '.filter_result tr').remove();
                    $( '.pagina ul' ).remove();
                    $( '.filter_result' ).find( '#loading' ).remove();
                    const siteUrl = filter_ajax_object.getSiteUrl;
                    const data = response.data?.body;
                    const obj = JSON.parse(data);
                    const arr = obj.data;
                    const totalSum = obj.meta.paging.total;
                    const pageSum = Math.ceil(totalSum/value);
                    const around = 3;
                    let next = pageNum + around;
                    if (next > pageSum) {
                        next = pageSum;
                    }
                    let pre = pageNum - around;
                    if (pre <= 1) pre = 1;
                    const d = new Date();
                    var start = (pageNum -1) * value;
                    for(element of arr){
                        start++;
                        $('.filter_result' ).append(`
                        <tr id ="id-${element.id}">		
                            <td>${start}</td>
                            <td>${element.client_name}</td>
                            <td>${element.company_name} </td>
                            <td>${element.value} </td>
                            <td>${d.getDate()}</td>
                            <td>${element.next_follow_up} </td>
                            <td>${element.client_email} </td>
                            <td>
                                <a href="${siteUrl}/wp-admin/admin.php?page=lead&view=edit&id=${element.id}&pageNum=${pageNum}" data-id="${element.id}" class="btn btn-success p-2"><i class="fa-solid fa-pen-to-square"></i></a>
                                <button type="submit" data-toggle="modal" data-target="#exampleModal" class="delete btn btn-danger p-2 gethref" data-id="${element.id}" data-href="${siteUrl}wp-admin/admin.php?page=lead&iddel=${element.id}&pageNum=${pageNum}"><i class="fa-solid fa-trash-can"></i></button>
                            </td>
                        </tr>
                        `);
                    }
                    function fname(){
                        let output ='';
                        for(let i=pre; i <= next; i++){
                            output += `${i == pageNum ? 
                                (`<li class="page-item"><a class="page-link bg-warning" data-Num="${i}" href="${siteUrl}/wp-admin/admin.php?page=lead&pageNum=${i}">${i}</a></li>`):
                                (`<li class="page-item"><a class="page-link" data-Num="${i}" href="${siteUrl}/wp-admin/admin.php?page=lead&pageNum=${i}">${i}</a></li>`)
                            }`
                        }
                        return output;
                    }
                    $('.pagina').append(`
                    <ul class="pagination">       
                        ${pageNum > 1 ?
                                (`<li class="page-item"><a class="page-link" data-Num="1" href="${siteUrl}/wp-admin/admin.php?page=lead&pageNum=1"> << </a></li>
                                <li class="page-item"><a class="page-link" data-Num="${pageNum-1}" href="${siteUrl}/wp-admin/admin.php?page=lead&pageNum=${pageNum-1}"> < </a></li>`) : ""
                        }
                        ${fname()}
                        ${pageNum < pageSum ?               
                                (`<li class="page-item"><a class="page-link" data-Num="${pageNum+1}" href="${siteUrl}/wp-admin/admin.php?page=lead&pageNum=${pageNum+1}"> > </a></li>
                                <li class="page-item"><a class="page-link" data-Num="${pageSum}" href="${siteUrl}/wp-admin/admin.php?page=lead&pageNum=${pageSum}"> >> </a></li>`) : ""
                        }
                    </ul>`);
                    if((arr.length) >0){
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
                            title: " Error !",
                            text: "You clicked the button!",
                            icon: "warning",
                        });
                    }
			}
		});
        setTimeout(messageError, 10000);
        function messageError() {            
            if(flag == false){
                $( '.filter_result' ).find( '#loading' ).remove();
                swal({
                    title: " Warning: time out !",
                    text: "You clicked the button!",
                    icon: "warning",
                });
            }
        }
    });
});