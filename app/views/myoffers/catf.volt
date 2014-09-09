{{ content() }}
<span class="{%if c == 'y'%}catf{%else%}dop_f{%endif%}">
{%if cat is iterable %}
{%for key , val in cat%}
<div class="floated">
    <button type="button"  class="styled_big firster">
        <i class="fa fa-cogs  "></i>
    </button>
    <p class="styled_big w212">
								<span class="edit_desc">
									{{val[0]}}
								</span>
    </p>
    <p class="styled_big w128 ">
								<span class="edit_desc fix">
									<input disabled name="fil_cat-{{key}}" type="text" placeholder="{{val[1]}}" value="" class="editors">
								</span>
    </p>
</div>
{% endfor %}
{% endif %}
       </span>