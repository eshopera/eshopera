<li{{ component.attributes() }}">
    <a class="{{ component.linkClass }}{{ (component.active ? ' active' : '') }}" href="{{ component.link }}">
        {% if component.icon %}<i class="{{ component.icon }}"></i>{% endif %}
        {{ component.label }}
    </a>
</li>
