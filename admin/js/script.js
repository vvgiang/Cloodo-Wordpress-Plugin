jQuery(document).ready(function($) {
    // $(".show-action").removeClass("showHide");
    // $(document).on('click','.btn-action',function(e){
    //     const curentId = $(this).attr('data');
    //     $('#'+ curentId).toggleClass('showHide');
    // })
    // const ele = document.querySelectorAll(".show-action");
    //     for (const value of ele) {
    //         value.classList.remove('showHide');
    //     }
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
});