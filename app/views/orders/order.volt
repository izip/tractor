{{ content() }}
<span class="right">
<div class="right-side-head">
    <div class="top_title">
						<span class="name main_page" data-user="{% if user_id is defined %}{{user_id}}{%endif%}">
							{% if user_name is defined %} {{user_name}} {%endif%}
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
                    Личнео сообщение
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
                <div class="full-description styler">
                    {%if order is iterable%}
                    {%for key , val in order%}
                    {%if val[4] is defined%}
                    <p class="off_block">
                        <i class="fa fa-map-marker  active "></i>
						<span class="city">
							Город:
						</span>
						<span class="desc">
							{{val[4]}}
						</span>
                    </p>

                    {%endif%}
                    {%if order_cat is defined%}

                    <p class="off_block">
                        <i class="fa fa-truck  active "></i>
						<span class="city">
							Категория:
						</span>
						<span class="desc">
							{{order_cat}}
						</span>
                    </p>
                    {%endif%}
                    {%if val[21] is defined%}

                    <p class="off_block">
                        <i class="fa fa-list-alt active "></i>
						<span class="city">
							Тип техники:
						</span>
						<span class="desc">
							{{val[21]}}
						</span>
                    </p>

                    {%endif%}
                    {%if val[5] is defined%}
                    <p class="off_block">
                        <i class="fa fa-rub  active "></i>
						<span class="city">
							Цена:
						</span>
						<span class="desc">
							{{val[5]}} рублей за смен
						</span>
                    </p>
                    {%endif%}
                    {%if order_text is defined%}
                    <p class="off_block">
                        <i class="fa fa-comment   active fixed_ads "></i>
						<span class="comentator">
                         {{  order_text}}
						</span>
                    </p>
                    {%endif%}
                    {%endfor%}
                    {%endif%}

                </div>

                <div class="full-description">
                    <span class="comments">
                    {%if comm is iterable%}
                    <h6>
                        Комментарии:
                    </h6>
                    {%for key , val in comm %}
                    <div class="comment">
                        <p class="com_title">
								<span class="name">
									{%if val[0] is defined%} {{val[0]}}{%endif%}
								</span>
								<span class="time">
								{%if val[2] is defined%} {{val[2]}}{%endif%}
								</span>
                        </p>
                        <p class="com_body">
                            {%if val[1] is defined%} {{val[1]}}{%endif%}

                        </p>
                    </div>

                    {%endfor%}


                    {%else%}

                    <h6>
                        Комментариев нет..
                    </h6>
                    {%endif%}
                        </span>

                    <textarea data-order="{{order_id}}" class="info_block comm"></textarea>
                    <button class="put_comment">
                        отправить
                    </button>


                </div>

            </div><!-- Content END -->
        </div><!-- Right Side END -->



</span>