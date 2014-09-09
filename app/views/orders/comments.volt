{{content()}}
{%if comm is iterable%}
{%for key , val in comm%}
<div class="comment">
    <p class="com_title">
								<span class="name">
								{%if val[0] is defined %}{{val[0]}}	{%endif%}				</span>
								<span class="time">
								{%if val[2] is defined %}{{val[2]}}	{%endif%}									</span>
    </p>
    <p class="com_body">
        {%if val[1] is defined %}{{val[1]}}	{%endif%}
    </p>
</div>

{%endfor%}
{%endif%}