$(document).ready(function () {


    /// Фильтрация на фронтенд
    $(document).on('keyup', '#left_city', function () {
        var str = $(this).val().toLowerCase();
        var sf = str.length;
        //  console.log(str);
        $('.location').each(function (ind, el) {


            var text = $(el).text().toLowerCase();

            if (~text.indexOf(str)) {
                $(el).parents('a').show();


            }
            else {
                if (sf != 0) {
                    $(el).parents('a').hide();
                }
                else {
                    $(el).parents('a').show();
                }
            }

        });


    });

    $(document).on('keyup', '#left_cat', function () {
        var str = $(this).val().toLowerCase();
        var sf = str.length;
        $('.track ').each(function (ind, el) {


            var text = $(el).text().toLowerCase();

            if (~text.indexOf(str, -1)) {
                $(el).parents('a').show();


            }
            else {
                if (sf != 0) {

                    $(el).parents('a').hide();
                }
                else {
                    $(el).parents('a').show();

                }


            }

        });

    });

    $(document).on('keyup change', '#left_prise', function () {
        var cen = Number($(this).val());

        $('.price').each(function (ind, el) {


            var pr = Number($(el).text().replace(" руб.", ""));
            console.log(pr);
            if ($.isNumeric(pr) && pr <= cen) {
                $(el).parents('a').show();


            }
            else {

                if (cen != 0) {

                    $(el).parents('a').hide();
                }
                else {
                    $(el).parents('a').show();

                }

            }

        });

    });


    $(document).on('click', '#page #left-side-head-two.head li', function () {
        $(this).toggleClass('active');
        if ($(this).hasClass('active')) {

            var cl = $(this).children('i').attr('class');
            //  console.log(cl.replace('fa ','.'));
            cl = cl.replace('fa ', '.');
            $(cl).each(function (ind, el) {
                if (!$(el).hasClass('active')) {
                    // console.log($(el).attr('class'));
                    $(el).parents('a').hide();
                }

            });

        }
        else {

            var cl = $(this).children('i').attr('class');
            // console.log(cl.replace('fa ','.'));
            cl = cl.replace('fa ', '.');
            $(cl).each(function (ind, el) {
                if (!$(el).hasClass('active')) {
                    //    console.log($(el).attr('class'));
                    $(el).parents('a').show();
                }

            });


        }
    });


    /// Боковой фильтр предложений | Только для раздела предложения


    $(document).on('click', '.filter-left .base  .buttons', function () {
        $(this).toggleClass('active');
    });
    $('#b_filter').on('click', function () {

        if (auth()) {

            if (location.pathname == '/') {

                $.ajax({
                    type: 'post',
                    url: '../filter/index',
                    async: false,
                    data: {},
                    success: function (data) {

                        $('.filter-left').replaceWith(data);

                    }
                });

                $(this).toggleClass('activeted');
                $('.filter-left').show().css('z-index', '9999999');
                $('.contact-left').css('z-index', '0');
                $(this).parent().find('.fa').toggleClass('green');
                if ($(this).hasClass('activeted')) {
                    toggle_side_in();
                }
                else {
                    toggle_side_out();
                }

                autocomplete("[name=city]");
            }
            else {
                generate('Перейдите в раздел предложения!', 'alert');

            }
        }
        else {

            generate('Доступ запрешен!', 'error');
            setTimeout(function () {
                window.location = "/user/auth";

            }, 1000);


        }
    });


    $(document).on('click', '.cat_name_now', function () {
        $('#cat_menu').addClass('right').toggle();

        $(document).on('click', '#cat_menu li a', function () {
            var cat_id = $(this).attr('data-cat');
            $('.cat_name_now').attr('data-cat' , cat_id);
            $.ajax({
                type: 'post',
                url: '../filter/filter',
                data: {cat_id: cat_id},
                success: function (data) {
                    if (data != 1) {
                        $('.cat_p').replaceWith(data);
                        cat_id = $('.type_name_now').attr('data-cat');
                        if(cat_id){
                        $.ajax({
                            type: "post",
                            url: "../filter/setplace",
                            data: {cat_id: cat_id,sub:1},
                            success: function (data) {

                                $('.set-place').replaceWith(data);
                                autocomplete("[name=city]");

                            }

                        });
                        }

                    }
                    else {
                        $('.cat_p').empty();

                        $.ajax({
                            type: "post",
                            url: "../filter/setplace",
                            data: {cat_id: cat_id},
                            success: function (data) {

                                $('.set-place').replaceWith(data);
                                autocomplete("[name=city]");

                            }

                        });


                    }
                }
            });

        });


    });
    $(document).on('click', '.type_name_now', function () {
        $(this).parent().find('.filter_drop').slideToggle();
        $(document).on('click', '.drop_item', function () {
       var cat_id = $(this).attr('data-cat');
            $('.type_name_now').attr('data-cat' , cat_id);
        if(cat_id){
        $.ajax({
            type: "post",
            url: "../filter/setplace",
            data: {cat_id: cat_id,sub:1},
            success: function (data) {

                $('.set-place').replaceWith(data);
                autocomplete("[name=city]");

            }

        });
        }
        });
    });
    $(document).on('click', '.drop_item', function () {
        $(this).parent().slideToggle();
        $(this).parent().parent().find('.type_name_now').html($(this).html());
    });


// Обработчик формы Бокового Фильтра
    $(document).on('click', '.refresh', function () {
        if(!$(this).hasClass('closer_buttom')){
        var dann = {};
        var cat = $('.cat_name_now').attr('data-cat');
        var sub_cat = $('.type_name_now').attr('data-cat');
        var cat_id = '';
        if (sub_cat) {
            dann.cat_id = sub_cat;

        }
        else {
            dann.cat_id = cat;

        }
        $('.filter-left input').each(function(ind ,el){
            if($(el).attr('name') !== undefined){
            dann[$(el).attr('name')] = $(el).val();
            }
        });
        dann[$('.filter-left select').attr('name')] = $('.filter-left select').val();
        $('.filter-left .fa').each(function(ind ,el){
            if($(el).parent().hasClass('active')){
            dann[$(el).attr('data-fil')] = $(el).attr('data-fil');
            }

        });

        $.ajax({
            type:"post",
            url:'../filter/filterform',
            data:dann,
            success:function(data){

               if(data ==1){

                   generate("Фильтер применен" , 'success');
                   toggle_side_out();
                   setTimeout(function () {
                       window.location = "/";

                   }, 1000);
               }

            }



        });
        }
    });


});