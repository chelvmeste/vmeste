$(document).ready(function(){

    $.ajaxSetup({
        dataType: 'JSON'
    });
    $(document)
        .ajaxStart(function(){
            NProgress.start();
        })
        .ajaxStop(function(){
            NProgress.done();
        });

});