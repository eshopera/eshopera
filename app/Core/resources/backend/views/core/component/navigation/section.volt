<li{{ component.attributes() }}>
    <a class="{{ component.linkClass }}" href="#">
        {% if component.icon %}<i class="{{ component.icon }}"></i>{% endif %}
        {{ component.label }}
    </a>
    <ul class="{{ component.itemsClass }}">
        {% for item in component %}
            {{ item.render() }}
        {% endfor %}
    </ul>
</li>
