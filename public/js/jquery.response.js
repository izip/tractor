// jQuery Mask Plugin v1.5.4

(function (g) {
    var y = function (a, h, f) {
        var k = this, x;
        a = g(a);
        h = "function" === typeof h ? h(a.val(), void 0, a, f) : h;
        k.init = function () {
            f = f || {};
            k.byPassKeys = [9, 16, 17, 18, 36, 37, 38, 39, 40, 91];
            k.translation = {
                0: {pattern: /\d/},
                9: {pattern: /\d/, optional: !0},
                "#": {pattern: /\d/, recursive: !0},
                A: {pattern: /[a-zA-Z0-9]/},
                S: {pattern: /[a-zA-Z]/}
            };
            k.translation = g.extend({}, k.translation, f.translation);
            k = g.extend(!0, {}, k, f);
            a.each(function () {
                !1 !== f.maxlength && a.attr("maxlength", h.length);
                a.attr("autocomplete", "off");
                d.destroyEvents();
                d.events();
                d.val(d.getMasked())
            })
        };
        var d = {
            getCaret: function () {
                var c;
                c = 0;
                var b = a.get(0), d = document.selection, e = b.selectionStart;
                if (d && !~navigator.appVersion.indexOf("MSIE 10"))b.focus(), c = d.createRange(), c.moveStart("character", -b.value.length), c = c.text.length; else if (e || "0" === e)c = e;
                return c
            }, setCaret: function (c) {
                var b;
                b = a.get(0);
                b.setSelectionRange ? (b.focus(), b.setSelectionRange(c, c)) : b.createTextRange && (b = b.createTextRange(), b.collapse(!0), b.moveEnd("character", c), b.moveStart("character", c), b.select())
            },
            events: function () {
                a.on("keydown.mask", function () {
                    x = d.val()
                });
                a.on("keyup.mask", d.behaviour);
                a.on("paste.mask", function () {
                    setTimeout(function () {
                        a.keydown().keyup()
                    }, 100)
                })
            }, destroyEvents: function () {
                a.off("keydown.mask keyup.mask paste.mask")
            }, val: function (c) {
                var b = a.is("input");
                return 0 < arguments.length ? b ? a.val(c) : a.text(c) : b ? a.val() : a.text()
            }, behaviour: function (c) {
                c = c || window.event;
                var b = c.keyCode || c.which;
                if (-1 === g.inArray(b, k.byPassKeys)) {
                    var a, e = d.getCaret();
                    e < d.val().length && (a = !0);
                    var f = d.getMasked();
                    f !== d.val() && d.val(f);
                    !a || 65 === b && c.ctrlKey || d.setCaret(e);
                    return d.callbacks(c)
                }
            }, getMasked: function (a) {
                var b = [], g = d.val(), e = 0, p = h.length, l = 0, s = g.length, m = 1, t = "push", q = -1, n, u;
                f.reverse ? (t = "unshift", m = -1, n = 0, e = p - 1, l = s - 1, u = function () {
                    return -1 < e && -1 < l
                }) : (n = p - 1, u = function () {
                    return e < p && l < s
                });
                for (; u();) {
                    var v = h.charAt(e), w = g.charAt(l), r = k.translation[v];
                    if (r)w.match(r.pattern) ? (b[t](w), r.recursive && (-1 === q ? q = e : e === n && (e = q - m), n === q && (e -= m)), e += m) : r.optional && (e += m, l -= m), l += m; else {
                        if (!a)b[t](v);
                        w === v &&
                        (l += m);
                        e += m
                    }
                }
                a = h.charAt(n);
                p !== s + 1 || k.translation[a] || b.push(a);
                return b.join("")
            }, callbacks: function (c) {
                var b = d.val(), g = d.val() !== x;
                if (!0 === g && "function" === typeof f.onChange)f.onChange(b, c, a, f);
                if (!0 === g && "function" === typeof f.onKeyPress)f.onKeyPress(b, c, a, f);
                if ("function" === typeof f.onComplete && b.length === h.length)f.onComplete(b, c, a, f)
            }
        };
        k.remove = function () {
            d.destroyEvents();
            d.val(k.getCleanVal()).removeAttr("maxlength")
        };
        k.getCleanVal = function () {
            return d.getMasked(!0)
        };
        k.init()
    };
    g.fn.mask = function (a, h) {
        return this.each(function () {
            g(this).data("mask", new y(this, a, h))
        })
    };
    g.fn.unmask = function () {
        return this.each(function () {
            try {
                g(this).data("mask").remove()
            } catch (a) {
            }
        })
    };
    g.fn.cleanVal = function () {
        return g(this).data("mask").getCleanVal()
    };
    g("*[data-mask]").each(function () {
        var a = g(this), h = {};
        "true" === a.attr("data-mask-reverse") && (h.reverse = !0);
        "false" === a.attr("data-mask-maxlength") && (h.maxlength = !1);
        a.mask(a.attr("data-mask"), h)
    })
})(window.jQuery || window.Zepto);


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
                            setTimeout(function(){
                                location.href = '../';
                            },1000);


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
                        generate('Сообщение отправлено!','success');
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
        $(document).on('click','.form_chat_add [name=chat_title]', function(){

            $(this).empty();

        });

        $(document).on('click', '.form_chat_add #chat_question', function () {


            var type_chat_mess =0;



            var form = { 'text': $('[name=text]').val()};

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
                if($('.mess_chat.active i').attr('mess-type') == dann.type_mess){
                    dann.type_mess = $('.mess_chat.active i').attr('mess-type');
                }

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
                                    chat_id = $('.chat_list').first().attr('data-chat');
                                    $.ajax({
                                        type: 'post',
                                        url: '../chat/chat',
                                        data: {chat_id: chat_id},
                                        success: function (data) {

                                            $('.right').replaceWith(data);

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
            if ($(this).attr('micro-chat-id')) {
                dann.micro_id = $(this).attr('micro-chat-id');
                $('.chat_right .chat_add_mess #chat_question').show();
            }
            else if ($(this).attr('data-mess-id')) {

                dann.micro_mess_id = $(this).attr('data-mess-id');
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