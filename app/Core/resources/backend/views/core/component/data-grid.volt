<table{{ component.attributes() }}>
    <thead>
        <tr>
            {% for column in component.getColumns() %}
                {% if column.show %}
                    <th>
                        {{ column.label }}
                    </th>
                {% endif %}
            {% endfor %}
        </tr>
    </thead>
    <tbody>
        <tr data-id="">
        </tr>
    </tbody>
</table>
