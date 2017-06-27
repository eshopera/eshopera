{% extends 'core/layout.volt' %}
{% block content %}
    <div class="card">
        <h4 class="card-header">
            {{ title }}
        </h4>
        <div class="card-block">
            {{ dataGrid.render() }}
        </div>
    </div>
{% endblock %}