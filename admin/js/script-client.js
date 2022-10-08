jQuery(document).ready(function($) {
    //////////////////close////////////////////
    $(document).on('click','.close',function(e){
        $(".table-details").removeClass("activedetails");
        $(document).find('.loading').remove();
        $('.content').remove();
    });
    ///////////////////profile client//////////////
    $(document).on('click','#profile',function(e){
        e.preventDefault();
        const loadEl =$(document).find( '.loadingshow' );
        if(loadEl.length != 0){
            return;
        }
        const ele = $(".active-menu").removeClass('active-menu');
        $(this).addClass("active-menu");
    })
    ///////////////////project client//////////////
    $(document).on('click','#project',function(e){
        e.preventDefault();
        const loadEl =$(document).find( '.loadingshow' );
        if(loadEl.length != 0){
            return;
        }
        const ele = $(".active-menu").removeClass('active-menu');
        $(this).addClass("active-menu");
    })
    ///////////////////invoice client//////////////
    $(document).on('click','#invoices',function(e){
        e.preventDefault();
        const loadEl =$(document).find( '.loadingshow' );
        if(loadEl.length != 0){
            return;
        }
        const ele = $(".active-menu").removeClass('active-menu');
        $(this).addClass("active-menu");
        const keyEmail = $(this).attr('data-user') ? $(this).attr('data-user'): '';
        $.ajax({
            url:client_ajax_object.ajaxUrl+'?oders=detail',
            dataType:'json',
            data:{ 
                action:'ajax_client',
                value:keyEmail
            },
            beforeSend:function(){
                $('.content').remove();
                $('.table-details' ).append( '<div style="display:block;" class="loadingshow" id="loading"></div>' );
            },
            success:function(response){
                if(response.success){
                    $('.table-details').find('#loading').remove();
                    console.log(response);
                    let data = response.data;
                    console.log(data);
                    console.log(Object.entries(data));
                    // const objE = obj.data;
                    // var start = 0;
                    // const d = new Date(objE.created_at);
                    //     $('.table-details' ).append(`
                    //         <div class="content">
                    //             <div class="menu-info">
                    //                 <ul class="nav3" >
                    //                     <li><a class="active-menu" href="#" id="profile">Profile</a></li>
                    //                     <li><a href="#" id="project">Project</a></li>
                    //                     <li><a href="#" id="invoices" data-user="${objE.email}">Invoices</a></li>
                    //                     <li><a href="#" id="contact">Contact us</a></li>
                    //                 </ul>
                    //             </div>
                    //             <hr>
                    //             <div class="content-child">
                    //                 <div class="row">
                    //                     <div class="col-xs-12">
                    //                         <div class="row">
                    //                             <div class="col-md-4 col-xs-6 b-r"> <strong class="tablehead">Full Name</strong> <br>
                    //                                 <p class="text-muted">${objE.name}</p>
                    //                             </div>
                    //                             <div class="col-md-4 col-xs-6 b-r"> <strong class="tablehead">Email</strong> <br>
                    //                                 <p class="text-muted">${objE.email}</p>
                    //                             </div>
                    //                             <div class="col-md-4 col-xs-6"> <strong class="tablehead">Mobile</strong> <br>
                    //                                 <p class="text-muted">${objE.mobile != null ? objE.mobile : ""} </p>
                    //                             </div>
                    //                         </div>
                    //                         <hr>
                    //                         <div class="row">
                    //                             <div class="col-md-4 col-xs-6 b-r"> <strong class="tablehead">Company Name</strong> <br>
                    //                                 <p class="text-muted">${objE.client_details.company_name != null? objE.client_details.company_name : "" }</p>
                    //                             </div>
                    //                             <div class="col-md-4 col-xs-6 b-r"> <strong class="tablehead">Website</strong> <br>
                    //                                 <p class="text-muted">${objE.client_details.website != null? objE.client_details.website : ""}</p>
                    //                             </div>
                    //                             <div class="col-md-4 col-xs-6"> <strong class="tablehead">Created at</strong> <br>
                    //                                 <p class="text-muted">${d.toLocaleDateString("en-GB")}</p>
                    //                             </div>
                    //                         </div>
                    //                         <hr>
                    //                         <div class="row">
                    //                             <div class="col-md-6 col-xs-6 b-r"> <strong class="tablehead">Address</strong> 
                    //                                 <p class="text-muted">${objE.client_details.address != null? objE.client_details.address : ""}</p>
                    //                             </div>
                    //                             <div class="col-md-6 col-xs-6"> <strong class="tablehead">Shipping Address</strong>
                    //                                 <p class="text-muted">${objE.client_details.shipping_address != null? objE.client_details.shipping_address : ""}</p>
                    //                             </div>
                    //                         </div>
                    //                             <hr>
                    //                         <div class="row">
                    //                             <div class="col-xs-6 b-r"> <strong class="tablehead">Address</strong>
                    //                                 <p class="text-muted">${objE.client_details.address != null? objE.client_details.address : ""}</p>
                    //                             </div>
                    //                             <div class="col-xs-6"> <strong class="tablehead">Shipping Address</strong>
                    //                                 <p class="text-muted">${objE.client_details.shipping_address != null? objE.client_details.shipping_address : ""}</p>
                    //                             </div>
                    //                         </div>
                    //                         <hr>
                    //                         <div class="row">
                    //                             <div class="col-xs-12"> <strong class="tablehead">Note</strong> <br>
                    //                                 <p class="text-muted">${objE.client_details.note != null? objE.client_details.note : ""}</p>
                    //                             </div>
                    //                         </div>
                    //                     </div>
                    //                 </div>
                    //             </div>
                    //         </div>
                    //     `);
                }else {
                    alert("LOI~")
                }
            },
        });
    })
    ///////////////////contact client//////////////
    $(document).on('click','#contact',function(e){
        e.preventDefault();
        const loadEl =$(document).find( '.loadingshow' );
        if(loadEl.length != 0){
            return;
        }
        const ele = $(".active-menu").removeClass('active-menu');
        $(this).addClass("active-menu");
    })
    ////////////// view one client/////////////
    $(document).on('click','.js-view',function(e){
        e.preventDefault();
        const loadEl =$(document).find( '.loadingshow' );
        if(loadEl.length != 0){
            return;
        }
        $(".table-details").addClass("activedetails");
        const idGet = $(this).attr('data-id') ? $(this).attr('data-id'): '';
        const val = $('#show').val() ? $('#show').val() : 10;
        const value = Number(val);
        $.ajax({
            url:client_ajax_object.ajaxUrl+'?idGet='+idGet,
            dataType:'json',
            data:{ 
                action: 'ajax_client',
                value:value
            },
            beforeSend:function(){
                $('.content').remove();
                $('.table-details' ).append( '<div style="display:block;" class="loadingshow" id="loading"></div>' );
            },
            success:function(response){
                if(response.success){
                    $('.table-details').find('#loading').remove();
                    let data = response.data.body;
                    let obj =JSON.parse(data);
                    const objE = obj.data;
                    var start = 0;
                    const d = new Date(objE.created_at);
                        $('.table-details' ).append(`
                            <div class="content">
                                <div class="menu-info">
                                    <ul class="nav3" >
                                        <li><a class="active-menu" href="#" id="profile">Profile</a></li>
                                        <li><a href="#" id="project">Project</a></li>
                                        <li><a href="#" id="invoices" data-user="${objE.email}">Invoices</a></li>
                                        <li><a href="#" id="contact">Contact us</a></li>
                                    </ul>
                                </div>
                                <hr>
                                <div class="content-child">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="row">
                                                <div class="col-md-4 col-xs-6 b-r"> <strong class="tablehead">Full Name</strong> <br>
                                                    <p class="text-muted">${objE.name}</p>
                                                </div>
                                                <div class="col-md-4 col-xs-6 b-r"> <strong class="tablehead">Email</strong> <br>
                                                    <p class="text-muted">${objE.email}</p>
                                                </div>
                                                <div class="col-md-4 col-xs-6"> <strong class="tablehead">Mobile</strong> <br>
                                                    <p class="text-muted">${objE.mobile != null ? objE.mobile : ""} </p>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-4 col-xs-6 b-r"> <strong class="tablehead">Company Name</strong> <br>
                                                    <p class="text-muted">${objE.client_details.company_name != null? objE.client_details.company_name : "" }</p>
                                                </div>
                                                <div class="col-md-4 col-xs-6 b-r"> <strong class="tablehead">Website</strong> <br>
                                                    <p class="text-muted">${objE.client_details.website != null? objE.client_details.website : ""}</p>
                                                </div>
                                                <div class="col-md-4 col-xs-6"> <strong class="tablehead">Created at</strong> <br>
                                                    <p class="text-muted">${d.toLocaleDateString("en-GB")}</p>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-6 col-xs-6 b-r"> <strong class="tablehead">Address</strong> 
                                                    <p class="text-muted">${objE.client_details.address != null? objE.client_details.address : ""}</p>
                                                </div>
                                                <div class="col-md-6 col-xs-6"> <strong class="tablehead">Shipping Address</strong>
                                                    <p class="text-muted">${objE.client_details.shipping_address != null? objE.client_details.shipping_address : ""}</p>
                                                </div>
                                            </div>
                                                <hr>
                                            <div class="row">
                                                <div class="col-xs-6 b-r"> <strong class="tablehead">Address</strong>
                                                    <p class="text-muted">${objE.client_details.address != null? objE.client_details.address : ""}</p>
                                                </div>
                                                <div class="col-xs-6"> <strong class="tablehead">Shipping Address</strong>
                                                    <p class="text-muted">${objE.client_details.shipping_address != null? objE.client_details.shipping_address : ""}</p>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-xs-12"> <strong class="tablehead">Note</strong> <br>
                                                    <p class="text-muted">${objE.client_details.note != null? objE.client_details.note : ""}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `);
                }else {
                    alert("LOI~")
                }
            },
        });
    });
    /////////////filler client//////////
    $('#show').change(function(){
        flag = false;
        const val = $(this).val() ? $(this).val() : 10;
        const pageN = $('bg-warning').attr('data-num') ? $('bg-warning').attr('data-num'): 1;
        const pageNum = Number(pageN);
        $.ajax({
			url: client_ajax_object.ajaxUrl+'?pageNum='+pageNum,
			type: 'post',
            dataType : "json",
			data: { 
                action: 'ajax_client',
                value : val,
            },
            beforeSend: function() 
            {
				$( '.filter_result tr').remove();
				$( '.filter_result' ).scrollTop(0);
                $( '.pagina ul' ).remove();
				$( '.filter_result' ).append( '<div style="display:block;" class="loadingshow" id="loading"></div>' );
			},
			success: function( response ) 
            {
                if(response.success) {
                    $( '.filter_result' ).find( '#loading' ).remove();
                    const siteUrl = client_ajax_object.getSiteUrl;
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
                    // const dn = new Date(2022,8,10,16,00,00);
                    // const d = new Date();
                    // var dayset =(dn.getTime());
                    // var currentday = (d.getTime());
                    // var khoangcach =  dayset - currentday;
                    // console.log(dn);
                    // console.log(d);
                    // console.log(Math.floor(khoangcach / (1000 * 60 * 60 * 24))+'d');
                    // console.log(Math.floor((khoangcach % (1000 * 60 * 60 * 24))/(1000*60*60))+'h');
                    // console.log(Math.floor((khoangcach % (1000 * 60 * 60))/(1000*60))+'m');
                    // console.log(Math.floor((khoangcach % (1000 * 60 ))/1000)+'s');
                    var start = (pageNum -1) * val;
                    for(element of arr){
                        start++;
                        const d = new Date(element.created_at);
                        $('.filter_result' ).append(`
                        <tr id ="id-${element.id}">		
                            <td>${start}</td>
                            <td>${element.name}</td>
                            <td>${element.client_details.company_name != null ? element.client_details.company_name : ""} </td>
                            <td>${element.email != null ? element.email :""} </td>
                            <td>${element.mobile != null ? element.mobile :""} </td>
                            <td>${d.toLocaleDateString("en-GB")}</td>
                            <td>
                                <div class="btn-action" data="${element.id}" >
                                    <i class="fa-solid fa-ellipsis-vertical icon-action"></i>
                                    <div class="wraper">
                                        <div class="show-action" id="${element.id}">
                                        <a href="${siteUrl}/wp-admin/admin.php?page=Client&view=edit&id=${element.id}&pageNum=${pageNum}" data-id="${element.id}" class="js-edit btn-addlist"><i class="icon-edit fa-solid fa-pencil"></i></a>
                                        <a href="${siteUrl}/wp-admin/admin.php?page=Client&view=details&id=${element.id}&pageNum=${pageNum}" data-id="${element.id}" class="js-view btn-addlist"><i class="icon-view fa-solid fa-magnifying-glass"></i></a>
                                        <button type="submit" data-toggle="modal" data-target="#exampleModal" class="delete btn-addlist p-2 gethref" data-id="${element.id}" data-href="${siteUrl}wp-admin/admin.php?page=lead&iddel=${element.id}&pageNum=${pageNum}"><i class="fa-solid fa-trash-can"></i></button>
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
    ///////////////// page link ///////////////
    $(document).on('click','.page-link',function(e)
    {
        e.preventDefault();
        const loadEl = $(document).find( '.loadingshow' );
        if(loadEl.length != 0){
            return;
        }
        flag = false;
        const pageN = $(this).attr('data-Num') ? $(this).attr('data-Num'): 1;
        const pageNum = Number(pageN);
        const val = $('#show').val() ? $('#show').val() : 10;
        const value = Number(val);
        $.ajax({
			url: client_ajax_object.ajaxUrl+'?pageNum='+pageNum,
			type: 'post',
            dataType : "json",
			data: { 
                action: 'ajax_client',
                value : value,
            },
            beforeSend: function() {		
				$( '.filter_result' ).scrollTop(0);
				$( '.filter_result' ).append( '<div style="display:block;" class="loadingshow" id="loading"></div>' );
			},
			success: function( response ) {
                if(response.success) {
                    $( '.filter_result tr').remove();
                    $( '.pagina ul' ).remove();
                    $( '.filter_result' ).find( '#loading' ).remove();
                    const siteUrl = client_ajax_object.getSiteUrl;
                    const data = response.data?.body;
                    const obj = JSON.parse(data);
                    const arr = obj.data;
                    console.log(arr);
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
                        const d = new Date(element.created_at);
                        $('.filter_result' ).append(`
                        <tr id ="id-${element.id}">		
                            <td>${start}</td>
                            <td>${element.name}</td>
                            <td>${element.client_details.company_name != null ? element.client_details.company_name : ""} </td>
                            <td>${element.email != null ? element.email:""} </td>
                            <td>${element.mobile != null ? element.mobile:""} </td>
                            <td>${d.toLocaleDateString("en-GB")}</td>
                            <td>
                                <div class="btn-action" data="${element.id}" >
                                    <i class="fa-solid fa-ellipsis-vertical icon-action"></i>
                                    <div class="wraper">
                                        <div class="show-action" id="${element.id}">
                                        <a href="${siteUrl}/wp-admin/admin.php?page=Client&view=edit&id=${element.id}&pageNum=${pageNum}" data-id="${element.id}" class="js-edit btn-addlist"><i class="icon-edit fa-solid fa-pencil"></i></a>
                                        <a href="${siteUrl}/wp-admin/admin.php?page=Client&view=details&id=${element.id}&pageNum=${pageNum}" data-id="${element.id}" class="js-view btn-addlist"><i class="icon-view fa-solid fa-magnifying-glass"></i></a>
                                        <button type="submit" data-toggle="modal" data-target="#exampleModal" class="delete btn-addlist p-2 gethref" data-id="${element.id}" data-href="${siteUrl}wp-admin/admin.php?page=lead&iddel=${element.id}&pageNum=${pageNum}"><i class="fa-solid fa-trash-can"></i></button>
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
                    if((arr.length) <= 0){
                        swal({
                            title: "Client empty!",
                            text: "You clicked the button!",
                            icon: "success",
                        })
                    }else{
                        
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