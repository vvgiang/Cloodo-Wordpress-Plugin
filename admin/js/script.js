jQuery(document).ready(function($) {
    let siteUrl = script_object.getSiteUrl ? script_object.getSiteUrl : "";
    let urlIframe = script_object.urlIframe ? script_object.urlIframe : "";
    window.addEventListener('click', function(e){
        const ele = document.querySelectorAll(".show-action");
        for (const value of ele) {
            value.classList.remove('showHide');
        }
        if(e.target.classList.contains('btn-action')) {
            const currentId = (e.target.getAttribute('data'));
            var element = document.getElementById(currentId);
            element.classList.toggle("showHide");
        }
    });
    $(document).on('click',".js-register-quickly, .js-register, .js-login",(e)=>{
        const loadEl =$(document).find( '.loadingshow' );
        if(loadEl.length != 0){
            return;
        }
        $('body').append('<div  class="loadingshow" id="loading"></div>');
        $('#loading').fadeIn(300);
    });
    $(document).on('click',".js-getoken",sendData);
        function sendData(e) {
            try {
                        // e.preventDefault();
                        var valselect = $('select[name=accountselect] option').filter(':selected').val();
                        var myIfr = window.frames['iframeclws'].contentWindow;
                        var val = myIfr.postMessage(valselect,`${urlIframe}check-login`);
                        console.log(val);
            } catch (e) {
                console.log('Error: ' + e.message);
            }
        }
    window.addEventListener("message", (e) => {
        if (typeof e.data === "object") return;
            if (e.data == "send successfully") {
                swal({
                    title: "Successfully !",
                    text: "Wellcome to worksuite !",
                    icon: "success",
                });
                window.location.href = siteUrl +'/wp-admin/admin.php?page=Dashboard';
            }
    });
});
