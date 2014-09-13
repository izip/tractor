<span class="right chat_right">
    {{ content() }}

    <div id="right-side" class="right-side ">
        <div class="send_massage full-description call_me">
            <h6>
                Сообщить пользователю Ваши контакты?
            </h6>
            <button class="b_call_me">
                <i class="fa fa-chevron-circle-right"></i>
            </button>

        </div>

        <div class="chat_info">

            <span><i class="fa fa-info-circle"></i> <b>Введите текст вашего сообщения</b></span>

        </div>


        <div class="content">

            <div class="full-description mess chat_add_mess">
                <form class="add_mess_chat">
                <div class="comment ">
                    <div class="com_body no_bg ">
                        <input type="hidden" name="chat_id" value="{{chat_id}}">
                        <textarea name="text" id="" class="info_block "></textarea>
                        <button id="chat_question" class="put_comment">
                            <i class="fa fa-question-circle"></i>
                        </button>
                        <button id="chat_mess" class="put_comment">
                            <i class="fa fa-comments"></i>
                        </button>
                    </div>


                </div>
                </form>
            </div>

            {% if chat is iterable %}
            {%for key , val in chat %}

            <div micro-chat-id="{{ key }}" class="full-description mess  mess_chat">
                <div class="comment">
                    {%if val['base']['type'] == 0%}
                    <i class="fa fa-question-circle"></i>
                    {% else %}
                    <i class="fa fa-comments"></i>
                    {%endif%}
                       <span> {%if val['base']['text'] is defined%}
                        {{val['base']['text']}}
                        {%endif%}
                        </span>
                </div>
            </div>
            {%if val['mess'] is defined and  val['mess'] is iterable%}
            {%for mess in val['mess'] %}
            <div class="full-description mess  mess_chat_micro">
                <div class="comment">
                    {%if mess['type'] == 0%}
                    <i class="fa fa-question-circle"></i>
                    {% else %}
                    <i class="fa fa-comments"></i>
                    {%endif%}

                       <span> {%if mess['text'] is defined%}
                        {{mess['text']}}
                        {%endif%}
                        </span>
                </div>
            </div>
            {% endfor %}
            {%endif%}
            {% endfor %}
            {% endif %}

        </div>
        <!-- Content END -->

    </div>

</span>