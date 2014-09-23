{{ content() }}


<script type="application/javascript">

    $.ajax({
        type: 'post',
        url: '../option/contact',
        data: {},
        success: function (data) {

            $('.contact-left').replaceWith(data);
            //  $('.filter-left').css('z-index', '0');
            $('.contact-left').show().css('z-index', '9999999');
        }


    });

</script>

<div id="profile">
    <div class="profile-head">

        <span class="profile-name"> {{ user_field['first_name'] }} </span>
        <button class="form_profile_submit">
            <i class="fa fa-floppy-o "></i>
            Сохранить
        </button>


    </div>
    <form class="form_profile">
    <div class="left-side">
    <div class="profile-content">
        <ul>

            {% for key , val in user_field%}
            {% if(key == 'first_name') %}
            <li>
                <span class="text-field">Имя</span> <span class="prof-input">{{ text_field(key, "value": val, "size": 32) }}</span>

            </li>
            {% endif %}

            {% if(key == 'last_name') %}
            <li>
                <span class="text-field">Фамилия</span> <span class="prof-input">{{ text_field(key, "value": val, "size": 32) }}</span>

            </li>
            {% endif %}
            {% if(key == 'patronym') %}
            <li>
                <span class="text-field">Отчество</span> <span class="prof-input">{{ text_field(key, "value": val, "size": 32) }}</span>

            </li>
            {% endif %}
            {% if(key == 'email') %}
            <li>
                <span class="text-field">Email</span> <span class="prof-input">{{ text_field(key, "value": val, "size": 32) }}</span>

            </li>
            {% endif %}
            {% if(key == 'password') %}
            <li>
                <span class="text-field">Пароль</span> <span class="prof-input">{{ text_field(key, "value": "", "size": 32) }}</span>

            </li>
            {% endif %}
            {% if(key == 'phone') %}
            <li>
                <span class="text-field">Телефон</span> <span class="prof-input">{{ text_field(key, "value": val, "size": 32) }}</span>

            </li>
            {% endif %}
            {% if(key == 'location') %}
            <li>
                <span class="text-field">Страна</span> <span class="prof-input">{{ text_field(key, "value": val, "size": 32) }}</span>

            </li>
            {% endif %}
            {% if(key == 'adress') %}
            <li>
                <span class="text-field">Адресс</span> <span class="prof-input">{{ text_field(key, "value": val, "size": 32) }}</span>

            </li>
            {% endif %}
            {% endfor %}
        </ul>



    </div>

    </div>

    <div id="right-side" class="right-side">
        <div class="profile-content">
        <ul>
            {% for key , val in user_field%}
            {% if(key == 'country') %}
            <li>
                <span class="text-field">Город</span> <span class="prof-input">{{ text_field(key, "value": val, "size": 32) }}</span>

            </li>
            {% endif %}
            {% if(key == 'organization') %}
            <li>
                <span class="text-field">Организация</span> <span class="prof-input">{{ text_field(key, "value": val, "size": 32) }}</span>

            </li>
            {% endif %}
            {% if(key == 'profession') %}
            <li>
                <span class="text-field">Профессия</span> <span class="prof-input">{{ text_field(key, "value": val, "size": 32) }}</span>

            </li>
            {% endif %}
            {% if(key == 'sex') %}
            <li>
                <span class="text-field">Пол</span> <span class="prof-input">
                    <select name="sex">
                        <option>Муж</option>
                        <option>Женс</option>
                    </select>
                </span>

            </li>
            {% endif %}

            {% if(key == 'vkontakte') %}
            <li>
                <span class="text-field">Профиль вконтакте</span> <span class="prof-input">{{ text_field(key, "value": val, "size": 32) }}</span>

            </li>
            {% endif %}
            {% if(key == 'facebook') %}
            <li>
                <span class="text-field">Профиль facebook</span> <span class="prof-input">{{ text_field(key, "value": val, "size": 32) }}</span>

            </li>
            {% endif %}
            {% if(key == 'icq') %}
            <li>
                <span class="text-field">Профиль icq</span> <span class="prof-input">{{ text_field(key, "value": val, "size": 32) }}</span>

            </li>
            {% endif %}
            {% if(key == 'skype') %}
            <li>
                <span class="text-field">skype</span> <span class="prof-input">{{ text_field(key, "value": val, "size": 32) }}</span>

            </li>
            {% endif %}

            {% if(key == 'birthdate') %}
            <li>
                <span class="text-field">Дата рождения</span> <span class="prof-input">{{ text_field(key, "value": val, "size": 32) }}</span>

            </li>
            {% endif %}

            {% endfor %}

        </ul>
        </div>
    </div>
    </form>
</div>

