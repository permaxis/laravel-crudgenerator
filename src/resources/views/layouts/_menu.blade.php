<div class="sidebar-nav">
    <div class="navbar navbar-default" role="navigation">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <span class="visible-xs navbar-brand">Sidebar menu</span>
        </div>
        <div class="navbar-collapse collapse sidebar-navbar-collapse">
            <ul class="nav navbar-nav">
                {{--bc--}}<li class="{{ (Route::currentRouteName() == 'crudgenerator.entities.index')? 'active' : '' }}"><a href="{{ route('crudgenerator.entities.index') }}">Entities</a></li>{{--ec--}}
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</div>


