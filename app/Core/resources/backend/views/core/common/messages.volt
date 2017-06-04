{% set dismiss = 'close' %}
{% if flashSession.has('success') %}
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" title="{{ dismiss }}" aria-label="{{ dismiss }}">
            <i class="fa fa-times" aria-hidden="true"></i>
        </button>
        {{ flashSession.getMessages('success', false)|join('<br>') }}
    </div>
{% endif %}
{% if flashSession.has('error') %}
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" title="{{ dismiss }}" aria-label="{{ dismiss }}">
            <i class="fa fa-times" aria-hidden="true"></i>
        </button>
        {{ flashSession.getMessages('error', false)|join('<br>') }}
    </div>
{% endif %}
{% if flashSession.has('notice') %}
    <div class="alert alert-info alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" title="{{ dismiss }}" aria-label="{{ dismiss }}">
            <i class="fa fa-times" aria-hidden="true"></i>
        </button>
        {{ flashSession.getMessages('notice', false)|join('<br>') }}
    </div>
{% endif %}
{% if flashSession.has('warning') %}
    <div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" title="{{ dismiss }}" aria-label="{{ dismiss }}">
            <i class="fa fa-times" aria-hidden="true"></i>
        </button>
        {{ flashSession.getMessages('warning', false)|join('<br>') }}
    </div>
{% endif %}
{% set cleared = flashSession.clear() %}
