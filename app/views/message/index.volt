
{{ content() }}
<span class="left">
<div id="left-side-head" class="head ">
    <ul>
        <li class="search-all go_left">
            <input type="text" id="left_cat" name="left_cat" value="Александр Пушкин"/>

        </li>
    </ul>
</div><!-- Left Side HEAD END  -->

<div class="left-side">
    <div id="left-side-head-two" class="head ">

        <ul>
            <li class="offers no_top normal_size">
                <i class="fa fa-envelope "></i>
                Мои диалоги
                <a href="#">{{dialogs}}</a>
            </li>
            <li class="price click">
                <i class="fa fa-rub hidden"></i>
                <input type="number" id="left_prise" name="left_prise" value="1200">
            </li>
            <li class="phone">
                <i class="fa fa-mobile-phone hidden"></i>
            </li>
            <li class="photo">
                <i class="fa fa-camera hidden"></i>
            </li>
            <li class="ribbon">
                <i class="fa fa-trophy hidden"></i>
            </li>
            <li class="show-all">
                <i id="circle" class="fa fa-circle-o"></i>
            </li>
        </ul>
    </div><!-- Left Side HEAD END  -->

    <div class="fix_holder"></div>
    {%if dia is iterable%}
    {%for key , val in dia%}
    <a data-user="{{val['dialog_users'][1]}}" data-dialog="{{key}}" href="#" class="offer mini">
        <ul>
            <li class="track normal_size">
                <i class="fa fa-user active"></i>
                {{val['dialog_users'][0]}}
            </li>
            <li  class="righted first">
                <i class="fa fa-circle-o findCricle"></i>
            </li>
            <li  class="righted">
                <i class="fa fa-trophy "></i>
            </li>
            {% if val['dialog_info'][0] is defined and val['dialog_info'][0] == '1' %}
            <li  class="righted">
                <i class="fa fa-envelope "></i>
            </li>
            {%else%}
            <li  class="righted">
                <i class="fa fa-envelope active"></i>
            </li>
            {%endif%}
            <li class="righted">
                <i class="fa fa-mobile-phone "></i>
            </li>
        </ul>
    </a><!-- This Offer END -->
    {%endfor%}
    {%endif%}
</div>


<div class="right-side-head ">
    <div class="top_title">
        <span class="name messg">
            <button class="b_dell first">Удалить</button>
        </span>
        <span class="item_title_two">
            <button class="contacts b_contacts">Контакты</button>

			<button class="put_call_me">
                <i class="fa fa-bolt b_send_request"></i>
            </button>
		</span>
    </div>
</div><!-- RightSide HEAD END  -->


<span class="right"></span>

</span>