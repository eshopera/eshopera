{% extends 'core/auth/layout.volt' %}
{% block content %}
    <h1>{{ _('CORE_AUTH_FORGOT_TITLE') }}</h1>
    <p class="text-muted">{{ _('CORE_AUTH_FORGOT_TEXT') }}</p>
    <div id="loginFormCont">
        {% include('core/auth/forms/forgotten-password-form') %}
    </div>
{% endblock %}