<li{{ component.attributes() }}>
    {% if component.active %}
        {{ component.label }}
    {% else %}
        <a href="{{ component.link }}">
            {{ component.label }}
        </a>
    {% endif %}
</li>
