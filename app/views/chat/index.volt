
{{ content() }}
<span class="left chat_left">
<div id="left-side-head" class="head ">
    <ul>
        <li class="search-all go_left">
            <input type="text" id="left_cat" name="left_cat" value="Александр Пушкин"/>

        </li>
        <li class="add-item chat_add">

            <button class="chat_add_button">
                <i class="fa fa-plus"></i>
            </button>

        </li>
    </ul>
</div><!-- Left Side HEAD END  -->

<div data-page-total="{{page_total}}" data-page-num="{{page_num}}" class="left-side">
    <div id="left-side-head-two" class="head ">

        <ul>

            <li >
                <i class="fa fa-info-circle"></i>
                <b>Здесь можно создать тему для обсуждения и найти ответы</b>
            </li>

        </ul>

    </div><!-- Left Side HEAD END  -->

    <div class="fix_holder"></div>

    {%if chats is iterable %}
    {% for key , chat in chats %}
    <a  data-chat="{{ key }}" href="#chat{{ key }}" class="offer mini chat_list">
        <ul>
            <li  class="lefted">
                <i class="fa fa-question-circle "></i>
            </li>
            <li  class="text">
                {% if chat_s is iterable  and chat_s[key] is defined %}
           {{ chat_s[key] }}
                {%else%}
                Нет сообщений
                {% endif %}
            </li>
            <li  class="righted">
                {% if chat_s is iterable and chat_s[key] is defined%}
                <i class="active fa fa-comment"></i>

                {%else%}
                <i class="fa fa-comment"></i>
                {% endif %}
            </li>


        </ul>
    </a><!-- This Offer END -->

    {% endfor %}
    {% endif %}
</div>


<div class="right-side-head">
    <div class="top_title">
						<span data-user="1" class="name main_page">
							Виктор						</span>
						<span class="item_title_two">
							<button class="contacts b_contacts">
                               <i class="fa fa-user"></i>
                            </button>
							<button class="b_comment">
                                <i class="fa fa-comment "></i>
                            </button>
							<button class="put_call_me">
                                <i class="fa fa-bolt b_send_request"></i>
                            </button>
                            <button class="chat_del myoff_but b_off_kill none_active">
                                <i class="fa fa-trash-o"></i>
                                Удалить
                            </button>
						</span>
    </div>

</div><!-- RightSide HEAD END  -->


<span class="right chat_right"></span>

</span>