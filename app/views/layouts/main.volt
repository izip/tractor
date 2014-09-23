    {{ content() }}

    <nav id="menu" class="">
        <ul>
            <li class="menu-head">
                {{ image("i/logo.png" , "class": "logo") }}
                <p class="menu-head-warp">
							<span class="hide_mob">
								<button class="cat_name">Погрузчики</button>
							</span>
                </p>
            </li><!-- Search Input HEAD END -->
            <hr/>

            <li >
                <a href="{{ url("orders") }}">
                    <i class="fa fa-bolt  "></i>
                    <span class="hide_mob">Заявки</span>
                </a>
            </li>
            <li >
                <a href="{{ url("") }}">
                    <i class="fa fa-bullhorn "></i>
                    <span class="hide_mob">Предложения</span>
                </a>
            </li>
            <li>
                <a href="#filters" id="b_filter">
                    <i class="fa fa-filter  "></i>
                    <span class="hide_mob">Фильтры</span>
                </a>
            </li>
            <li>
                <a href="{{ url("option") }}">
                    <i class="fa fa-cog "></i>
                    <span class="hide_mob">Настройки</span>
                </a>
            </li>
            <hr/>
            <li>
                <a href="{{ url("myorders") }}">
                    <i class="fa fa-envelope-o "></i>
                    <span class="hide_mob">Мои заявки</span>
                </a>
            </li>
            <li>
                <a href="{{ url("myoffers") }}">
                    <i class="fa fa-envelope  "></i>
                    <span class="hide_mob">Мои предложения</span>
                </a>
            </li>
            <hr/>
            <li>
                <a href="{{ url("message") }}">
                    <i class="fa fa-folder-open-o   "></i>
                    <span class="hide_mob">Сообщения</span>
                </a>
            </li>
            <li>
                <a href="{{ url("notifications") }}">
                    <i class="fa fa-exclamation-triangle "></i>
                    <span class="hide_mob">Уведомления</span>
                </a>
            </li>
            <hr/>
            <li>
                <a href="{{ url("chat") }}">
                    <i class="fa fa-comment "></i>
                    <span class="hide_mob">Чат</span>
                </a>
            </li>
            <li>
                <a href="{{ url("answers") }}">
                    <i class="fa fa-comments-o "></i>
                    <span class="hide_mob">Ответы</span>
                </a>
            </li>
            <hr/>
            <li>
                <a href="{{ url("regulations") }}">
                    <i class="fa fa-file-text-o  "></i>
                    <span class="hide_mob">Правила</span>
                </a>
            </li>
            <li>
                <a href="{{ url("contact") }}">
                    <i class="fa fa-users  "></i>
                    <span class="hide_mob">Контакты</span>
                </a>
            </li>
            <hr/>
        </ul>
    </nav>
    </div>

    <div class="filter-left ">

    </div><!-- filter-lef END  -->

    <div class="contact-left"></div>
    <nav id="cat_menu" class="cat_menu">
        <ul>
            <p class="header">Выберите категорию:</p>

            {{elements.getmenu()}}


        </ul>
    </nav>
    <nav id="sub_cat_menu" class="cat_menu">
        <ul>
            <p class="header">Выберите подкатегорию:</p>

            {{elements.getsubmenu()}}

        </ul>
    </nav>