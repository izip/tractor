
///////////////// Пагинация



pagin = {


    scroll: function(){

        $('.right-side').slimScroll({
            position: 'right',
            width:$('.right-side').width()-3+'px',
            height: $('.right-side').height()-100+'px',
            wheelStep: 5
        });
        MagicZoomPlus.refresh();
    },

    offers : function() {
/////////////////// Пагинация предложений
        if (location.pathname == '/' || location.pathname == '/index/index') {

            $('.left-side').slimScroll({
                position: 'right',
                width:'500px',
                height: $('.left-side').height()-50+'px',
                wheelStep: 5
            }).on('slimscroll', function (e, pos) {
                console.log(pos);
                if (pos == 'bottom') {

                    $.ajax({
                        type: 'post',
                        url: '../',
                        data: {up: 'y', page: 2},
                        dataType: 'html',
                        success: function (html) {


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

    },
    chat : function(){
    /////////////////////Пагинация чата

    if (location.pathname == '/chat' ) {

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
                    url:'../chat',
                    data:{chat_list:'y',page:2},
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
    }

}


$(document).ready(function(){
    pagin.offers();
    pagin.chat();



});
