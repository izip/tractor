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
        <button class="">
            <i class="fa fa-floppy-o "></i>
            Сохранить
        </button>



    </div>
    <!-- Left Side HEAD END  -->

    <div class="profile-content">
        <ul>

            {% for key , val in user_field%}
            {% if(key == 'first_name') %}
            <li>
                <span class="text-field">Имя</span> <span class="prof-input">{{ text_field("name", "value": val, "size": 32) }}</span>

            </li>
            {% endif %}

            {% if(key == 'last_name') %}
            <li>
                <span class="text-field">Фамилия</span> <span class="prof-input">{{ text_field("name", "value": val, "size": 32) }}</span>

            </li>
            {% endif %}

            {% endfor %}

        </ul>


    </div>


</div>

