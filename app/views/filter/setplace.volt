{{content()}}
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
                {% if val[0] is defined %}    {{val[0]}} {%endif %} -
                <b>{% if val[2] is defined %} {{val[2]}} {%endif %}</b>
            </p>
            <i class="fa fa-gears  "></i>
        </li>
        {%if val[1] is defined and val[1] == 'i' %}
        <li>
            <input name="fromfiel-{{key}}" type="number" value="" class="mini">
            <input name="tofiel-{{key}}" type="number" value="" class="mini">

        </li>
        {% elseif val[1] == 's' and key == 4%}
        <li>
            <input name="city" type="text" value="">
            <i class="fa fa-map-marker  "></i>
        </li>
        {% elseif val[1] == 's' and key != 4%}
        <li>
            <input name="fiel-{{key}}" type="text" value="">
            <i class="fa fa-gears "></i>
        </li>
        {% elseif val[1] is iterable%}
        <li>
            <select name="sfiel-{{key}}"   class="editors">
                <option value="">Все</option>
                {%for key , val in val[1]%}
                <option value="{{ val }}">{{ val }}</option>
                {% endfor %}
            </select>
            <i class="fa fa-gears "></i>
        </li>
        {% endif %}

        {% endfor %}
        {% endif %}

    </ul>
    </li>