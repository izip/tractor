



$(document).ready(function(){


/////////////////// Пагинация предложений
    if (location.pathname == '/' || location.pathname == '/index/index') {

    $('.left-side').slimScroll({
        position: 'right',
        width:'500px',
        height: '500px',
        wheelStep: 5
    }).on('slimscroll', function(e, pos){
        console.log(pos);
        if(pos == 'bottom'){

            $.ajax({
                type:'post',
                url:'../',
                data:{up:'y',page:2},
                dataType:'html',
                success:function(html){


                   // var rt = $(html).find('#left-side-head-two').remove().find('.fix_holder').remove();

                   // $('.left-side').append($(rt).find('.left-side').html());
                    //$('.left-side').slimScroll({
                    //    position: 'right',
                    //    width:'500px',
                    //    height: '170px',
                    //    wheelStep: 5
                    //});
                }


            });

        }

    });


    }


});
