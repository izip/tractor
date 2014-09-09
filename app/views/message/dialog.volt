
<span class="right">
    {{ content() }}

    <div id="right-side" class="right-side ">
        <div class="send_massage full-description call_me">
            <h6>
                Сообщить пользователю Ваши контакты?
            </h6>
            <button class="b_call_me">
                <i class="fa fa-chevron-circle-right    "></i>
            </button>
        </div>
        <div class="content">
            {%if var is iterable%}
            {%for key , val in var%}
            <div class="full-description mess">
                <div class="comment">
                    <p class="com_title">
                                <span class="name normal_size">
                                    <i class="fa fa-user active"></i>
                                    {{val['author']}} - {{val['date']}}
                                </span>
                                <span class="time">
                                    {{val['org']}}
                                </span>
                    </p>
                    <p class="com_body">
                        {%if val['text'] is defined%}
                        {{val['text']}}
                        {%endif%}
                    </p>
                </div>
            </div>
            {%endfor%}
            {%endif%}
            <div class=" full-description mess">
                <!-- <p class="com_title no_marg">
                    <span class="name normal_size">
                        <i class="fa fa-reply  active"></i>
                        Ответить
                    </span>
                </p> -->
                <div class="comment ">
                	<div class="com_body no_bg ">
                		<textarea id="text_answer" class="info_block "></textarea>
                	</div>
                </div>
                <div class="comment">
                	<div class="com_body no_bg ">
                		<button id="send_answer" class="put_comment">Отправить</button>
                	</div>
                </div>
            </div>
        </div><!-- Content END -->

    </div>

</span>