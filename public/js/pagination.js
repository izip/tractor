$(document).ready(function(){


/////////////////// Пагинация предложений

    $('.left-side').jScrollPane();
    if (location.pathname == '/' || location.pathname == '/index/index') {



        $('.left-side').on('scroll',function(){
           // console.log($('.left-side').height());

            console.log($('.left-side').scrollTop());



        });



    }


});
