<span class="right">
{{ content() }}
<div id="right-side" class="right-side">
    <div class=" send_massage aftersend_massage full-description ">
        <h6>
            <i class="fa fa-exclamation-circle"></i>
            Осталось 30 дней до обновления статуса
        </h6>
        <button class="closer ">
            <i class="fa fa-times"></i>
        </button>
    </div>
    <div class="send_massage afterpost_massage send_me">
        <div class="full-description">
            <div class="floated">
                <button class="myoff_but first_pad b_post_order">
                    сохранить
                </button>
                <button class="myoff_but  b_publick_order">
                    опубликовать
                </button>
            </div>
        </div>
    </div>

    <div class="offer_edit">
        <div class="content">
            <div class="description">
                {{ form('myorders/addorderform', 'class' :'addorder' ) }}
                <div>
                    <input type="hidden" name="{{security.getTokenKey()}}" value="{{security.getToken()}}">
                    <input type="hidden" name="order_id" value="{{order_id}}">
                    {% if cat is iterable %}
                    <p class="styled_big fw_box">
								<span class="edit_desc">
									Класс:
								</span>
                        <select name="cat_id"   class="editors">
                            {%for key , val in cat%}
                            {% if par_cat == key%}
                            <option selected value="{{ key }}">{{ val }}</option>
                            {%else%}
                            <option  value="{{ key }}">{{ val }}</option>
                            {% endif %}
                            {% endfor %}
                        </select>
                    </p>
                    {% endif %}
                <span class="subcat">
                {% if sub_cat is iterable %}
                 <p class="styled_big fw_box">
								<span class="edit_desc">
									Тип техники:
								</span>
                     <select name="sub_cat_id"   class="editors">
                         {%for key , val in sub_cat%}
                         {% if cat_id == key%}
                         <option selected value="{{ key }}">{{ val }}</option>
                         {%else%}
                         <option  value="{{ key }}">{{ val }}</option>
                         {% endif %}
                         {% endfor %}
                     </select>
                 </p>
                {% endif %}
                </span>
                    <label class="styled_big fw_box">
								<span class="edit_desc">
									Вид техники
								</span>

                        {%if dann[22] is defined%}
                        {{text_field('name-tex' ,'value':dann[22] , 'class':'editors','placeholder': 'Например: 25 тонн')}}
                        {%else%}
                        {{text_field('name-tex' , 'class':'editors','placeholder': 'Например: 25 тонн')}}
                        {%endif%}

                    </label>
                    <label class="styled_big fw_box">
								<span class="edit_desc">
									Город
								</span>
                        {%if dann[4] is defined%}
                        {{text_field('city-tex' , 'value':dann[4] , 'class':'editors','placeholder': 'Например: Саратов')}}
                        {%else%}
                        {{text_field('city-tex' , 'class':'editors','placeholder': 'Например: Саратов')}}
                        {%endif%}


                    </label>

                    <div class="styled_big  no_bg">
								<span class="edit_desc">
									Цена
								</span>
								<span class="edit_desc fix pull-right">

									<select name="price-usd" class="editors selector">
                                        {%if price_hour is defined and price_hour == 1%}
                                        <option selected value="1">
                                            $/hour
                                        </option>
                                        {%else%}
                                        <option  value="1">
                                            $/hour
                                        </option>
                                        {%endif%}

                                        {%if price_hour is defined and price_hour == 2%}
                                        <option selected value="2">
                                            руб/час
                                        </option>
                                        {%else%}
                                        <option  value="2">
                                            руб/час
                                        </option>
                                        {%endif%}
                                    </select>
								</span>
								<span class="edit_desc fix pull-right">

                                    {%if dann[5] is defined%}
                       {{text_field('price-tex' ,'value':dann[5] , 'class':'editors','placeholder': '1500')}}
                        {%else%}
                     {{text_field('price-tex' , 'class':'editors','placeholder': '1500')}}
                        {%endif%}


								</span>
                    </div>
                    <div class="styled_big  no_bg">
								<span class="edit_desc">
									Сроки
								</span>
								<span class="edit_desc fix pull-right">
                                  {%if date_from is defined%}
                     {{text_field('date-from-tex' ,  'value':date_from ,'class':'editors','placeholder': '30.03.2013')}}
                        {%else%}
                 {{text_field('date-from-tex' , 'class':'editors','placeholder': '30.03.2013')}}
                        {%endif%}


								</span>
								<span class="edit_desc fix pull-right">

                        {%if date_to is defined%}
                         {{text_field('date-to-tex' , 'value': date_to , 'class':'editors','placeholder': '12.03.2013')}}
                        {%else%}
                 {{text_field('date-to-tex' , 'class':'editors','placeholder': '12.03.2013')}}
                        {%endif%}


								</span>
                    </div>
                    <label class="fw_box fw_box no_bg">
								<span class="edit_desc">
									Дополнительно
								</span>
								<span class="edit_desc fw_box">
                                     {%if text is defined%}
									<textarea name="text-tex" class="editors fw_box">{{text}}</textarea>
                                     {%else%}
                                    <textarea name="text-tex" class="editors fw_box"></textarea>
                                    {%endif%}
								</span>
                    </label>

                    <p class=" normal_size  no_bg">

                    <div class="pull-right">
                        <i class="fa fa-th  active"></i>
                    </div>
                    </p>
                </div>
                <input type="submit" hidden>
                </form>
            </div>
        </div>
    </div>

</div>
    </span>