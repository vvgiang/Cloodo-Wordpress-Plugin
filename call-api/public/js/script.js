$(document).ready(function() {
    $('button.aaa').click(function(){
       var dataHref = $(this).attr('data-href');
       console.log(dataHref);
        $('.bbb').attr('href',dataHref);
    })
});