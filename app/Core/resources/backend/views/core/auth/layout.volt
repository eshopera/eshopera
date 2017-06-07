<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-group mb-0">
                <div class="card p-4">
                    <div class="card-block">
                        {% block content %}
                        {% endblock %}
                    </div>
                </div>
                <div class="card card-inverse card-primary py-5 d-md-down-none" style="width:44%">
                    <div class="card-block text-center">
                        <div>
                            <h2>{{ appName }}</h2>
                            <img class="img-fluid" src="{{ cdn }}/img/logo.png" alt="Logo">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>