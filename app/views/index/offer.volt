{{ content() }}
<span class="right">
<div class="right-side-head">
    <div class="top_title">
						<span class="name main_page" data-user="{{user_id}}">
							{{name}}
						</span>
						<span class="item_title_two">
							<button class="contacts b_contacts">
                                Контакты
                            </button>
							<button class="b_comment">
                                <i class="fa fa-comment "></i>
                            </button>
							<button class="put_call_me">
                                <i class="fa fa-bolt b_send_request"></i>
                            </button>
						</span>
    </div>
</div><!-- RightSide HEAD END  -->

<div id="right-side" class="right-side">
    <div class="send_massage full-description call_me">
        <h6>
            Сообщить пользователю Ваши контакты?
        </h6>
        <button class="b_call_me">
            <i class="fa fa-chevron-circle-right    "></i>
        </button>
    </div>
    <div class="send_massage full-description send_me">
        <h6>
            Личное сообщение
        </h6>

            <textarea class="info_block"></textarea>
						<span>
							99 символов
						</span>
            <button class="put_comment">
                отправить
            </button>

    </div>
    <div class="content">
        <div class="top_title">
							<span class="item_title">
								{{offer_name}}
							</span>
							<span class="item_title_two clone_style">
								<i class="fa fa-refresh active "></i>
								{{offer_date}}
							</span>
        </div>
        <div class="description">
            <div class="images">
                {%if offer_image is iterable%}
                {% if offer_image['image-medium-1'] is defined %}
                <a href="{{offer_image['image-big-1']}}"  class="MagicZoomPlus" rel="hint:false;buttons:hide;"> {{image(offer_image['image-medium-1'])}}</a>
                {%else%}
                {{image("i/defimage.png")}}
                {%endif%}
                {% if offer_image['image-small-2'] is defined %}
                {{image(offer_image['image-small-2'] , "class":"mini_prev")}}
                {%else%}
                {{image("i/defimage.png" , "class":"mini_prev")}}
                {%endif%}
                {% if offer_image['image-small-3'] is defined %}
                  {{image(offer_image['image-small-3'] , "class":"mini_prev")}}
                {%else%}
                {{image("i/defimage.png" , "class":"mini_prev")}}
                {%endif%}
                        {% if offer_image['image-small-4'] is defined %}
                {{image(offer_image['image-small-4'] , "class":"mini_prev last")}}
                {%else%}
                {{image("i/defimage.png" , "class":"mini_prev last")}}
                {%endif%}
                {%else%}
                {{image("i/defimage.png")}}
                {{image("i/defimage.png" , "class":"mini_prev")}}
                {{image("i/defimage.png" , "class":"mini_prev")}}
                {{image("i/defimage.png" , "class":"mini_prev last")}}

                {%endif%}
            <div>
                <button class="buttons">
                    <i class="fa fa-star  "></i>
                </button>
                <button class="buttons">
                    <i class="fa fa-map-marker "></i>
                </button>
                <button class="buttons last">
                    <i class="fa fa-tachometer  "></i>
            </div>
                </button>
            </div>
            <div>
                <p>

                    {% if oper == 'y' %}
                    <i class="fa fa-user active"></i>
                    есть оператор
                    {% else %}
                    <i class="fa fa-user "></i>
                    нет оператора
                    {% endif %}
                </p>
                <p>
                    {% if gsm == 'y' %}
                    <i class="fa fa-tint active"></i>
                    гсм за счёт владельца
                    {% else %}
                    <i class="fa fa-tint "></i>
                    гсм за счёт клиента
                    {% endif %}
                </p>
                <p>
                    {% if dost is defined and dost == 'y' %}
                    <i class="fa fa-truck active"></i>
                    доставка есть
                    {% else %}
                    <i class="fa fa-truck "></i>
                    доставки нет
                    {% endif %}
                </p>
                {%if radius_d != false%}
                <p>
                    <i class="fa fa-dot-circle-o  active"></i>
                    {{radius_d}}
                </p>
                {% endif %}
                <p>
                    {% if status == 1 %}
                    <i class="fa fa-circle-o active"></i>
                    свободен
                    {% else %}
                    <i class="fa fa-circle-o "></i>
                    Занят
                    {% endif %}
                </p>
                {% if price != false %}
                <p>
                    <i class="fa fa-rub active"></i>
                    {{price}}
                </p>
                {% endif %}
                {%if cat_dann is iterable%}
                {%for name , val in cat_dann%}
                <p>
                    <i class="fa fa-gears active"></i>
								<span class="green">
									{{name}}
								</span>
                    {{val}}
                </p>
                {% endfor %}
                {% endif %}
                <p>
                    <i class="fa fa-tag active"></i>
                    id {{offer_id}}
                </p>
                {%if spec != false%}
                <p>
                    <i class="fa fa-paperclip active "></i>
                    <a href="spec">
                        {{spec}}
                    </a>
                </p>
                {%endif%}
            </div>
        </div>
        <div class="full-description">
            <h6>
                Характеристики:
            </h6>
            <div class="info_block">
              {{offer_text}}
            </div>
        </div>
        <div class="full-description">
            <span class="comments">
            {%if comments is iterable%}
            <h6>
                Комментарии:
            </h6>


            {%for comm in comments%}
            <div class="comment">
                <p class="com_title">
								<span class="name">
									{{comm['reciever']}}
								</span>
								<span class="time">
									{{comm['date']}}
								</span>
                </p>
                <p class="com_body">
                    {{comm['text']}}

                </p>
            </div>
            {%endfor%}
            {%else%}
            <h6>
                Комментарии: комментариев нет
            </h6>


            {%endif%}

                <textarea data-offer="{{offer_id}}" class="info_block comm"></textarea>
                <button class="put_comment">
                    отправить
                </button>
</span>
        </div>

    </div><!-- Content END -->
</div><!-- Right Side END -->
    </span>