
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
            {{ form('myoffers/addofferform', 'class' :'addoffer','enctype': 'multipart/form-data'  ) }}
            <div class="description">
                <div class="images">
                    <div class="pic">

                        <div>
                            <i class="fa fa-camera-retro "></i> <br>
                            загрузить фото


                            <input name="myfile[]" type="file" multiple class="mul"/>


                            <input name="offer_id" type="hidden"  value="{{offer_id}}" hidden>
                        </div>
                    </div>
                </div>
                <div>

                    {% if cat is iterable %}
                    <p class="styled_big">
								<span class="edit_desc">
									Класс:
								</span>
                        <select name="cat_id"   class="editors">
                            {%for key , val in cat%}
                            {%if par_cat == key %}
                            <option selected value="{{ key }}">{{ val }}</option>
                            {%else%}
                            <option value="{{ key }}">{{ val }}</option>
                            {% endif %}
                            {% endfor %}
                        </select>
                    </p>
                    {% endif %}
                <span class="subcat">
                {% if sub_cat is iterable %}
                <p class="styled_big">
								<span class="edit_desc">
									Тип:
								</span>
                    <select name="sub_cat_id"   class="editors">
                        {%for key , val in sub_cat%}
                        {%if cat_id == key %}
                        <option selected value="{{ key }}">{{ val }}</option>
                        {%else%}
                        <option value="{{ key }}">{{ val }}</option>
                        {% endif %}
                        {% endfor %}
                    </select>
                </p>
                {% endif %}
                </span>


                    {%if field is iterable %}
                    {%for key , val in field%}

                    {%if key == 20%}

                    <p class="styled_big">
								<span class="edit_desc">
									{{val}}:
								</span>
                        <input name="model" type="text" value="{{offer_name}}" class="editors">
                    </p>
                    {%elseif key == 4%}

                    <p class="styled_big">
								<span class="edit_desc">
									{{val}}:
								</span>
                        <input name="city" type="text" value="{%if dan_fil[key] is defined%}{{dan_fil[key]}}{%endif%}" class="editors">
                    </p>

                    {%elseif key == 5%}

                    <p class="styled_big">
								<span class="edit_desc">
									{{val}}:
								</span>
                        <input name="price" type="text" value="{%if dan_fil[key] is defined%}{{dan_fil[key]}}{%endif%}" class="editors">
                    </p>
                    {%endif%}
                    {%endfor%}
                    {%endif%}
                </div>
            </div>
            <div class="full-description">
                <h6>
                    Параметры объявления:
                </h6>
                <div class="floated">
                    <p class="styled_big w128">
								<span class="edit_desc">
									Оператор
								</span>
                    </p>
                    {%if dan_fil[14] is defined and dan_fil[14] == 'y'%}
                    <button  type="button" class="styled_big active">
                        <input name="oper" type="hidden"  value="y" >
                        <i class="fa fa-user "></i>
                    </button>
                    {%else%}

                    <button  type="button" class="styled_big ">
                        <input name="oper" type="hidden" disabled value="n" >
                        <i class="fa fa-user "></i>
                    </button>

                    {%endif%}
                    {%if dan_fil[7] is defined and dan_fil[7] == 'y'%}
                    <button type="button" class="styled_big revers active">
                        <input name="gsm-act" type="hidden"  value="y" hidden>
                        <i class="fa fa-tint  "></i>
                    </button>
                    {%else%}

                    <button type="button" class="styled_big revers">
                        <input name="gsm-act" type="hidden" disabled value="n" hidden>
                        <i class="fa fa-tint  "></i>
                    </button>
                    {%endif%}
                    <p class="styled_big w128">
								<span class="edit_desc">
									ГСМ
								</span>
                    </p>
                </div>
                <div class="floated">
                    <p class="styled_big w128">
								<span class="edit_desc">
									Доставка
								</span>
                    </p>
                    {%if dan_fil[6] is defined and dan_fil[6] == 'y'%}
                    <button type="button" class="styled_big active">
                        <input name="dost-act" type="hidden"  value="y" hidden>
                        <i class="fa fa-truck  "></i>
                    </button>
                    {%else%}
                    <button type="button" class="styled_big ">
                        <input name="dost-act" type="hidden" disabled value="n" hidden>
                        <i class="fa fa-truck  "></i>
                    </button>
                    {%endif%}
                    {%if dan_fil[15] is defined and dan_fil[15] >0%}
                    <button type="button" class="styled_big revers active">
                        <i class="fa fa-dot-circle-o "></i>
                    </button>

                    <p class="styled_big w128 ">
								<span class="edit_desc fix">
									<input name="rad-dost" type="text" value="{{dan_fil[15]}}" class="editors">
								</span>
                        {%else%}
                        <button type="button" class="styled_big revers ">
                            <i class="fa fa-dot-circle-o "></i>
                        </button>

                    <p class="styled_big w128 ">
								<span class="edit_desc fix">
									<input disabled name="rad-dost" type="text" value="" class="editors">
								</span>
                        {%endif%}
                    </p>
                </div>
            </div>
            <div class="full-description">

                <span class="catf">
                {%if cat_fieldf is iterable%}
                <h6>
                    Характеристики техники:
                </h6>

                {%for key , val in cat_fieldf%}
                {%if dan_fil[key] is defined and dan_fil[key]|length >0 %}
                <div class="floated">
                    <button type="button"  class="styled_big firster active">
                        <i class="fa fa-cogs  "></i>
                    </button>
                    <p class="styled_big w212">
								<span class="edit_desc">
									{{val[0]}} {{val[1]}}:
								</span>
                    </p>
                    <p class="styled_big w128 ">
								<span class="edit_desc fix">
									<input  name="fil_cat-{{key}}" type="text" value="{{dan_fil[key]}}" class="editors">
								</span>
                    </p>
                </div>
                {%else%}

                <div class="floated">
                    <button type="button"  class="styled_big firster">
                        <i class="fa fa-cogs  "></i>
                    </button>
                    <p class="styled_big w212">
								<span class="edit_desc">
								{{val[0]}} {{val[1]}}:
								</span>
                    </p>
                    <p class="styled_big w128 ">
								<span class="edit_desc fix">
									<input disabled name="fil_cat-{{key}}" type="text" value="" class="editors">
								</span>
                    </p>
                </div>
                {%endif%}
                {%endfor%}
                {%endif%}
                    </span>
                <span class="dop_f">
{%if cat_field is iterable%}


                {%for key , val in cat_field%}
                {%if dan_fil[key] is defined and dan_fil[key]|length >0 %}
                <div class="floated">
                    <button type="button"  class="styled_big firster active">
                        <i class="fa fa-cogs  "></i>
                    </button>
                    <p class="styled_big w212">
								<span class="edit_desc">
									{{val[0]}} {{val[1]}}:
								</span>
                    </p>
                    <p class="styled_big w128 ">
								<span class="edit_desc fix">
									<input  name="fil_cat-{{key}}" type="text" value="{{dan_fil[key]}}" class="editors">
								</span>
                    </p>
                </div>
                {%else%}

                <div class="floated">
                    <button type="button"  class="styled_big firster">
                        <i class="fa fa-cogs  "></i>
                    </button>
                    <p class="styled_big w212">
								<span class="edit_desc">
								{{val[0]}} {{val[1]}}:
								</span>
                    </p>
                    <p class="styled_big w128 ">
								<span class="edit_desc fix">
									<input disabled name="fil_cat-{{key}}" type="text" value="" class="editors">
								</span>
                    </p>
                </div>
                {%endif%}
                {%endfor%}
                {%endif%}
            </span>
            </div>
            <div class="full-description">
                <h6>
                    Характеристики техники:
                </h6>

                <p class="styled_big w425 ">
								<span class="edit_desc ">
									<textarea name="text_offer"  class="editors">{{offer_text}}</textarea>
								</span>
                </p>


            </div>

            <input hidden="" type="submit" value="">

            </form>

        </div>
    </div>

    <span class="right-offer"></span>
    <!-- Right Side END -->
</span>