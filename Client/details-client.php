$('#show').change(function(){
        alert("OK");
        flag = false;
        const val = $(this).val() ? $(this).val() : 10;
        const pageN = $('bg-warning').attr('data-num') ? $('bg-warning').attr('data-num'): 1;
        const pageNum = Number(pageN);
        $.ajax({
			url: project_ajax_object.ajaxUrl+'?pageNum='+pageNum,
			type: 'post',
            dataType : "json",
			data: { 
                action: 'ajax_project',
                value : val,
            },
            beforeSend: function() 
            {
				$( '.filter_result tr').remove();
				$( '.filter_result' ).scrollTop(0);
                $( '.pagina ul' ).remove();
				$( '.filter_result' ).append( '<div style="display:block;" id="loading"></div>' );
			},
			success: function( response ) 
            {
                if(response.success) {
                    $( '.filter_result' ).find( '#loading' ).remove();
                    const siteUrl = project_ajax_object.getSiteUrl;
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
                    var start = (pageNum -1) * val;
                    for(element of arr){
                        start++;
                        const start_date = new Date(element.start_date);
                        const deadline = new Date(element.deadline);
                        $('.filter_result' ).append(`
                        <tr id ="id-${element.id}">		
                            <td>${start}</td>
                            <td>${element.id}</td>
                            <td>${element.project_name} </td>
                            <td>${start_date.toLocaleDateString("en-GB")}</td>
                            <td>${deadline.toLocaleDateString("en-GB")}</td>
                            <td>${element.status} </td>
                            <td>
                                <div class="btn-action" data="${element.id}" >
                                    <i class="fa-solid fa-ellipsis-vertical icon-action"></i>
                                    <div class="wraper">
                                        <div class="show-action" id="${element.id}">
                                        <a href="${siteUrl}/wp-admin/admin.php?page=project_list&view=edit&id=${element.id}&pageNum=${pageNum}" data-id="${element.id}" class="btn-addlist"><i class="icon-edit fa-solid fa-magnifying-glass"></i></a>
                                        <button type="submit" data-toggle="modal" data-target="#exampleModal" class="delete btn-addlist p-2 gethref" data-id="${element.id}" data-href="${siteUrl}wp-admin/admin.php?page=project_list&iddel=${element.id}&pageNum=${pageNum}"><i class="fa-solid fa-trash-can"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        `);
                    }
                    function fname(){
                        let output ='';
                        for(let i=pre; i <= next; i++){
                            output += `${i == pageNum ? 
                                (`<li class="page-item"><a class="page-link bg-warning active" data-Num="${i}" href="${siteUrl}/wp-admin/admin.php?page=lead&pageNum=${i}">${i}</a></li>`):
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
                            title: "project empty!",
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
			},
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