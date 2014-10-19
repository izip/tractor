<span class="order-page">


<span class="left">
    {{ content() }}
<div id="left-side-head" class="head">
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
                        <li class="offers">

                        </li>
                        <li class="price click">
                            <i class="fa fa-rub "></i>
                            <input type="number" id="left_prise" name="left_prise" value="1200">
                        </li>
                        <li class="ribbon go_right fixed_on_time">
                            <i class="fa fa-star "></i>
                        </li>
                        <li class="show-all go_right fixed_on_time">
                            <i class="fa fa-clock-o "></i>
                        </li>
                    </ul>
                </div><!-- Left Side HEAD END  -->
                <div class="fix_holder"></div>

                {% if prop is iterable %}
                {% for key , val in prop%}
                <a data-order="{%if key is defined%}{{key}}{%endif%}" class="offer mini" href="#">
                    <ul>
                        <li class="track ellipsis">  {%if val['cat'] is defined%} {{val['cat']}} {%endif%}</li>
                        <li class="price ellipsis">
                            <i class="fa fa-rub active"></i>
                            <span>{%if val[5] is defined%} {{val[5]}} {%endif%}</span>
                        </li>
                        <li class="location ellipsis">
                            <i class="fa fa-map-marker active"></i>
                            {%if val[4] is defined%} {{val[4]}} {%endif%}</li>
                        <li class="info_marker">
                            <i class="fa fa-star "></i>
                        </li>
                        <li class="info_marker">
                            <i class="fa fa-clock-o  active"></i>
                        </li>
                    </ul>
                </a>
                {%endfor%}
                {%endif%}
            </div>

</span>


<span class="right"></span>

    </span>