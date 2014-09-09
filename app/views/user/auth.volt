
{{ content() }}

<span class="left">
<div id="left-side-head" class="head">
    <ul>
        <li class="search-all">
            <input type="text" id="left_cat" name="left_cat" value="Погрузчик"/>

        </li>
        <li class="search-city">
            <input type="text" id="left_city" name="left_city" value="Москва"/>
        </li>
        <li class="add-item">
            <a href="/myoffers/index">
                <button>
                    <i class="fa  fa-plus"></i>
                </button>
            </a>
        </li>
    </ul>
</div><!-- Left Side HEAD END  -->

<div class="left-side">
<div id="left-side-head-two" class="head">

    <ul>
        <li class="offers">

        </li>
        <li class="price click">
            <i class="fa fa-rub "></i>
            <input type="number" id="left_prise" name="left_prise" value="1200">
        </li>
        <li class="phone">
            <i class="fa fa-mobile-phone"></i>
        </li>
        <li class="photo">
            <i class="fa fa-camera "></i>
        </li>
        <li class="ribbon">
            <i class="fa fa-trophy "></i>
        </li>
        <li class="show-all">
            <i class="fa fa-circle-o"></i>
        </li>
    </ul>
</div><!-- Left Side HEAD END  -->
<div class="fix_holder"></div>
<a href="#" class="offer">
    <ul>
        <li class="track ellipsis">  Погрузчик телескопический</li>
        <li class="price ellipsis">
            <i class="fa fa-rub active"></i>
            <span>1200</span>
        </li>
        <li class="location ellipsis">
            <i class="fa fa-map-marker active"></i>
            Москва</li>
    </ul>
    <ul>
        <li class="model">JCB99 - Ram</li>
        <li class="info_marker">
            <i class="fa fa-user"></i>
        </li>
        <li class="info_marker">
            <i class="fa fa-tint"></i>
        </li>
        <li class="info_marker">
            <i class="fa fa-truck"></i>
        </li>
        <li class="info_marker phone">
            <i class="fa fa-mobile-phone"></i>
        </li>
        <li class="info_marker">
            <i class="fa fa-camera active"></i>
        </li>
        <li class="info_marker">
            <i class="fa fa-trophy "></i>
        </li>
        <li class="info_marker">
            <i class="fa fa-circle-o green"></i>
        </li>
    </ul>
</a><!-- This Offer END -->
<!-- This Offer END -->


</div><!-- Left Side END-->
</span>

<span class="right">

<div class="right-side-head">
    <div class="login_block">
        <button class="login_btn active left b_enter">
            Вход
        </button>
        <button class="login_btn right b_reg">
            Регистрация
        </button>
    </div>
</div>

<div id="right-side" class="right-side fa_styled">
 <div class="login_block make_bm for_enter">
        <button class="login_btn_type active left b_phone">
            <i class="fa fa-mobile-phone  "></i>
            через телефон
        </button>
        <button class="login_btn_type right b_mail">
            <i class="fa fa-envelope    "></i>
            через почту
        </button>
        <div class="by_phone">
            {{ form('user/auth_phone', 'id': 'auth-phoneForm'  ) }}
            {{ text_field('login_phone', 'class': 'fild' ,'placeholder':'+7 926 455 6114') }}

            <button id="auth_phone" type="button" class="login_btn_enter go_step2">
                Войти
                <i class="fa fa-arrow-circle-right  "></i>
            </button>
            <p class="step phone_step ">
                и
            </p>
            <input id="token-phone" type="hidden" name="{{tokenKey }}"  value="{{token}}">
            <input type="number" name="login_code" class="fild  phone_step " placeholder="Введите код">
            <button type="submit" class="login_btn_enter noneactive  phone_step">
                Подтвердить
            </button>
        </form>
        </div>



        <div class="by_mail">
            {{ form('user/auth_mail', 'id': 'auth-mailForm'  ) }}
            <input type="email" name="login_mail" class="fild" placeholder="info@gamba.ru">
            <input type="password" name="login_pass" class="fild" placeholder="Введите пароль">
            <input type="submit" hidden="">
            <input id="token-mail" type="hidden" name="{{tokenKey}}"  value="{{token}}">
            <button id="auth_mail" type="button" class="login_btn_enter ">
                Войти
                <i class="fa fa-arrow-circle-right  "></i>
            </button>
            </form>
        </div>


     <p class="step">
         или войти через профиль социальной сети
     </p>


     <script src="//ulogin.ru/js/ulogin.js"></script>
    <div id="uLogin" data-ulogin="display=panel;fields=first_name,email,photo,city,country;
    providers=odnoklassniki,mailru,google;
     redirect_uri=http%3A%2F%2F92.63.99.71%2Fuser%2Fauth;callback=login;">


     </div>


    </div>
    <div class="login_block make_bm for_reg">
        {{ form('user/register', 'id': 'registerForm'  ) }}
        {{ text_field('reg_name', 'class': 'fild' ,'placeholder':'Укажите ваше имя') }}
        {{ text_field('reg_phone', 'class': 'fild' ,'placeholder':'+7 926 455 6114') }}
        {{ text_field('reg_mail', 'class': 'fild' ,'placeholder':'yourname@mail.com') }}
        <input id="token-register" type="hidden" name="{{tokenKey }}"  value="{{token }}">
        <button id="reg_sub" type="button" class="login_btn_enter big_pad go_step2">
            Создать профиль
            <i class="fa fa-arrow-circle-right  "></i>
        </button>
        <input type="number" name="reg_valid" class="fild phone_step " placeholder="Введите код">
        <button  type="submit" class="login_btn_enter noneactive phone_step ">
            Подтвердить
        </button>
        </form>
    </div>
</div><!-- Right Side END -->

    </span>