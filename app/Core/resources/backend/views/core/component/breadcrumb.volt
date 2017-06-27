<ol{{ component.attributes() }}>
    {% for item in component %}
        {{ item.render() }}
    {% endfor %}
</ol>
