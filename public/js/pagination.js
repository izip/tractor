$(document).ready(function(){


/////////////////// Пагинация предложений


    if (location.pathname == '/' || location.pathname == '/index/index') {



        $(document).on('click','#page .left-side', function(){
           // console.log($('.left-side').height());

            console.log($('.left-side').scrollTop());



        });



    }


});
