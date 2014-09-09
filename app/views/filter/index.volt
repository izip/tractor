{{content()}}
<div class="filter-left ">
    <ul class="base">
        <li class="some_pad">
            <i class="fa fa-filter title_icon"></i>
            <span class="title">Фильтры</span>
        </li>
        <li>
            <p  class="cat_name_now" data-cat="{{cat}}">
                Погрузчики
            </p>
            <i class="fa fa-chevron-right "></i>
        </li>
        <li class="cat_p">

            {% if subcat is iterable %}

            <p  class="type_name_now" data-cat="{{subcat[0][0]}}">
                {{ subcat[0][1] }}
            </p>
            <i class="fa fa-align-justify "></i>
            <ul class="filter_drop">
                {% for key , val in subcat %}
                {% if loop.first != true%}
                <li class="drop_item" data-cat="{{val[0]}}">
                    {{val[1]}}
                </li>
                {% endif %}
                {% endfor %}
            </ul>

            {% endif %}
        </li>
        <li class="set-place">
            <ul>

<li>
    <p  class="" >
       Цена
    </p>
    <input type="number" name="price-from" value="" class="mini">
    <input type="number" name="price-to" value=""  class="mini">
    <i class="fa fa-rub"></i>
</li>
                {% if field is iterable %}
                {% for key , val in field %}
<li>
    <p  class="" >
        {% if val[2] is defined %}    {{val[2]}} {%endif %} -
         <b>{% if val[4] is defined %} {{val[4]}} {%endif %}</b>
    </p>
    <i class="fa fa-gears  "></i>
</li>
                {%if val[3] is defined and val[3] == 'i' %}
<li>
    <input name="fromfiel-{{key}}" type="number" value="" class="mini">
    <input name="tofiel-{{key}}" type="number" value="" class="mini">

</li>
                {% elseif val[3] == 's' and key == 4%}
                <li>
                    <input name="city" type="text" value="">
                    <i class="fa fa-map-marker  "></i>
                </li>
                {% endif %}

                {% endfor %}
                {% endif %}

        </ul>
</li>
        <li class="floated">
            <button class="buttons">
                <i class="fa fa-user"  data-fil="fiel-14" ></i>
            </button>
            <button class="buttons">
                <i class="fa fa-tint" data-fil="fiel-7" ></i>
            </button>
            <button class="buttons">
                <i class="fa fa-truck" data-fil="fiel-6" ></i>
            </button>
            <button class="buttons">
                <i class="fa fa-mobile-phone" data-fil="tel" ></i>
            </button>
            <button class="buttons">
                <i class="fa fa-camera" data-fil="image" ></i>
            </button>
            <button class="buttons">
                <i class="fa fa-trophy" data-fil="trof" ></i>
            </button>
        </li>
        <li class="floated refresh">
            <p  class="" >
                применить фильтр
            </p>
            <i class="fa fa-refresh   "></i>
        </li>
        <li class="floated times closer_buttom">
            <p  class="" >
                закрыть
            </p>
            <i class="fa  fa-times "></i>
        </li>
    </ul>
</div>
