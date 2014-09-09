{{ content() }}
<span class="subcat">
                {% if sub_cat is iterable %}
                <p class="styled_big fw_box">
								<span class="edit_desc">
									Тип:
								</span>
                    <select name="sub_cat_id"   class="editors">
                        {%for key , val in sub_cat%}
                        <option value="{{ key }}">{{ val }}</option>
                        {% endfor %}
                    </select>
                </p>
                {% endif %}
                </span>