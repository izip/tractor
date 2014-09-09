function auth() {
    var auth = 0;
    $.ajax({
        type: 'post',
        url: '../user/authr',
        async: false,
        success: function (data) {

            if (data == 1) {
                auth = 1;
            }


        }


    });

    if (auth == 1) {

        return true;
    }
    else {

        return false;
    }


}

// Авдополнение городов
function autocomplete(name){
    var substringMatcher = function(strs) {
        return function findMatches(q, cb) {
            var matches, substringRegex;


            matches = [];


            substrRegex = new RegExp(q, 'i');


            $.each(strs, function(i, str) {
                if (substrRegex.test(str)) {

                    matches.push({ value: str });
                }
            });

            cb(matches);
        };
    };

    $.ajax({
        type: 'post',
        url: '../index/autc',
        success: function (data) {


            var city = $.makeArray($.parseJSON(data));


            $(name).typeahead({
                    hint: true,
                    highlight: true,
                    minLength: 2
                },
                {
                    name: 'states',
                    displayKey: 'value',
                    source: substringMatcher(city)
                });

        }

    });





}

// Вывод контактов
$(document).ready(function () {

    $(document).on('click', '.b_contacts', function () {

        if (auth()) {
            $(this).toggleClass('activeted');

            if ($(this).hasClass('activeted')) {
                toggle_side_in();

                var offer_id = $('.offer.active').attr('data-offer');
                var order_id = $('.offer.active').attr('data-order');
                var di_id = $('.offer.active').attr('data-dialog');
                if(offer_id){
                $.ajax({
                    type: 'post',
                    url: '../index/contact',
                    data: {offer_id: offer_id},
                    success: function (data) {

                        $('.contact-left').replaceWith(data);
                        $('.filter-left').css('z-index', '0');
                        $('.contact-left').toggle().css('z-index', '9999999');
                    }


                });
                }
                if(order_id){


                    $.ajax({
                        type: 'post',
                        url: '../index/contact',
                        data: {order_id: order_id},
                        success: function (data) {

                            $('.contact-left').replaceWith(data);
                            $('.filter-left').css('z-index', '0');
                            $('.contact-left').toggle().css('z-index', '9999999');
                        }


                    });

                }
                if(di_id){


                    $.ajax({
                        type: 'post',
                        url: '../index/contact',
                        data: {di_id: di_id},
                        success: function (data) {

                            $('.contact-left').replaceWith(data);
                            $('.filter-left').css('z-index', '0');
                            $('.contact-left').toggle().css('z-index', '9999999');
                        }


                    });

                }


            }
            else {

                $('.filter-left').css('z-index', '99999999');
                $('.contact-left').toggle().css('z-index', '0');
                toggle_side_out();
            }


        }
        else {

            generate('Вы не авторизованы !', 'error');
            setTimeout(function () {
                window.location = "../user/auth"

            }, 1000);

        }

    });

/// Вывод предложений
//    Фото
    $(document).on('click' , '.mini_prev' , function(){
        try{
            var imga =  $('.images a').attr('href').match(/ig-([0-9])/g)[0].replace('ig-','');
            var imb =  $('.images a img').attr('src').match(/um-([0-9])/g)[0].replace('um-','');
            var imgref = $(this).attr('src').match(/ll-([0-9])/g)[0].replace('ll-','');
            var imgreft =  $('.images a').attr('href').replace('image-big-'+imga+'.jpg','image-big-'+imgref+'.jpg');
            var imgrefs =  $('.images a img').attr('src').replace('image-medium-'+imb+'.jpg','image-medium-'+imgref+'.jpg');
            if(imgreft && imgrefs){
                $('.images a').attr('href',imgreft);
                $('.images a img').attr('src',imgrefs);


                MagicZoomPlus.refresh();
            }
        }
        catch (e){

            // console.log(e);

        }
    });

    if (location.pathname == '/' || location.pathname == '/index/index') {


        $(document).on('click' ,"#cat_menu li a" , function(){
            var cat_id =  $(this).attr('data-cat');
        if(!$(this).parents("#cat_menu").hasClass('left90')){

            if(cat_id != undefined){

                $.ajax({
                    type: 'post',
                    url: '../',
                    data: 'cat_id=' + cat_id,
                    success: function (data) {
                        if(data ==1){
                            generate("В данной категории пока нет предложений" , "alert");
                        }
                        else{
                        $('.left').replaceWith(data);
                     var offer_id  = $('.offer').eq(0).attr('data-offer');
                        if(offer_id){
                        $.ajax({
                            type: 'post',
                            url: '../index/offer',
                            data: 'offer=' + offer_id,
                            success: function (data) {

                                $('.right').replaceWith(data);
                                $('.offer').eq(0).addClass('active');
                                MagicZoomPlus.refresh();
                                $('#left-side-head').scrollToFixed();


                            }


                        });
                        }
                        }
                    }

                });
            }
}
        });



        $.ajax({
            type: 'post',
            url: '../index/offer',
            data: 'offer=' + $('.offer').eq(0).attr('data-offer'),
            success: function (data) {

                $('.right').replaceWith(data);
                $('.offer').eq(0).addClass('active');
                MagicZoomPlus.refresh();
            }


        });


        $(document).on('click', '.offer', function () {

            var offer_id = $(this).attr('data-offer');
            //console.log(location.hostname+'/index/offer');

            $.ajax({
                type: 'post',
                url: '../index/offer',
                data: 'offer=' + offer_id,
                success: function (data) {

                    if($('.right-side-head').hasClass('left580')){

                        $('.right').replaceWith(data);
                        $('.right-side-head, #right-side').addClass('left580');
                        $('.right-side-head, #right-side ').addClass('right250');
                    }
                    else{
                    $('.right').replaceWith(data);
                    }
                    MagicZoomPlus.refresh();
                }


            });


        });




        $(document).on('click', '.add-item', function () {
            if (auth()) {

                window.location = "../myoffers/index";


            }
            else {

                generate('Вы не авторизованы !', 'error');
                setTimeout(function () {
                    window.location = "../user/auth";

                }, 1000);

            }

        });


        /// Комментирование предложений

        $(document).on('click', '.comments .put_comment', function () {
            if(auth())
            var comm = $('.comm').val();
            var offer = $('.comm').attr('data-offer');
            if (comm && offer) {
                $.ajax({
                    type: 'post',
                    url: '../index/comments',
                    data: {comm: comm, offer: offer},
                    success: function (data) {

                        generate('Комментарий добавлен', 'success');
                        $('.comments').replaceWith(data);
                        $('.comm').val('');


                    }


                });
            }
            else{

                generate('Для комментирования вы должны быть авторизованы','error');
            }
        });




    }


    // Отправка сообшения пользователю предложения

        $(document).on('click' , '.send_massage.full-description.send_me .put_comment',function(){
            var text = $('.send_massage.full-description.send_me textarea').val();
            var user_id = $('.name.main_page').attr('data-user');
            if(text && user_id){
            $.ajax({
                type:'post',
                url:'../message/adddialog',
                data:{user_id: user_id , text: text},
                success:function(data){
                if(data ==1){
                    generate('Сообщение отправлено' , 'success');
                }
                else{
                    generate('Нельзя отправить сообщение самому себе' , 'error');
                }
            }

            });
                $('.send_massage.send_me').toggle('slow');
             }

        });


    $(document).on('click' , '.send_massage.full-description.call_me .b_call_me',function(){

        var user_id = $('.name.main_page').attr('data-user');
        if( user_id){
            $.ajax({
                type:'post',
                url:'../message/adddialog',
                data:{user_id: user_id ,dn:'y'},
                success:function(data){
                    if(data ==1){
                        generate('Контакты отправлены' , 'success');
                    }
                    else{
                        generate('Нельзя отправить сообщение самому себе' , 'error');
                    }
                }

            });
            $('.send_me, .aftersend_massage').hide('slow');
        }

    });



    //// Работа с предложениями.


/// Вывод
    if (location.pathname == '/myoffers/index') {

        function addoffer() {

            $('.mul').MultiFile({
                accept: 'jpg|gif|bmp|png|rar', max: 4, STRING: {
                    remove: 'удалить',
                    selected: 'Выбраны: $file',
                    denied: 'Неверный тип файла: $ext!',
                    duplicate: 'Этот файл уже выбран:\n$file!'
                }});

            $('.addoffer').ajaxForm({

                success: function (data, statusText, xhr, $form) {
                    console.log(data);

                    //generate(dt.mess, error);
                }

            });


        }


        var offer_id = $('.offer').eq(0).attr('data-offer');
        if (offer_id) {
            $.ajax({
                type: 'post',
                url: '../myoffers/offer',
                data: 'offer=' + offer_id,
                success: function (data) {

                    $('.right').replaceWith(data);
                    $('.offer').eq(0).addClass('active');

                    MagicZoomPlus.refresh();
                }


            });
        }
        else {
            $.ajax({
                type: 'post',
                url: '../myoffers/addoffer',
                data: '',
                success: function (data) {

                        $('.right').replaceWith(data);
                        addoffer();

                }
            });
        }


        $(document).on('click', '.offer', function () {

            var offer_id = $(this).attr('data-offer');
          //  console.log(location.hostname + '/index/offer');

            $.ajax({
                type: 'post',
                url: '../myoffers/offer',
                data: 'offer=' + offer_id,
                success: function (data) {

                    $('.right').replaceWith(data);
                    $('.offer_edit').remove();

                    MagicZoomPlus.refresh();
                }


            });


        });

// Конец вывод


        //    Добавление

        function addoffer() {

            $('.mul').MultiFile({
                accept: 'jpg|gif|bmp|png|rar', max: 4, STRING: {
                    remove: 'удалить',
                    selected: 'Выбраны: $file',
                    denied: 'Неверный тип файла: $ext!',
                    duplicate: 'Этот файл уже выбран:\n$file!'
                }});

            $('.addoffer').ajaxForm({

                success: function (data, statusText, xhr, $form) {
                    console.log(data);
                    var mess = $.parseJSON(data);

                    if (mess.success) {

                        generate(mess.success, 'success');

                        $.ajax({
                            type: 'post',
                            url: '../myoffers/index',
                            data: {up: true },
                            success: function (data) {

                                $('.myofferpage').replaceWith(data);

                                $.ajax({
                                    type: 'post',
                                    url: '../myoffers/offer',
                                    data: 'offer=' + mess.offer_id,
                                    success: function (data) {

                                        $('.right').replaceWith(data);
                                        $('.offer[data-offer='+mess.offer_id+']').addClass('active');

                                    }


                                });


                            }


                        });


                    }
                    else {
                        for (var key in mess) {

                            generate(mess[key], 'error');

                        }
                    }

                }

            });


        }

        $(document).on("change", '.MultiFile-wrap input', function () {
            var filelist = $('.MultiFile-list').html();
            //  $('.MultiFile-list').remove();
            //$('.images').append(filelist);

        });
        $(document).on("click", '.first_pad.b_post_order', function () {


            $('.addoffer').submit();


        });

        $(document).on("click", '.b_publick_order', function () {

            $('.addoffer').prepend('<input name="public" type="hidden" value="y">');

            $('.addoffer').submit();


        });


        $(document).on('click', '.add-item', function () {

            $.ajax({
                type: 'post',
                url: '../myoffers/addoffer',
                data: '',
                success: function (data) {

                        $('.right').replaceWith(data);

                    autocomplete("[name=city]");

                        var cat_id = $('[name=cat_id]').val();

                        if(cat_id ){
                            $.ajax({
                                type: 'post',
                                url: '../myoffers/catf',
                                data: {cat_id: cat_id,c:'y'},
                                success: function (data) {

                                    $('.catf').replaceWith(data);

                                }



                            });
                            $.ajax({
                                type: 'post',
                                url: '../myoffers/subcat',
                                data: {cat_id: cat_id},
                                success: function (data) {

                                    $('.subcat').replaceWith(data);
                                    selects();
                                    var sub_cat_id = $('[name=sub_cat_id]').val();
                                    if(sub_cat_id){
                                    $.ajax({
                                        type: 'post',
                                        url: '../myoffers/catf',
                                        data: {cat_id: sub_cat_id},
                                        success: function (data) {

                                            $('.dop_f').replaceWith(data);

                                        }

                                    });

                                    }

                                }

                            });

                        }
                        addoffer();
                        selects();

                }


            });


        });

        // Категории

        $(document).on('change', '[name=cat_id]', function () {

            var cat_id = $(this).val();

            if(cat_id){
                $.ajax({
                    type: 'post',
                    url: '../myoffers/subcat',
                    data: {cat_id: cat_id},
                    success: function (data) {

                        $('.subcat').replaceWith(data);
                        selects();
                    }



                });
            }

        });

        $(document).on('change', '[name=sub_cat_id] , [name=cat_id]', function () {

            if($(this).attr('name') == 'cat_id'){
            var cat_id = $(this).val();

                if(cat_id){
                    $.ajax({
                        type: 'post',
                        url: '../myoffers/catf',
                        data: {cat_id: cat_id,c:'y'},
                        success: function (data) {

                            $('.catf').replaceWith(data);
                            var sub_cat_id = $('[name=sub_cat_id]').val();
                            if(sub_cat_id){
                            $.ajax({
                                type: 'post',
                                url: '../myoffers/catf',
                                data: {cat_id: sub_cat_id},
                                success: function (data) {

                                    $('.dop_f').replaceWith(data);

                                }



                            });
                            }

                        }



                    });



            }

            }
            else{

                var cat_id = $(this).val();
                if(cat_id){
                    $.ajax({
                        type: 'post',
                        url: '../myoffers/catf',
                        data: {cat_id: cat_id},
                        success: function (data) {

                            $('.dop_f').replaceWith(data);

                        }



                    });
                }

            }

        });





//// Форма предложения

        $(document).on('click', 'button.styled_big', function () {
            $(this).toggleClass('active');


            if ($(this).has('input').attr('class')) {


                if ($(this).hasClass('active')) {
                    $(this).children('input').val('y');
                    $(this).children('input').prop('disabled', false);
                }
                else {
                    $(this).children('input').val('n');


                }
            }
            else {

                if ($(this).next('p').has('input').attr('class')) {

                    if ($(this).hasClass('active')) {

                        $(this).next('p').find('input').prop('disabled', false);
                        $(this).next('p').find('.temp').remove();
                    }
                    else {

                        $(this).next('p').find('input').prop('disabled', true);
                        var cl = $(this).next('p').find('input').attr('name');
                        $(this).next('p').prepend('<input class="temp" name="' + cl + '" value="" hidden>');

                    }

                }
                console.log($(this).parent().find('input').attr('class'));
                if ($(this).parent().find('input').attr('class')) {

                    if ($(this).hasClass('active')) {

                        $(this).parent().find('input').prop('disabled', false);
                        $(this).parent().find('.temp').remove();
                    }
                    else {

                        var cl = $(this).parent().find('input').attr('name');
                        $(this).parent().find('input').prop('disabled', true);
                        $(this).parent().prepend('<input class="temp" name="' + cl + '" value="" hidden>');

                    }

                }


            }
        });

        /// Конец вывод  и добавление предложений

        /// Редактирование предложений


        $(document).on('click', '.b_off_change', function () {
            var offer_id = $('.offer.active').attr('data-offer');
            if (offer_id) {
                $.ajax({
                    type: 'post',
                    url: '../myoffers/redoffer',
                    data: {offer_id: offer_id},
                    success: function (data) {


                        $('.right').replaceWith(data);
                        autocomplete("[name=city]");
                        selects();
                        addoffer();

                    }


                });
            }
            else {

                generate('Нет сохраненных предложений !', 'error');
            }

        });


        /// Конец Редактирование предложений

        ///Удаление предложений

        $(document).on('click', '.b_off_kill', function () {

            var offer_id = $('.offer.active').attr('data-offer');
            if (offer_id) {

                $.ajax({
                    type: 'post',
                    url: '../myoffers/deloffer',
                    data: {offer_id: offer_id},
                    success: function (data) {

                        generate('Предложение удалено', 'alert');

                        $.ajax({
                            type: 'post',
                            url: '../myoffers/index',
                            data: {up: true },
                            success: function (data) {

                                $('.myofferpage').replaceWith(data);
                                var offer_id = $('.offer').eq(0).attr('data-offer');
                                if (offer_id) {
                                    $.ajax({
                                        type: 'post',
                                        url: '../myoffers/offer',
                                        data: 'offer=' + offer_id,
                                        success: function (data) {

                                            $('.right').replaceWith(data);
                                            $('.offer').eq(0).addClass('active');

                                        }


                                    });
                                }
                                else {
                                    $('.add-item').click();

                                }

                            }


                        });


                    }



                });


            }
            else {

                generate('Нет сохраненных предложений !', 'error');

            }

        });

// Комментарии предложений
        $(document).on('click', '.comments .put_comment', function () {


            var comm = $('.comm').val();
            var offer = $('.comm').attr('data-offer');
            if (comm && offer) {
                $.ajax({
                    type: 'post',
                    url: '../index/comments',
                    data: {comm: comm, offer: offer},
                    success: function (data) {

                        generate('Комментарий добавлен', 'success');
                        $('.comments').replaceWith(data);
                        $('.comm').val('');


                    }


                });
            }



        });



    }

////Вывод заявок
    if (location.pathname == '/orders/index') {

        $(document).on('click' ,"#cat_menu li a" , function(){
            var cat_id =  $(this).attr('data-cat');

                    $.ajax({
                        type: 'post',
                        url: '../orders/index',
                        data: {cat_id: cat_id},
                        success: function (data) {
                            if(data ==1){
                                generate("В данной категории пока нет Заявок" , "alert");
                            }
                            else{
                                $('.left').replaceWith($(data).find('.left'));
                                var order_id  = $('.offer').eq(0).attr('data-offer');
                                if(order_id){
                                    $.ajax({
                                        type: 'post',
                                        url: '../orders/order',
                                        data: 'order=' + order_id,
                                        success: function (data) {

                                            $('.right').replaceWith(data);
                                            $('.offer').eq(0).addClass('active');

                                            $('#left-side-head').scrollToFixed();


                                        }


                                    });
                                }
                            }
                        }

                    });


        });


        $(document).on('click' , '.add-item',function(){
            if(auth()){
            window.location = "../myorders/index";
            }
            else{
                generate("Пожалуйста авторизуйтесь" , "error");
                setTimeout(function(){
                    window.location = "../user/auth";
                },1000)

            }
        });

        var order = $('.offer').eq(0).attr('data-order');
        if (order) {
            $.ajax({
                type: 'post',
                url: '../orders/order',
                data: 'order=' + order,
                success: function (data) {

                    $('.right').replaceWith(data);
                    $('.offer').eq(0).addClass('active');

                }


            });

        }
        else{
            $('.add-item').click();

        }

        $(document).on('click', '.offer', function () {
            var order = $(this).attr('data-order');

            if (order) {
                $.ajax({
                    type: 'post',
                    url: '../orders/order',
                    data: {order: order},
                    success: function (data) {

                        $('.right').replaceWith(data);


                    }

                });

            }
        });


        $(document).on('click', '.put_comment', function () {

            if(auth()){
            var comm = $('.comm').val();
            var order = $('.comm').attr('data-order');
            if (comm && order) {
                $.ajax({
                    type: 'post',
                    url: '../orders/comments',
                    data: {comm: comm, order: order},
                    success: function (data) {

                        generate('Комментарий добавлен', 'success');
                        $('.comments').replaceWith(data);
                        $('.comm').val('');


                    }


                });
            }
        }
          else{

                generate('Для комментирования вы должны быть авторизованы','error');

            }

        });

    }

// Добавление Заявок

    if (location.pathname == '/myorders/index') {

        function addorder(){

            $('.addorder').ajaxForm({

                success: function (data, statusText, xhr, $form) {
                    console.log(data);
                    var mess = $.parseJSON(data);

                    if (mess.success) {

                        generate(mess.success, 'success');

                        $.ajax({
                            type:'post',
                            url:'../myorders/index',
                            data:{od:'y'},
                            success:function(data){

                                $('.order-page').replaceWith(data);

                                $.ajax({
                                    type:'post',
                                    url:'../myorders/order',
                                    data:{order:mess.order_id},
                                    success:function(data){
                                        $('.right').replaceWith(data);
                                        $('.offer[data-order='+mess.order_id+']').addClass('active');
                                    }
                                });

                            }


                        });


                    }


                    else {
                        for (var key in mess) {

                            generate(mess[key], 'error');

                        }
                    }
                }

            });
        }



        $(document).on('click', '.add-item', function () {
            $.ajax({
                type: 'post',
                url: '../myorders/addorder',
                data: {},
                success: function (data) {

                        $('.right').replaceWith(data);
                        addorder();
                        selects();


                }


            });


        });



        var order = $('.offer').eq(0).attr('data-order');
        if (order) {
            $.ajax({
                type: 'post',
                url: '../myorders/order',
                data: 'order=' + order,
                success: function (data) {

                    $('.right').replaceWith(data);
                    $('.offer').eq(0).addClass('active');

                }


            });

        }
        else{
            $('.add-item').click();

        }

        $(document).on('click', '.offer', function () {
            var order = $(this).attr('data-order');

            if (order) {
                $.ajax({
                    type: 'post',
                    url: '../myorders/order',
                    data: {order: order},
                    success: function (data) {

                        $('.right').replaceWith(data);


                    }

                });

            }
        });
/// Добавление заявки


        // Категории заявки
        $(document).on('change', '[name=cat_id]', function () {

            var cat_id = $(this).val();

            if(cat_id){
                $.ajax({
                    type: 'post',
                    url: '../myorders/subcat',
                    data: {cat_id: cat_id},
                    success: function (data) {

                        $('.subcat').replaceWith(data);
                        selects();
                    }



                });
            }

        });





/// Обработка формы заявки

        $(document).on('click' , '.b_post_order' , function(){

            $('.addorder').submit();



        });
        $(document).on("click", '.b_publick_order', function () {

            $('.addorder').prepend('<input name="public" type="hidden" value="y">');

            $('.addorder').submit();


        });

        /// Редактирование заявок

        $(document).on('click' , '.b_off_change' , function(){

            var order = $('.offer.active').attr('data-order');
            $.ajax({
                type: 'post',
                url: '../myorders/redorder',
                data: {order: order},
                success: function (data) {

                    $('.right').replaceWith(data);
                    addorder();
                    selects();
                }

            });



        });


        //Удаление заявок
        $(document).on('click' , '.b_off_kill' , function(){

            var order = $('.offer.active').attr('data-order');
            if(order) {
                $.ajax({
                   type:'post',
                   url:'../myorders/delorder',
                   data:{order:order},
                    success:function(data){

                        generate('Заявка удалена', 'alert');
                        $.ajax({
                            type:'post',
                            url:'../myorders/index',
                            data:{od:'y'},
                            success:function(data){

                                $('.order-page').replaceWith(data);
                                order = $('.offer').eq(0).attr('data-order');
                                if(order){
                                $.ajax({
                                    type:'post',
                                    url:'../myorders/order',
                                    data:{order:order},
                                    success:function(data){
                                        $('.right').replaceWith(data);
                                        $('.offer').eq(0).addClass('active');
                                    }
                                });
                                }
                                else{
                                    $('.add-item').click();

                                }
                            }


                        });



                    }

                });


            }


        });


/// Комментарии заявок

        $(document).on('click', '.put_comment', function () {


            var comm = $('.comm').val();
            var order = $('.comm').attr('data-order');
            if (comm && order) {
                $.ajax({
                    type: 'post',
                    url: '../orders/comments',
                    data: {comm: comm, order: order},
                    success: function (data) {

                        generate('Комментарий добавлен', 'success');
                        $('.comments').replaceWith(data);
                        $('.comm').val('');


                    }


                });
            }



        });


        // Отправка сообшения пользователю предложения

        $(document).on('click' , '.send_massage.full-description.send_me .put_comment',function(){
            var text = $('.send_massage.full-description.send_me textarea').val();
            var user_id = $('.name.main_page').attr('data-user');
            if(text && user_id){
                $.ajax({
                    type:'post',
                    url:'../message/adddialog',
                    data:{user_id: user_id , text: text},
                    success:function(data){
                        if(data ==1){
                            generate('Сообщение отправлено' , 'success');
                        }
                        else{
                            generate('Нельзя отправить сообщение самому себе' , 'error');
                        }

                    }

                });
                $('.send_massage.send_me').toggle('slow');
            }

        });


        $(document).on('click' , '.send_massage.full-description.call_me .b_call_me',function(){

            var user_id = $('.name.main_page').attr('data-user');
            if( user_id){
                $.ajax({
                    type:'post',
                    url:'../message/adddialog',
                    data:{user_id: user_id ,dn:'y'},
                    success:function(data){
                        if(data ==1){
                            generate('Контакты отправлены' , 'success');
                        }
                        else{
                            generate('Нельзя отправить сообщение самому себе' , 'error');
                        }
                    }

                });
                $('.send_me, .aftersend_massage').hide('slow');
            }

        });



    }

});