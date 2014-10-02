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
                {{ form('myorders/addorderform', 'class' :'addorder'  ) }}
                <div>
                    <input type="hidden" name="{{security.getTokenKey()}}" value="{{security.getToken()}}">


                    {% if cat is iterable %}
                    <p class="styled_big fw_box">
								<span class="edit_desc">
									Класс:
								</span>
                        <select name="cat_id"   class="editors">
                            {%for key , val in cat%}
                            <option value="{{ key }}">{{ val }}</option>
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
                        <option value="{{ key }}">{{ val }}</option>
                        {% endfor %}
                    </select>
                </p>
                {% endif %}
                </span>

                    <label class="styled_big fw_box">
								<span class="edit_desc">
									Модель
								</span>
                        {{text_field('name-tex' , 'class':'editors','placeholder': 'Например: Huyndai XCMG ZL30G')}}

                    </label>
                    <label class="styled_big fw_box">
								<span class="edit_desc">
									Город
								</span>
                        {{text_field('city-tex' , 'class':'editors','placeholder': 'Например: Саратов')}}

                    </label>
                    <div class="styled_big fw_box no_bg">
								<span class="edit_desc">
									Цена
								</span>
								<span class="edit_desc fix pull-right">

									<select  name="price-usd" class="editors selector">
                                        <option value="1">
                                            руб/смена
                                        </option>
                                        <option value="2">
                                            руб/час
                                        </option>
                                    </select>
								</span>
								<span class="edit_desc fix pull-right">
                                    {{text_field('price-tex' , 'class':'editors','placeholder': '1500')}}

								</span>
                    </div>
                    <div class="styled_big fw_box no_bg">
								<span class="edit_desc">
									Сроки
								</span>
								<span class="edit_desc fix pull-right">
                                  {{text_field('date-from-tex' ,'data-date-format':"dd-mm-yyyy" ,'class':'editors','placeholder': '30.03.2013')}}

								</span>
								<span class="edit_desc fix pull-right">
                                     {{text_field('date-to-tex' , 'data-date-format':"dd-mm-yyyy" , 'class':'editors','placeholder': '12.03.2013')}}

								</span>
                    </div>
                    <label class="fw_box fw_box no_bg">
								<span class="edit_desc">
									Дополнительно
								</span>
								<span class="edit_desc fw_box">
									<textarea name="text-tex" class="editors fw_box"></textarea>
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