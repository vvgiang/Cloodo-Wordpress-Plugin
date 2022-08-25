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
            beforeSend: function() 
            {
				$( '.filter_result tr').remove();
				$( '.filter_result' ).scrollTop(0);
                $( '.pagina ul' ).remove();
				$( '.filter_result' ).append( '<div id="loading"></div>' );
			},
			success: function( response ) 
            {
                console.log(response);
                if(response.success) {
                    $( '.filter_result' ).find( '#loading' ).remove();
                    var siteUrl = filter_ajax_object.getSiteUrl;
                    var pageNum = Number(filter_ajax_object.pageNum);
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
                    console.log(typeof(pageNum));
                    var start = (pageNum -1) * val;
                    for(element of arr){
                        start++;
                        $('.filter_result' ).append(`
                        <tr>		
                            <td>${start}</td>
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
                    function fname(){
                        output ='';
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
                        title: "Filter Error1 !",
                        text: "You clicked the button!",
                        icon: "warning",
                    });
                }
			}
		});
        setTimeout(messageError, 5000);
        function messageError() 
        {            
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
    $(document).on('click','.page-link',function(e)
    {
        e.preventDefault();
        var pageNum = $(this).attr('data-Num') ? $(this).attr('data-Num'): 1;
        var pageNum = Number(pageNum);
        flag = false;
        var val = $('#show').val() ? $('#show').val() : 10;
        var value = Number(val);
        $.ajax({
			url: filter_ajax_object.ajaxUrl+'?pageNum='+Number(pageNum),
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
                console.log(response);
                if(response.success) {
                    $( '.filter_result tr').remove();
                    $( '.pagina ul' ).remove();
                    $( '.filter_result' ).find( '#loading' ).remove();
                    var siteUrl = filter_ajax_object.getSiteUrl;
                    var data = response.data?.body;
                    const obj = JSON.parse(data);
                    var arr = obj.data;
                    console.log(obj);
                    totalSum = obj.meta.paging.total;
                    pageSum = Math.ceil(totalSum/value);
                        around = 3;
                        next = pageNum + around;
                        if (next > pageSum) {
                            next = pageSum;
                        }
                        pre = pageNum - around;
                        if (pre <= 1) pre = 1;
                    var d = new Date();
                    var start = (pageNum -1) * value;
                    console.log(pageNum);
                    console.log(start);
                    console.log(value);
                    for(element of arr){
                        start++;
                        $('.filter_result' ).append(`
                        <tr>		
                            <td>${start}</td>
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
                    function fname(){
                        output ='';
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
                        title: "Filter Error1 !",
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