///////////////////// Функция проверки авторизации
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
function autocomplete(name) {
    var substringMatcher = function (strs) {
        return function findMatches(q, cb) {
            var matches, substringRegex;


            matches = [];


            substrRegex = new RegExp(q, 'i');


            $.each(strs, function (i, str) {
                if (substrRegex.test(str)) {

                    matches.push({value: str});
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
    // console.log(window.location.hash);


    $(document).on('click', '.b_contacts', function () {

        if (auth()) {
            $(this).toggleClass('activeted');

            if ($(this).hasClass('activeted')) {
                toggle_side_in();

                var offer_id = $('.offer.active').attr('data-offer');
                var order_id = $('.offer.active').attr('data-order');
                var di_id = $('.offer.active').attr('data-dialog');
                var chat_user_id = $('.chat_left .name').attr('data-user');
                if (offer_id) {
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
                if (order_id) {


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
                if (di_id) {


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
                if (chat_user_id) {


                    $.ajax({
                        type: 'post',
                        url: '../index/contact',
                        data: {user_id: chat_user_id},
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
    $(document).on('click', '.mini_prev', function () {
        try {
            var imga = $('.images a').attr('href').match(/ig-([0-9])/g)[0].replace('ig-', '');
            var imb = $('.images a img').attr('src').match(/um-([0-9])/g)[0].replace('um-', '');
            var imgref = $(this).attr('src').match(/ll-([0-9])/g)[0].replace('ll-', '');
            var imgreft = $('.images a').attr('href').replace('image-big-' + imga + '.jpg', 'image-big-' + imgref + '.jpg');
            var imgrefs = $('.images a img').attr('src').replace('image-medium-' + imb + '.jpg', 'image-medium-' + imgref + '.jpg');
            if (imgreft && imgrefs) {
                $('.images a').attr('href', imgreft);
                $('.images a img').attr('src', imgrefs);


                MagicZoomPlus.refresh();
            }
        }
        catch (e) {

            // console.log(e);

        }
    });

    if (location.pathname == '/' || location.pathname == '/index/index') {

//////////////////////// Меню предложений
        $(document).on('click', "#cat_menu li a , #sub_cat_menu li a", function () {
            var dann = {};
            if ($(this).attr('data-cat')) {

                dann.cat_id = $(this).attr('data-cat');
            }
            else if ($(this).attr('sub-cat')) {
                dann.cat_id = $(this).attr('data-cat');
                dann.sub_cat = 'y';
            }
            if (!$(this).parents("#cat_menu").hasClass('left90')) {

                if (dann.cat_id != undefined) {

                    $.ajax({
                        type: 'post',
                        url: '../',
                        data: dann,
                        success: function (data) {
                            if (data == 1) {
                                generate("В данной категории пока нет предложений", "alert");
                            }
                            else {
                                $('.left').replaceWith(data);
                                var offer_id = $('.offer').eq(0).attr('data-offer');
                                if (offer_id) {
                                    $.ajax({
                                        type: 'post',
                                        url: '../index/offer',
                                        data: 'offer=' + offer_id,
                                        success: function (data) {

                                            $('.right').replaceWith(data);
                                            $('.offer').eq(0).addClass('active');
                                            pagin.scroll();
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

                pagin.scroll();
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

                    if ($('.right-side-head').hasClass('left580')) {

                        $('.right').replaceWith(data);
                        $('.right-side-head, #right-side').addClass('left580');
                        $('.right-side-head, #right-side ').addClass('right250');
                    }
                    else {
                        $('.right').replaceWith(data);
                    }
                    pagin.scroll();
                }


            });


        });


        $(document).on('click', '.add-item', function () {
            if (auth()) {

                window.location = "../myoffers#add";


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
            if (auth())
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
            else {

                generate('Для комментирования вы должны быть авторизованы', 'error');
            }
        });


    }


    // Отправка сообшения пользователю предложения

    $(document).on('click', '.send_massage.full-description.send_me .put_comment', function () {
        var text = $('.send_massage.full-description.send_me textarea').val();
        var user_id = $('.name.main_page').attr('data-user');
        if (text && user_id) {
            $.ajax({
                type: 'post',
                url: '../message/adddialog',
                data: {user_id: user_id, text: text},
                success: function (data) {
                    if (data == 1) {
                        generate('Сообщение отправлено', 'success');
                    }
                    else {
                        generate('Нельзя отправить сообщение самому себе', 'error');
                    }
                }

            });
            $('.send_massage.send_me').toggle('slow');
        }

    });


    $(document).on('click', '.send_massage.full-description.call_me .b_call_me', function () {

        var user_id = $('.name.main_page').attr('data-user');
        if (user_id) {
            $.ajax({
                type: 'post',
                url: '../message/adddialog',
                data: {user_id: user_id, dn: 'y'},
                success: function (data) {
                    if (data == 1) {
                        generate('Контакты отправлены', 'success');
                    }
                    else {
                        generate('Нельзя отправить сообщение самому себе', 'error');
                    }
                }

            });
            $('.send_me, .aftersend_massage').hide('slow');
        }

    });


    //// Работа с предложениями.


/// Вывод
    if (location.pathname == '/myoffers') {

        function addoffer() {

            $('.mul').MultiFile({
                accept: 'jpg|gif|bmp|png|rar', max: 4, STRING: {
                    remove: 'удалить',
                    selected: 'Выбраны: $file',
                    denied: 'Неверный тип файла: $ext!',
                    duplicate: 'Этот файл уже выбран:\n$file!'
                }
            });

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
                }
            });

            $('.addoffer').ajaxForm({

                success: function (data, statusText, xhr, $form) {
                    console.log(data);
                    var mess = $.parseJSON(data);

                    if (mess.success) {

                        generate(mess.success, 'success');

                        $.ajax({
                            type: 'post',
                            url: '../myoffers',
                            data: {up: true},
                            success: function (data) {

                                $('.myofferpage').replaceWith(data);

                                $.ajax({
                                    type: 'post',
                                    url: '../myoffers/offer',
                                    data: 'offer=' + mess.offer_id,
                                    success: function (data) {

                                        $('.right').replaceWith(data);
                                        $('.offer[data-offer=' + mess.offer_id + ']').addClass('active');

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

                    if (cat_id) {
                        $.ajax({
                            type: 'post',
                            url: '../myoffers/catf',
                            data: {cat_id: cat_id, c: 'y'},
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
                                if (sub_cat_id) {
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

        if (window.location.hash == '#add') {
            $('.add-item').click();
        }


        // Категории

        $(document).on('change', '[name=cat_id]', function () {

            var cat_id = $(this).val();

            if (cat_id) {
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

            if ($(this).attr('name') == 'cat_id') {
                var cat_id = $(this).val();

                if (cat_id) {
                    $.ajax({
                        type: 'post',
                        url: '../myoffers/catf',
                        data: {cat_id: cat_id, c: 'y'},
                        success: function (data) {

                            $('.catf').replaceWith(data);
                            var sub_cat_id = $('[name=sub_cat_id]').val();
                            if (sub_cat_id) {
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
            else {

                var cat_id = $(this).val();
                if (cat_id) {
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
                            url: '../myoffers',
                            data: {up: true},
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
    if (location.pathname == '/orders') {

        $(document).on('click', "#cat_menu li a , #sub_cat_menu li a", function () {

            var dann = {};
            if ($(this).attr('data-cat')) {

                dann.cat_id = $(this).attr('data-cat');
            }
            else if ($(this).attr('sub-cat')) {
                dann.cat_id = $(this).attr('data-cat');
                dann.sub_cat = 'y';
            }



            $.ajax({
                type: 'post',
                url: '../orders',
                data: dann,
                success: function (data) {
                    if (data == 1) {
                        generate("В данной категории пока нет Заявок", "alert");
                    }
                    else {
                        $('.left').replaceWith($(data).find('.left'));
                        var order_id = $('.offer').eq(0).attr('data-offer');
                        if (order_id) {
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


        $(document).on('click', '.add-item', function () {
            if (auth()) {
                window.location = "../myorders#add";
            }
            else {
                generate("Пожалуйста авторизуйтесь", "error");
                setTimeout(function () {
                    window.location = "../user/auth";
                }, 1000)

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
        else {
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

            if (auth()) {
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
            else {

                generate('Для комментирования вы должны быть авторизованы', 'error');

            }

        });

    }

// Добавление Заявок

    if (location.pathname == '/myorders') {

        function addorder() {

            $('.addorder').ajaxForm({

                success: function (data, statusText, xhr, $form) {
                    console.log(data);
                    var mess = $.parseJSON(data);

                    if (mess.success) {

                        generate(mess.success, 'success');

                        $.ajax({
                            type: 'post',
                            url: '../myorders',
                            data: {od: 'y'},
                            success: function (data) {

                                $('.order-page').replaceWith(data);

                                $.ajax({
                                    type: 'post',
                                    url: '../myorders/order',
                                    data: {order: mess.order_id},
                                    success: function (data) {
                                        $('.right').replaceWith(data);
                                        $('.offer[data-order=' + mess.order_id + ']').addClass('active');
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
                    $('#date-to-tex , #date-from-tex').datepicker({
                        orientation:'top left'

                    });

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
        else {
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

            if (cat_id) {
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

        $(document).on('click', '.b_post_order', function () {

            $('.addorder').submit();


        });
        $(document).on("click", '.b_publick_order', function () {

            $('.addorder').prepend('<input name="public" type="hidden" value="y">');

            $('.addorder').submit();


        });

        /// Редактирование заявок

        $(document).on('click', '.b_off_change', function () {

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
        $(document).on('click', '.b_off_kill', function () {

            var order = $('.offer.active').attr('data-order');
            if (order) {
                $.ajax({
                    type: 'post',
                    url: '../myorders/delorder',
                    data: {order: order},
                    success: function (data) {

                        generate('Заявка удалена', 'alert');
                        $.ajax({
                            type: 'post',
                            url: '../myorders',
                            data: {od: 'y'},
                            success: function (data) {

                                $('.order-page').replaceWith(data);
                                order = $('.offer').eq(0).attr('data-order');
                                if (order) {
                                    $.ajax({
                                        type: 'post',
                                        url: '../myorders/order',
                                        data: {order: order},
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

        $(document).on('click', '.send_massage.full-description.send_me .put_comment', function () {
            var text = $('.send_massage.full-description.send_me textarea').val();
            var user_id = $('.name.main_page').attr('data-user');
            if (text && user_id) {
                $.ajax({
                    type: 'post',
                    url: '../message/adddialog',
                    data: {user_id: user_id, text: text},
                    success: function (data) {
                        if (data == 1) {
                            generate('Сообщение отправлено', 'success');
                        }
                        else {
                            generate('Нельзя отправить сообщение самому себе', 'error');
                        }

                    }

                });
                $('.send_massage.send_me').toggle('slow');
            }

        });


        $(document).on('click', '.send_massage.full-description.call_me .b_call_me', function () {

            var user_id = $('.name.main_page').attr('data-user');
            if (user_id) {
                $.ajax({
                    type: 'post',
                    url: '../message/adddialog',
                    data: {user_id: user_id, dn: 'y'},
                    success: function (data) {
                        if (data == 1) {
                            generate('Контакты отправлены', 'success');
                        }
                        else {
                            generate('Нельзя отправить сообщение самому себе', 'error');
                        }
                    }

                });
                $('.send_me, .aftersend_massage').hide('slow');
            }

        });


    }

    if (window.location.hash == '#add') {

        setTimeout(function () {
            $('.add-item').click()
        }, 200);
    }

    /////// Профиль пользователя
    if (location.pathname == '/option') {
        autocomplete("[name=country]");
        $('.form_profile_submit').on('click', function () {


            $.ajax({
                type: 'post',
                url: '../option/confirm',
                data: $('.form_profile').serialize(),
                dataType: 'json',
                success: function (json) {

                    console.log(json);
                    if (json.success) {

                        generate(json.success, 'success');
                    }
                    else if (json.error) {

                        generate(json.error, 'error');
                    }


                }


            });

        });


    }

});


////////////////////////// Авторизация и регистрация пользователя


$(document).ready(function () {
    $('#open-icon-menu a').click(function () {
        $('p.menu-head-warp').toggle();
        $('.logo-icon').toggle();
        $('#menu').toggle(function () {
            css("z-index", "999999");
        }, function () {
            css("z-index", "0");
        });
    });


});

$(document).ready(function () {

    $(" [name=reg_phone], [name=login_phone]").mask("+7 (999) 999-99-99");


});

///Функция вывода ошибок
function generate(text, type) {
    var n = noty({
        text: text,
        type: type,
        dismissQueue: true,
        modal: true,
        layout: 'topLeft',
        theme: 'defaultTheme',
        maxVisible: 10
    });
    //  console.log('html: ' + n.options.id);
    setTimeout(function () {
        n.close();
    }, 2000);
}

$(document).ready(function () {
// Перехват информациооных сообщений
//Ошибки
    if ($("div").is(".alert-error")) {

        var err = $(".alert-error").text();
        $(".alert-error").remove();
        generate(err, "error");


    }

    if ($("div").is(".errorMessage")) {
        var err = $(".errorMessage").text();
        $(".errorMessage").remove();
        generate(err, "error");

    }

// Подтверждения

    if ($("div").is(".alert-success")) {

        var success = $(".alert-success").text();
        $(".alert-success").remove();
        generate(success, "success");


    }

    if ($("div").is(".successMessage")) {
        var success = $(".successMessage").text();
        $(".successMessage").remove();
        generate(success, "success");

    }


});

//if(location.pathname == '/user/auth'){
//$.ajax({
//    type: 'post',
//    url: '../index/index',
//    data: {up: true },
//    success: function (data) {
//
//        $('.left').replaceWith($(data).find('.left').html());
//
//    }
//
//
//});
//}


// Валидация
function valid_form(form) {

    var valid;
    var valid_name = true;
    var valid_phone = true;
    var valid_email = true;
    // console.log($(form).filter("input").val());

    $(form).children("input").each(function (ind, elem) {


        if ($(elem).attr("name") == "reg_name") {

            var name = $(elem).val();
            valid_name = (/^[_a-zA-Z0-9а-яА-Я ]+$/.test(name) === true);
            if (!valid_name) {
                $(elem).css("border-color", "#FC0505");
                generate("Не корректно заполнено поле Имя", 'error');
            }
            else {
                $(elem).css("border-color", "#1EA827");

            }

        }
        if ($(elem).attr("name") == "reg_phone") {

            var phone = $(elem).val();
            valid_phone = (/^(\+?\d+)?\s*(\(\d+\))?[\s-]*([\d-]*)$/.test(phone) === true &&
            /^\s*$/.test(phone) === false);

            if (!valid_phone) {
                $(elem).css("border-color", "#FC0505");
                generate("Не корректно заполнено поле Телефон", 'error');
            }
            else {
                $(elem).css("border-color", "#1EA827");

            }
        }

        if ($(elem).attr("name") == "reg_mail") {

            var email = $(elem).val();
            valid_email = (/^\S+@\S+$/.test(email) === true);
            if (!valid_email) {
                $(elem).css("border-color", "#FC0505");
                generate("Не корректно заполнено поле Email", 'error');
            }
            else {
                $(elem).css("border-color", "#1EA827");

            }
        }


    });
    valid = valid_name && valid_phone && valid_email;
    if (valid) {

        return valid = true;
    }
}
// Регистрация


$(document).on("click", "#reg_sub", function () {

    //   console.log(valid_form($("#registerForm")));
    if (valid_form($("#registerForm"))) {

        var zap_reg = "code=y&" + $('#token-register').attr('name') + '=' + $('#token-register').val() + '&' + 'phone=' + $("#registerForm [name=reg_phone]").val() + '&email=' + $("#registerForm [name=reg_mail]").val();

        $.ajax({
            url: "/user/register",
            type: "post",
            data: zap_reg,
            success: function (date) {

                var mess = $.parseJSON(date);
                //console.log(mess.error);
                if (mess.error) {
                    generate(mess.error, 'error');
                }
                else if (mess.success) {

                    generate(mess.success, 'success');

                    $('#registerForm').find('.phone_step').removeClass('phone_step').addClass('phone_step2');

                }
            }
        });
    }


});


// Авторизация через социальные сети
function login(token) {
    $.getJSON("//ulogin.ru/token.php?host=" +
        encodeURIComponent(location.toString()) + "&token=" + token + "&callback=?",
        function (data) {
            data = $.parseJSON(data.toString());
            if (data.error) {
                generate("Не могу получить данные вашей социально сети , попробуйте другой способ авторизации", 'error');
            }
            if (!data.error) {

                $.ajax({
                    type: "post",
                    url: "/user/reg_social",
                    data: data,
                    success: function (date) {
                        var mess = $.parseJSON(date);
                        //console.log(mess.error);
                        if (mess.error) {
                            generate(mess.error, 'error');
                        }
                        else if (mess.success) {

                            generate(mess.success, 'success');
                            setTimeout(function () {
                                location.href = '../';
                            }, 1000);


                        }

                    }
                });


            }
        });
}


// Авторизация Через телефон

$(document).on("click", "#auth_phone", function () {

    var phone = $("#auth-phoneForm [name=login_phone]").val();
    valid_phone = (/^(\+?\d+)?\s*(\(\d+\))?[\s-]*([\d-]*)$/.test(phone) === true &&
    /^\s*$/.test(phone) === false);

    if (!valid_phone) {
        $("#auth-phoneForm [name=login_phone]").css("border-color", "#FC0505");
        generate("Не корректно заполнено поле Телефон", 'error');
    }
    else {
        $("#auth-phoneForm [name=login_phone]").css("border-color", "#1EA827");

        var zap_phone = "code=y&" + $('#token-phone').attr('name') + '=' + $('#token-phone').val() + '&phone=' + $("#auth-phoneForm [name=login_phone]").val();

        $.ajax({
            type: "post",
            url: "/user/auth_phone",
            data: zap_phone,
            success: function (data) {
                var mess = $.parseJSON(data);
                console.log(data);
                if (mess.error) {
                    generate(mess.error, 'error');

                }
                else if (mess.success) {

                    generate(mess.success, 'success');
                    $('#auth-phoneForm').find('.phone_step').removeClass('phone_step').addClass('phone_step2');


                }
            }

        });

    }
});


// Авторизация Через email


$(document).on("click", "#auth_mail", function () {

    var email = $("#auth-mailForm [name=login_mail]").val();
    valid_email = (/^\S+@\S+$/.test(email) === true);
    if (!valid_email) {
        $("#auth-mailForm [name=login_mail]").css("border-color", "#FC0505");
        generate("Не корректно заполнено поле Email", 'error');
    }
    else {
        $("#auth-mailForm [name=login_mail]").css("border-color", "#1EA827");
        var zap_mail = $('#token-mail').attr('name') + '=' + $('#token-mail').val() + '&email=' + $("#auth-mailForm [name=login_mail]").val();

        $.ajax({
            type: "post",
            url: "/user/auth_mail",
            data: zap_mail,
            success: function (data) {

                var mess = $.parseJSON(data);
                console.log(data);
                if (mess.error) {
                    generate(mess.error, 'error');

                }
                else if (data = 1) {


                    $("#auth-mailForm").submit();

                }

            }

        });

    }
});

////////////////// Сообщения пользователя
$(document).ready(function () {

    /// Вывод
    if (location.pathname == '/message') {
        // Начальная загрузка страницы

        var dialog_id = $('.mini').last().attr('data-dialog');
        localStorage.setItem('selected_dialog', dialog_id);
        if (dialog_id) {

            $.ajax({
                type: 'post',
                url: '../message/dialog',
                data: 'dialog=' + dialog_id,
                success: function (data) {
                    $('.right').replaceWith(data);
                    $('.offer').last().addClass('active')
                    $('.full-description').show();
                    $('.send_massage.call_me').hide();
                }


            });
        }

        // Загрузка выбранного диалога
        $(document).on('click', '.mini', function () {
            var dialog_id = $(this).attr('data-dialog');
            localStorage.setItem('selected_dialog', dialog_id);

            $.ajax({
                type: 'post',
                url: '../message/dialog',
                data: 'dialog=' + dialog_id,
                success: function (data) {
                    $('.right').replaceWith(data);
                    $('.full-description').show();
                    $('.send_massage.call_me').hide();
                }
            });
        });

        // Отправка сообщения
        $(document).on('click', '#send_answer', function () {
            var text = $('#text_answer').val();
            var dialog_id = localStorage.getItem('selected_dialog');

            $.ajax({
                type: 'post',
                url: '../message/add',
                data: 'dialog=' + dialog_id + '&text_answer=' + text,
                success: function (data) {
                    if (data == '1') {
                        $.ajax({
                            type: 'post',
                            url: '../message/dialog',
                            data: 'dialog=' + dialog_id,
                            success: function (data) {
                                $('.right').replaceWith(data);
                                $('.full-description').show();
                            }
                        });
                        generate('Сообщение отправлено!', 'success');
                    } else {
                        generate('Не удалось отправить сообщение!', 'error');
                    }
                }
            });
        });

        $(document).on('click', '.findCricle', function () {
            $(this).toggleClass('active');
        });

        $(document).on('click', '#circle', function () {
            $('.findCricle').each(function (ind, elem) {
                $(elem).toggleClass('active');
            });

        });

        $(document).on('click', '.send_massage.full-description.call_me .b_call_me', function () {

            var user_id = $('.offer.active').attr('data-user');
            if (user_id) {
                $.ajax({
                    type: 'post',
                    url: '../message/adddialog',
                    data: {user_id: user_id, dn: 'y'},
                    success: function (data) {
                        if (data == 1) {
                            generate('Контакты отправлены', 'success');
                            $.ajax({
                                type: 'post',
                                url: '../message',
                                data: 'd= y',
                                success: function (data) {
                                    $('.left').replaceWith(data);


                                    var dialog_id = $('.offer').last().attr('data-dialog');
                                    if (dialog_id) {

                                        $.ajax({
                                            type: 'post',
                                            url: '../message/dialog',
                                            data: 'dialog=' + dialog_id,
                                            success: function (data) {
                                                $('.right').replaceWith(data);
                                                $('.full-description').show();
                                                $('.send_massage.call_me').hide();
                                            }
                                        });

                                    }

                                }
                            });


                        }
                        else {
                            generate('Нельзя отправить сообщение самому себе', 'error');
                        }
                    }

                });
                $('.send_me, .aftersend_massage').hide('slow');
            }

        });


        $(document).on('click', '.b_dell', function () {
            var d_id = $('.offer.active').attr('data-dialog');
            $.ajax({
                type: 'post',
                url: '../message/delete',
                data: {d_id: d_id},
                success: function (data) {
                    if (data == 1) {
                        generate("Диалог удален", "alert");
                    }

                    $.ajax({
                        type: 'post',
                        url: '../message',
                        data: 'd= y',
                        success: function (data) {
                            $('.left').replaceWith(data);


                            var dialog_id = $('.offer').eq(0).attr('data-dialog');
                            if (dialog_id) {


                                $.ajax({
                                    type: 'post',
                                    url: '../message/dialog',
                                    data: 'dialog=' + dialog_id,
                                    success: function (data) {
                                        $('.right').replaceWith(data);
                                        $('.full-description').show();
                                        $('.send_massage.call_me').hide();
                                    }
                                });

                            }

                        }
                    });


                }
            });

        });


    }
});

// Конец вывод


//////////////////////////////////////////////////////////////////// Чат

function chat_user(dann) {

    $.ajax({
        type: 'post',
        url: '../chat/chat_user',
        dataType: 'json',
        data: dann,
        success: function (json) {

            if (json.user_id && json.user_name) {
                $('.right-side-head .name').html(json.user_name);
                $('.right-side-head .name').attr('data-user', json.user_id);
            }


        }


    });


}

$(document).ready(function () {


    if (location.pathname == '/chat') {
        var dann = {};
        dann.chat_id = $('.chat_list').first().attr('data-chat');

        if (dann.chat_id) {
            $.ajax({
                type: 'post',
                url: '../chat/chat',
                data: dann,
                success: function (data) {

                    $('.chat_list').first().addClass('active');
                    $('.right').replaceWith(data);

                    chat_user(dann);
                    pagin.chatmicro();
                }

            });
        }
        $(document).on('click', '.chat_list', function () {
            var dann = {};
            dann.chat_id = $(this).attr('data-chat');


            if (dann.chat_id) {
                $.ajax({
                    type: 'post',
                    url: '../chat/chat',
                    data: dann,
                    success: function (data) {


                        $('.right').replaceWith(data);
                        chat_user(dann);
                        pagin.chatmicro();
                    }

                });
            }


        });


/////////////////////////////////// Добавления нового чата

        $(document).on('click', '.chat_add_button', function () {

            $.ajax({
                type: 'post',
                url: '../chat/addchat',
                success: function (data) {

                    $('.right').replaceWith(data);


                }

            });


        });
        $(document).on('click', '.form_chat_add [name=chat_title]', function () {

            $(this).empty();

        });

        $(document).on('click', '.form_chat_add #chat_question', function () {


            var type_chat_mess = 0;


            var form = {'text': $('[name=text]').val()};

            $.ajax({
                type: 'post',
                url: '../chat/addchatconfirm',
                dataType: 'json',
                data: {type_chat_mess: type_chat_mess, form: form},
                success: function (json) {

                    if (json.message) {

                        generate(json.message, 'success');

                        $.ajax({
                            type: 'post',
                            url: '../chat',
                            data: {chat_list: 'y'},
                            success: function (data) {

                                $('.left').replaceWith(data);


                                $.ajax({
                                    type: 'post',
                                    url: '../chat/chat',
                                    data: {chat_id: json.chat_id},
                                    success: function (data) {

                                        $('.right').replaceWith(data);

                                        pagin.chat();

                                    }


                                });


                            }


                        });

                    }
                    if (json.error) {

                        generate(json.error, 'error');
                    }

                }


            });

        });


        ////////////////////////// Добавления сообщения в микродиалог или создание микродиалога

        $(document).on('click', '.add_mess_chat #chat_question , .add_mess_chat #chat_mess', function () {

            var dann = {};
            if ($(this).attr('id') == 'chat_question') {
                dann.type_mess = 0;
            }
            else {
                dann.type_mess = 1;
            }


            if ($('.mess_chat.active').attr('micro-chat-id')) {


                dann.micro_id = $('.mess_chat.active').attr('micro-chat-id');


            }
            else if ($('.mess_chat_micro.active').attr('micro-chat-mess-id')) {

                dann.micro_id = $('.mess_chat_micro.active').attr('micro-chat-mess-id');
            }

            if ($('.add_mess_chat [name=chat_id]').val()) {
                dann.chat_id = $('.add_mess_chat [name=chat_id]').val();

            }
            if (dann.text = $('.add_mess_chat [name=text]').val()) {


                $.ajax({
                    type: 'post',
                    url: '../chat/addmess',
                    data: dann,
                    dataType: 'json',
                    success: function (json) {


                        if (json.success) {

                            generate(json.success, 'success');
                            $.ajax({
                                type: 'post',
                                url: '../chat/chat',
                                data: {chat_id: dann.chat_id},
                                success: function (data) {

                                    $('.right').replaceWith(data);
                                    pagin.chatmicro();
                                }


                            });


                        }

                    }

                });

            }

        });


        //////////////////////// Удаление чата

        $(document).on('click', '.chat_del', function () {
            var chat_id, micro_id, micro_mess_id;
            var dann = {};

            ////////////////////// Удаление сообщений в микродиалоге

            if (micro_mess_id = $('.mess_chat_micro.active').attr('data-mess-id')) {

                dann.micro_mess_id = micro_mess_id;
            }
            else {
                ////////////////////// Удаление микродиалогов
                if (micro_id = $('.mess_chat.active').attr('micro-chat-id')) {

                    dann.micro_id = micro_id;

                }
                else {

                    ////////////////////// Удаление чатов
                    if (chat_id = $('.chat_list.active').attr('data-chat')) {

                        dann.chat_id = chat_id;

                    }

                }
            }
            if (dann.micro_mess_id || dann.micro_id || dann.chat_id) {
                $.ajax({
                    type: 'post',
                    url: '../chat/delchat',
                    data: dann,
                    dataType: 'json',
                    success: function (json) {


                        if (json.success) {

                            $.ajax({
                                type: 'post',
                                url: '../chat',
                                data: {chat_list: 'y'},
                                success: function (data) {

                                    $('.left').replaceWith(data);
                                    if (json.chat_id) {
                                        chat_id = json.chat_id
                                        $('.chat_list').each(function (ind, el) {

                                            if ($(el).attr('data-chat') == chat_id) {

                                                $(el).addClass('active');
                                            }

                                        });
                                    } else {
                                        chat_id = $('.chat_list').first().attr('data-chat');
                                        $('.chat_list').first().addClass('active');
                                    }

                                    $.ajax({
                                        type: 'post',
                                        url: '../chat/chat',
                                        data: {chat_id: chat_id},
                                        success: function (data) {

                                            $('.right').replaceWith(data);
                                            pagin.chat();
                                            pagin.chatmicro();
                                        }


                                    });

                                }

                            });

                        }
                        if (json.error) {
                            generate(json.error, 'error');
                        }

                    }


                });
            }


        });


        ////////////////////////////////////// Выделение Сообщения чата

        $(document).on('click', '.mess_chat , .mess_chat_micro', function () {

            $('.mess_chat , .mess_chat_micro').removeClass('active');
            $(this).addClass('active');

            var dann = {};


            if ($(this).attr('micro-chat-id') && $(this).find('.fa').attr('mess-type') == 2) {
                dann.micro_id = $(this).attr('micro-chat-id');
                $('.chat_right .chat_add_mess #chat_question').show();
            }
            else if ($(this).attr('data-mess-id')) {

                dann.micro_mess_id = $(this).attr('data-mess-id');
                $('.chat_right .chat_add_mess #chat_question').hide();

                var ts = this;
                $('.mess_chat').each(function (ind, el) {

                    if ($(ts).attr('micro-chat-mess-id') == $(el).attr('micro-chat-id') &&
                        $(el).find('.fa').attr('mess-type') == 2) {

                        $('.chat_right .chat_add_mess #chat_question').show();
                    }


                });


            }
            else{
                dann.micro_id = $(this).attr('micro-chat-id');
                $('.chat_right .chat_add_mess #chat_question').hide();

            }

            if (dann.micro_id || dann.micro_mess_id) {
                $.ajax({
                    type: 'post',
                    url: '../chat/chat_user',
                    data: dann,
                    dataType: 'json',
                    success: function (json) {

                        if (json.user_id && json.user_name) {
                            $('.right-side-head .name').html(json.user_name);
                            $('.right-side-head .name').attr('data-user', json.user_id);
                        }
                    }

                });

            }

        });


    }


});