<table{{ component.attributes() }}>
    <thead>
        <tr>
            {% for column in component %}
                {% if column.show %}
                    {{ item.label }}
                {% endif %}
            {% endfor %}
        </tr>
    </thead>
    <tbody>
        <tr data-id="">
        </tr>
    </tbody>
</table>
