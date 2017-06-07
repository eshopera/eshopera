<form action="{{ form.getAction() }}" method="post" data-ajaxize="form">
    {% include 'core/common/messages.volt' %}
    <div class="input-group mb-3">
        <span class="input-group-addon">
            <i class="fa fa-user"></i>
        </span>
        {{ form.render('username') }}
        {{ form.error('username') }}
    </div>
    <div class="row">
        {{ form.csrf(true) }}
        <div class="col-6">
            <button type="submit" class="btn btn-primary px-4">{{ _('CORE_AUTH_FORGOT_SUBMIT') }}</button>
        </div>
        <div class="col-6 text-right">
            <a href="{{ url.get('core/auth') }}" class="btn btn-link px-0">{{ _('CORE_AUTH_FORGOT_BACK') }}</a>
        </div>
    </div>
</form>