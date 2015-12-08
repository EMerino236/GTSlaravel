@extends('templates/loginTemplate')
@section('content')
	<div id="message-container">
		@if (Session::has('error'))			
			<div class="alert alert-danger alert-dissmisable">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('error') }}
			</div>
		@endif
		@if (Session::has('message'))
			
			<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				{{ Session::get('message') }}
			</div>
		@endif
	</div>
		
	<div id="header">
		<div class="row">
			<img id="logo1" src="{{asset('img')}}/logo_uib.jpg">
			<p id="title1" >PROGRAMA DE GESTION EN TECNOLOGIAS DE SALUD E INGENIERIA CLINICA</p>
		</div>
	</div>
	<div class="top-content">        	
       <div class="container">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3 form-box">
                	<div class="form-top">
                		<div class="form-top-left">
                			<h3><strong>Bienvenido al Sistema GTS</strong></h3>
                    		<p>Ingrese a su cuenta</p>
                		</div>
                		<div class="form-top-right">
                			<i class="fa fa-lock"></i>
                		</div>
                    </div>
                    {{ Form::open(array('url'=>'login', 'role'=>'form')) }}
                    <div class="form-bottom">
	                    <form role="form" action="" method="post" class="login-form">			                    	
	                    	<div class="form-group">
	                    		<label class="sr-only" for="form-username">Usuario</label>
	                        	<div class="input-group">
			                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
			                        {{ Form::text('usuario',Input::old('usuario'),array('class'=>'form-control','placeholder'=>'Usuario')) }}                                      
		                    	</div>
	                        </div>
	                        <div class="form-group">
	                        	<label class="sr-only" for="form-password">Contraseña</label>
	                        	<div class="input-group">
			                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
			                       	{{ Form::password('password',array('class'=>'form-control','placeholder'=>'Contraseña')) }}
		                    	</div>
	                        </div>
	                        {{ Form::submit('Ingresar',array('id'=>'submit-login', 'class'=>'btn btn-lg btn-primary btn-block')) }}
	                        
	                    </form>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

@stop