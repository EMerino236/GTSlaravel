<div class="navbar-header">
    
     <a href="{{ URL::to('/') }}" style="text-decoration:none;">
        <img src="{{asset('img')}}/logo_gts.png" width="50" style="display:inline-block;margin-left:22px;"/>
        <h4 style="display:inline-block;margin-top:5px;font-family:'softwareTest';font-weight:bold;"> GTS SOFTWARE </h4>
    </a>    
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
</div>
<!-- /.navbar-header -->

<ul class="nav navbar-top-links navbar-right">
    
	<li>
		<a href="{{ URL::to('dashboard') }}"><i class="fa fa-dashboard fa-fw"></i> Panel</a>
    </li>
	<li>
		<a href="{{ URL::to('planeamiento') }}"><i class="fa fa-calendar fa-fw"></i> Planeamiento</a>
    </li>
	<li>
		<a href="{{ URL::to('adquisicion') }}"><i class="fa fa-credit-card fa-fw"></i> Adquisición</a>
    </li>
	<li>
		<a href="{{ URL::to('bienes') }}"><i class="fa fa-wrench fa-fw"></i> Bienes</a>
    </li>
	<li>
		<a href="{{ URL::to('riesgos') }}"><i class="fa fa-bomb fa-fw"></i> Riesgos</a>
    </li>
	<li>
		<a href="{{ URL::to('investigacion') }}"><i class="fa fa-graduation-cap fa-fw"></i> Investigación</a>
    </li>
	<li>
		<a href="{{ URL::to('#') }}"><i class="fa fa-users fa-fw"></i> RRHH</a>
    </li>
    
    <!-- /.dropdown -->
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fa fa-gear fa-fw"></i>  <i class="fa fa-caret-down"></i>
        </a>
        <ul class="dropdown-menu dropdown-user">
            @if($user->idrol == 1)
            <li>
                <a href="{{ URL::to('user/list_users') }}"><i class="fa fa-user fa-fw"></i> Usuarios</a>
            </li>
            <li>
                <a href="{{ URL::to('configuraciones/') }}"><i class="fa fa-gear fa-fw"></i> Configuraciones</a>
            </li>
            <li class="divider"></li>
            @endif
            <li>
                <a href="{{ URL::to('logout') }}"><i class="fa fa-sign-out fa-fw"></i> Cerrar Sesión</a>
            </li>
        </ul>
        <!-- /.dropdown-user -->
    </li>
    <!-- /.dropdown -->
</ul>
<!-- /.navbar-top-links -->

