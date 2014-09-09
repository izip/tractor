{{content()}}
<li class="cat_p">
    {% if cat_name is iterable %}

<p  class="type_name_now" data-cat="{{cat_name[0][0]}}">
    {{ cat_name[0][1] }}
</p>
<i class="fa fa-align-justify "></i>
<ul class="filter_drop">
    {% for key , val in cat_name %}
    {% if loop.first != true%}
    <li class="drop_item" data-cat="{{val[0]}}">
       {{val[1]}}
    </li>
    {% endif %}
    {% endfor %}
</ul>

    {% endif %}
</li>