///////////////// Пагинация


pagin = {


    scroll: function () {

        $('.right-side').slimScroll({
            position: 'right',
            width: $('.right-side').width() - 3 + 'px',
            height: $('.right-side').height() - 100 + 'px',
            wheelStep: 5
        });
        MagicZoomPlus.refresh();
    },

    chat: function () {
        /////////////////////Пагинация чата

        if (location.pathname == '/chat') {
            var ch = this;

            $('.left-side').slimScroll({
                position: 'right',
                width: ($('.left-side').width() + 5) + 'px',
                height: $('.left-side').height() - 90 + 'px',
                wheelStep: 5
            }).on('slimscroll', function (e, pos) {
                console.log(pos);
                if (pos == 'bottom') {
                    var num = $('.left-side').attr('data-page-num');
                    var total = $('.left-side').attr('data-page-total');
                    num = (Number(num) + 1);

                    if (num <= total) {
                        $.ajax({
                            type: 'post',
                            url: '../chat',
                            data: {chat_list: 'y', page: num},
                            dataType: 'html',
                            success: function (html) {


                                $('.left-side').append($(html).find('.offer'));
                                ch.chat();

                                $('.left-side').attr('data-page-num', num);
                            }


                        });

                    }

                }

            });


        }
    },

    chatmicro: function () {
        /////////////////////Пагинация микродиалога в чате

        if (location.pathname == '/chat') {
            var ch = this;

            $('.right-side').slimScroll({
                position: 'right',
                width: ($('.right-side').width() - 5) + 'px',
                height: $('.right-side').height() - 50 + 'px',
                wheelStep: 5
            }).on('slimscroll', function (e, pos) {

                if (pos == 'bottom') {
                    dann = {};
                    dann.chat_id = $('.chat_list').first().attr('data-chat');
                    var num = $('.right-side').attr('data-page-num');
                    var total = $('.right-side').attr('data-page-total');
                    dann.page = (Number(num) + 1);

                    if (dann.page <= total) {
                        $.ajax({
                            type: 'post',
                            url: '../chat/chat',
                            data: dann,
                            dataType: 'html',
                            success: function (html) {


                                $('.right-side .content').append($(html).find('.mess'));
                                ch.chatmicro();

                                $('.right-side').attr('data-page-num', dann.page);
                            }


                        });

                    }

                }

            });


        }
    },

    offers: function () {
/////////////////// Пагинация предложений
        if (location.pathname == '/' || location.pathname == '/index/index') {

            var ch = this;
            $('.left-side').slimScroll({
                position: 'right',
                width: ($('.left-side').width() + 5) + 'px',
                height: function(){
                    if($('.left-side').height() < 400){
                        return   $('.left-side').height()+ 'px';
                    }
                    else{
                     return   $('.left-side').height() - 50 + 'px';
                    }


                },
                wheelStep: 5
            }).on('slimscroll', function (e, pos) {
                console.log(pos);
                if (pos == 'bottom') {
                    var num = $('.left-side').attr('data-page-num');
                    var total = $('.left-side').attr('data-page-total');
                    num = (Number(num) + 1);

                    if (num <= total) {
                        $.ajax({
                            type: 'post',
                            url: '../',
                            data: {up: 'y', page: num},
                            dataType: 'html',
                            success: function (html) {


                                $('.left-side').append($(html).find('.offer'));
                                $('.left-side').attr('data-page-num', num);
                                ch.offers();
                            }


                        });

                    }
                }

            });


        }

    },
    orders: function () {
/////////////////// Пагинация заявок
        if (location.pathname == '/order') {

            var ch = this;
            $('.left-side').slimScroll({
                position: 'right',
                width: ($('.left-side').width() + 5) + 'px',
                height: $('.left-side').height() - 50 + 'px',
                wheelStep: 5
            }).on('slimscroll', function (e, pos) {


               // console.log(pos);

                if (pos == 'bottom') {
                    var num = $('.left-side').attr('data-page-num');
                    var total = $('.left-side').attr('data-page-total');
                    num = (Number(num) + 1);

                    if (num <= total) {
                        $.ajax({
                            type: 'post',
                            url: '../order',
                            data: {od: 'y', page: num},
                            dataType: 'html',
                            success: function (html) {


                                $('.left-side').append($(html).find('.offer'));
                                $('.left-side').attr('data-page-num', num);
                                ch.orders();
                            }


                        });

                    }
                }

            });


        }

    }


}


$(document).ready(function () {
    pagin.offers();
    pagin.chat();
    pagin.orders();

});
