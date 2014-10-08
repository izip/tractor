
{{ content() }}
<span class="left">

<div  id="left-side-head" class="head">
    <ul>
        <li class="search-all">
            <input type="text" id="left_cat" name="left_cat" value="Погрузчик"/>

        </li>
        <li class="search-city">
            <input type="text" id="left_city" name="left_city" value="Москва"/>
        </li>
        <li class="add-item">

                <button>
                    <i class="fa  fa-plus"></i>
                </button>

        </li>
    </ul>
</div><!-- Left Side HEAD END  -->

<div data-page-total="{{page_total}}" data-page-num="{{page_num}}" class="left-side">
<div id="left-side-head-two" class="head">

    <ul>
        <li class="offers active">

        </li>

        <li class="price click">
            <i class="fa fa-rub "></i>
            <input type="number" id="left_prise" name="left_prise" value="1200">
        </li>
        <li class="phone">
            <i class="fa fa-mobile-phone "></i>
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

    {%if off is iterable%}
    {%for key , val in off%}
    <a data-offer="{{key}}" href="#" class="offer">
        <ul>
            <li class="track ellipsis"> {%if val['name'][4] is defined %}{{val['name'][4]}}{%endif%} </li>
            <li class="price ellipsis">
                {%if val[5] is defined %}
                <i class="fa fa-rub active"></i>
                <span >{{val[5]}} руб.</span>
                {%else%}
                <i class="fa fa-rub active"></i>
                <span ></span>
                {%endif%}
            </li>
            <li class="location ellipsis">
                <i class="fa fa-map-marker"></i>
						<span >
						{%if val[4] is defined %}{{val[4]}}{%endif%}
						</span>
            </li>
        </ul>
        <ul>
            <li class="model "><span class="">{{val['name'][0]}}</span></li>
            {% if val[14] is defined  and val[14] == 'y'%}
            <li class="info_marker">
                <i class="fa fa-user active"></i>
            </li>
            {%else%}
            <li class="info_marker">
                <i class="fa fa-user "></i>
            </li>
            {%endif%}
            {% if val[7] is defined and val[7] == 'y'%}
            <li class="info_marker ">
                <i class="fa fa-tint active"></i>
            </li>
            {%else%}
            <li class="info_marker">
                <i class="fa fa-tint "></i>
            </li>

            {%endif%}

            {% if val[6] is defined and val[6] == 'y' %}
            <li class="info_marker">
                <i class="fa fa-truck active"></i>
            </li>
            {%else%}
            <li class="info_marker">
                <i class="fa fa-truck "></i>
            </li>
            {%endif%}
            {% if val['name'][3] is defined and val['name'][3]> 0 %}
            <li class="info_marker phone">
                <i class="fa fa-mobile-phone active"></i>
            </li>
            {%else%}
            <li class="info_marker phone">
                <i class="fa fa-mobile-phone "></i>
            </li>
            {%endif%}
            {% if val['name'][1] is defined and val['name'][1]== 1%}
            <li class="info_marker">
                <i class="fa fa-camera active"></i>
            </li>
            {%else%}

            <li class="info_marker">
                <i class="fa fa-camera "></i>
            </li>
            {%endif%}
            <li class="info_marker">
                <i class="fa fa-trophy "></i>
            </li>

            {% if val['name'][2] is defined and val['name'][2] == 1%}
            <li class="info_marker">
                <i class="fa fa-circle-o active"></i>
            </li>
            {%else%}
            <li class="info_marker">
                <i class="fa fa-circle-o "></i>
            </li>
            {%endif%}
        </ul>
    </a><!-- This Offer END -->
    {%endfor%}
    {%endif%}
</div><!-- Left Side END-->
</span>



<span class="right">
</span> <!-- Right Side END -->

