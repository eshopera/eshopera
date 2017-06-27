<header class="app-header navbar">
    <button class="navbar-toggler mobile-sidebar-toggler d-lg-none" type="button">&#9776;</button>
    <a class="navbar-brand" href="{{ url.get('') }}"></a>
    <ul class="nav navbar-nav d-md-down-none">
        <li class="nav-item">
            <a class="nav-link navbar-toggler sidebar-toggler" href="#">&#9776;</a>
        </li>
    </ul>
    <ul class="nav navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" href="{{ url.get('core/auth/logout') }}" title="{{ _('CORE_AUTH_LOGOUT') }}"><i class="fa fa-2x fa-sign-out"></i></a>
        </li>
    </ul>
</header>

<div class="app-body">
    <div class="sidebar">
        <nav class="sidebar-nav">
            {{ ui.menu }}
        </nav>
    </div>

    <!-- Main content -->
    <main class="main">
        {% block breadcrumb %}
            {{ ui.breadcrumb.render() }}
        {% endblock %}
        <div class="container-fluid">
            {% block content %}
            {% endblock %}
        </div>
    </main>
</div>
