$(document).ready(function () {

    $(window).resize(function () {
        // console.log( $('#menu').width());
        if ($('#menu').width() == 60) {


            $('.left-side').css('right', '180px');
        }
        else if ($('#menu').width() == 240) {


            $('.left-side').css('right', '0');

        }

    });

$(document).on('click','#date-to-tex ,#date-from-tex',function(){

    $('#date-to-tex').datepicker();

    $('#date-from-tex').datepicker();
});



});

var toggle_side_in = function () {
    $('.right-side-head, #right-side ').addClass('right250');
    var men = $('#menu').width();
    $('#menu').addClass('wise_menu');
    $('#page,#left-side-head,#cat_menu,#left-side-head-two').addClass('left90');
    $('.right-side-head, #right-side').addClass('left580');
    $('.filter-left,.contact-left').removeClass('activeted');

    if ($('#menu').width() == '60' && men != 60) {

        $('.left-side').css('right', '180px');
    }
};
var toggle_side_out = function () {
    $('.right-side-head, #right-side ').removeClass('right250');
    $('#menu').removeClass('wise_menu');
    $('#page,#left-side-head,#cat_menu,#left-side-head-two').removeClass('left90');
    $('.right-side-head, #right-side').removeClass('left580');
    $('#b_filter').parent().find('.fa').removeClass('green');
    $('.filter-left,.contact-left').removeClass('activeted');
    $('.contact-left , .filter-left').hide().css('z-index', '0');
    if ($('#menu').width() == '240') {

        $('.left-side').css('right', '0');
    }
};

function selects() {


    var $selects = $('select');

    $selects.easyDropDown({
        cutOff: 10,
        wrapperClass: 'dropdown editors selector',
        onChange: function (selected) {

        }
    });
}

$(document).ready(function () {

    $(window).resize(function () {
        $('.left-side').css('right', '0');
    });
    var $menu = $('#menu');

    $('#open-icon-menu a, a#open-icon-header').on('click', function (e) {
        e.stopImmediatePropagation();
        e.preventDefault();
        $menu.trigger($menu.hasClass('mm-opened') ? 'close.mm' : 'open.mm');
    });

    $menu.mmenu({
        onClick: {
            preventDefault: true,
            setSelected: false

        }
    });


    $('.filter-left,#cat_menu').hide();
    $('#left-side-head').scrollToFixed();
    $(document).on('click', '#menu .logo', function () {
        $('#cat_menu').toggle();
    });

    $('.closer').on('click', function () {
        $(this).parent().slideUp('slow');
    });


    $('.cat_name').on('mouseenter', function () {

        $('#cat_menu').show();
        $(this).addClass('actived');

    });
    $('#menu ').on('mouseenter',function(){

        $('.cat_menu').hide();
    });
    $('#cat_menu , #sub_cat_menu').mouseleave(function () {

        if ($(this).attr('id') == 'sub_cat_menu') {
            $('#sub_cat_menu').hide();


        }
        else if ($(this).attr('id') == 'cat_menu') {
            if ($('.cat_name').hasClass('actived') &&
                $('#sub_cat_menu').css('display') == 'none'

            ) {
                $('.cat_menu').hide();
                $('.cat_name').removeClass('actived');
            }
        }
        else{

            $('.cat_menu').hide();
            $('.cat_name').removeClass('actived');
        }
    });


    ////////////// Вывод подкатегории
    $('#cat_menu a').on('mouseenter', function () {
        var es = this;


        $('#sub_cat_menu').show();
        var ds = 0;
        $('#sub_cat_menu a').each(function (ind, el) {
            //  console.log($(es).attr('data-cat'));
            if ($(es).attr('data-cat') == $(el).attr('sub-cat')) {

                ++ds;

                $(el).parent('li').show();
            }
            else {
                $(el).parent('li').hide();


            }

        });

        if (ds == 0) {
            $('#sub_cat_menu ').hide();

        }

    });


    $('.cat_name, .cat_name_now').html($('#cat_menu li a').eq(0).html());
    $(document).on('click', '#cat_menu li a , #sub_cat_menu li a', function () {
        $('#cat_menu li , #sub_cat_menu li').removeClass('active');
        $(this).parent().addClass('active');
        var $text_b = $(this).data("cat");
        $('#cat_menu ').toggle();
        $('#sub_cat_menu').hide();
        $('#cat_menu ').removeClass('right');
        $('.cat_name, .cat_name_now').html($(this).html());
    });


    $('.b_phone').on('click', function () {
        $('.login_btn_type').removeClass('active');
        $(this).addClass('active');
        $('.by_phone').show();
        $('.by_mail').hide();
    });
    $('.b_mail').on('click', function () {
        $('.login_btn_type').removeClass('active');
        $(this).addClass('active');
        $('.by_phone').hide();
        $('.by_mail').show();
    });
    $('.b_enter').on('click', function () {
        $('.login_btn').removeClass('active');
        $(this).addClass('active');
        $('.for_enter').show();
        $('.for_reg').hide();
    });
    $(document).on('click', '#page .left-side a.offer', function () {
        $('#page .left-side a.offer').removeClass('active');
        $(this).addClass('active');
    });
    $('.b_reg').on('click', function () {
        $('.login_btn').removeClass('active');
        $(this).addClass('active');
        $('.for_enter').hide();
        $('.for_reg').show();
    });
    $(document).on('click', '.b_comment', function () {
        $('.call_me, .aftersend_massage').hide('slow');
        $('.send_massage.send_me').toggle('slow');
    });

    $(document).on('click', '.b_call_me, .put_call_me', function () {
        $('.send_me, .aftersend_massage').hide('slow');
        $('.send_massage.call_me').toggle('slow');
    });
    $(document).on('click', '.b_put_order, .put_order', function () {
        $('.call_me, .send_me, .aftersend_massage').hide('slow');
        $('.send_massage.afterpost_massage').toggle('slow');
    });
    $('.b_post_order').on('click', function () {
        $('.call_me, .send_me, .afterpost_massage').hide('slow');
        $('.offer_edit').hide();
        $('.offer_preview').show();
        $('.item_title_two .b_put_order').hide();
        $('.item_title_two .b_publick_order').removeClass('hidden');
    });
    $('.b_publick_order').on('click', function () {
        $('.call_me, .send_me, .afterpost_massage').hide();
        $('.item_title_two .b_renew_order').removeClass('hidden');
        $('.offer_edit, .item_title_two .b_put_order, .item_title_two .b_publick_order').hide();
        $('.offer_preview').show();
        $('.send_massage.aftersend_massage').toggle('slow');
    });


    $(document).on('click', '.closer_buttom', function () {
        $(this).parent().parent().hide();
        toggle_side_out();
    });

    $('li.price.click .fa').on('click', function () {
        $('#left_prise').toggle();
    });


    $('.drop_item').on('click', function () {
        $(this).parent().slideToggle();
        $(this).parent().parent().find('.type_name_now').html($(this).html());
    });
    $('#page #left-side-head.head input, #left_prise').on("focus", function () {
        $(this).val("");
    });
    $('#menu li a').on('click', function () {
        var loc = $(this).attr('href');
        window.location.href = loc;
    });


});