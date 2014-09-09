<span class="order-page">
{{ content() }}

<span class="left">
<div id="left-side-head" class="head">
    <ul>
        <li class="search-all">
            <input type="text" id="left_cat" name="left_cat" value="" class="error" />
        </li>

        <li class="add-item">

                <button>
                    <i class="fa  fa-plus"></i>
                </button>

        </li>
    </ul>
</div><!-- Left Side HEAD END  -->

			<div class="left-side">
                <div class="head" id="left-side-head-two">

                    <ul>
                        <li class="offers no_top_pad">
                            Мои заявки  <a>{% if cl is defined %} {{cl}} {%endif%}</a>
                        </li>
                        <li class="ribbon go_right fixed_on_time">
                            <i class="fa fa-star "></i>
                        </li>
                        <li class="show-all show-all2 go_right fixed_on_time text-left">
                            <i class="fa fa-clock-o "></i>
                        </li>
                        <li class="price price2 click pull-right">
                            <i class="fa fa-rub "></i>
                            <input type="number" value="1200" name="left_prise" id="left_prise">
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

<div class="right-side-head">
    <div class="top_title">
						<span class="name">
							<button class="myoff_but b_off_change ">
                                <i class="fa fa-pencil "></i>
                                Изменить
                            </button>
							<button class="myoff_but b_off_kill none_active">
                                <i class="fa fa-trash-o"></i>
                                Удалить
                            </button>
						</span>
						<span class="item_title_two">
							<button class="myoff_but b_off_save active b_put_order">
                                <i class="fa fa-floppy-o "></i>
                                Сохранить
                            </button>
							<button class="myoff_but b_off_save active hidden b_publick_order">
                                <i class="fa fa-bullhorn"></i>
                                Опубликовать
                            </button>
							<button class="myoff_but b_off_save active hidden b_renew_order">
                                <i class="fa fa-refresh "></i>
                                Обновить
                            </button>
						</span>
    </div>
</div><!-- RightSide HEAD END  -->
<span class="right"></span>

    </span>