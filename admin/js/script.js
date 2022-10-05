jQuery(document).ready(function($) {
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
    $(document).on('click',".js-getoken",sendData);
        function sendData(e) {
            try {
                        // e.preventDefault();
                        var valselect = $('select[name=accountselect] option').filter(':selected').val();
                        var myIfr = window.frames['iframeclws'].contentWindow;
                        // popup = window.open("http://localhost/scroll-parallax/", 'window-2');
                        var val = myIfr.postMessage(valselect,'https://worksuite.cloodo.com/app-login');
                        
            } catch (e) {
                console.log('Error: ' + e.message);
            }
        }
    
});
