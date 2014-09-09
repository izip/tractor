{{ content() }}

<div class="contact-left">
    <ul class="base">
        <li class="some_pad big_bottom">
            <span class="title_icon_cont"> {%if user_id is defined%} {{user_id}} {%endif%}</span>
            <span class="title">Контакты</span>
        </li>
        <li class="some_pad">
            {%if first_name is defined%}   {{first_name}}{%endif%}
        </li>
        <li class="some_pad">
            {%if profession is defined%}   {{profession}}{%endif%}
        </li>

        <li class="some_pad">
            {%if phone is defined%} {{phone}}{%endif%}
        </li>
        <li class="some_pad">
            {%if email is defined%} {{email}}{%endif%}
        </li>
        <li class="some_pad">
            <a href="#"><i class="fa fa-vk"></i></a>
            <a href="#"><i class="fa fa-facebook-square"></i></a>
            <a href="#"><i class="fa fa-google-plus-square "></i></a>
            <a href="#"><i class="fa fa-instagram "></i></a>
            <a href="#"><i class="fa fa-twitter-square "></i></a>
            <a href="#"><i class="fa fa-vimeo-square "></i></a>
            <a href="#"><i class="fa fa-youtube-square "></i></a>

        </li>
        <li class="some_pad">
            {%if organization is defined%}   {{organization}}{%endif%}
        </li>

        <li class="some_pad">
         {%if country is defined%}   {{country}} {%endif%}
        </li>
        <li class="some_pad">
            {%if adress is defined%} {{adress}} {%endif%}
        </li>

    </ul>
</div><!-- contact-left END  -->