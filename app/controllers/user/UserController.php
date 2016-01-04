<?php

class UserController extends BaseController {

	public function render_create_user()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$data["tipos_documento"] = TipoDocumento::lists('nombre','idtipo_documento');
				$data["areas"] = Area::lists('nombre','idarea');
				$data["roles"] = Rol::lists('nombre','idrol');
				return View::make('user/createUser',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_create_user()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				// Validate the info, create rules for the inputs
				$attributes = array(
					'username' => 'Nombre de Usuario',
					'email' => 'E-mail',
					'genero' => 'Género',
					'fecha_nacimiento' => 'Fecha Nacimiento',
					'nombre' => 'Nombre',
					'apellido_pat' => 'Apellido Paterno',
					'apellido_mat' => 'Apellido Materno',
					'tipo_documento' => 'Tipo de Documento',
					'numero_doc_identidad' => 'Número de Documento de Identidad',
					'idarea' => 'Área',
					'idrol' => 'Rol',
					'telefono' => 'Teléfono'
					);

				$messages = array();

				$rules = array(
							'username' => 'required|min:6|max:45|unique:users|alpha_num_dash',
							'email' => 'required|email|max:45',
							'genero' => 'required',
							'fecha_nacimiento' => 'required',
							'nombre' => 'required|alpha_spaces|min:2|max:45|alpha_spaces',
							'apellido_pat' => 'required|alpha_spaces|min:2|max:45|alpha_num_dash',
							'apellido_mat' => 'required|alpha_spaces|min:2|max:45|alpha_num_dash',
							'tipo_documento' => 'required',
							'numero_doc_identidad' => 'required|numeric|digits_between:8,16',
							'idarea' => 'required',
							'idrol' => 'required',
							'telefono' => 'min:7|max:20|alpha_num_dash',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('user/create_user')->withErrors($validator)->withInput(Input::all());
				}else{
					$password = Str::random(8);
					$user = new User;
					$user->username = Input::get('username');
					$user->password = Hash::make($password);
					$user->email = Input::get('email');
					$user->nombre = Input::get('nombre');
					$user->apellido_pat = Input::get('apellido_pat');
					$user->apellido_mat = Input::get('apellido_mat');
					$user->idtipo_documento = Input::get('tipo_documento');
					$user->numero_doc_identidad = Input::get('numero_doc_identidad');
					$user->idarea = Input::get('idarea');
					$user->idrol = Input::get('idrol');
					$user->genero = Input::get('genero');
					$user->telefono = Input::get('telefono');
					$user->fecha_nacimiento = date('Y-m-d H:i:s',strtotime(Input::get('fecha_nacimiento')));
					$user->save();
					Mail::send('emails.user_registration',array('user'=> $user,'password'=>$password),function($message) use ($user)
					{
						$message->to($user->email, $user->name)
								->subject('Registro de nuevo usuario');
					});
					Session::flash('message', 'Se registró correctamente al usuario.');
					
					return Redirect::to('user/list_users');
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function list_users()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$data["search"] = null;
				$data["search_area"] = null;
				$data["areas"] = Area::lists('nombre','idarea');
				$data["users_data"] = User::getUsersInfo()->paginate(10);
				return View::make('user/listUsers',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_edit_user($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1) && $id){
				$data["tipos_documento"] = TipoDocumento::lists('nombre','idtipo_documento');
				$data["areas"] = Area::lists('nombre','idarea');
				$data["roles"] = Rol::lists('nombre','idrol');
				$data["user_info"] = User::searchUserById($id)->get();
				if($data["user_info"]->isEmpty()){
					return Redirect::to('user/list_user');
				}
				$data["user_info"] = $data["user_info"][0];
				return View::make('user/editUser',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_edit_user()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				// Validate the info, create rules for the inputs
				$attributes = array(
					'email' => 'E-mail',
					'genero' => 'Género',
					'fecha_nacimiento' => 'Fecha Nacimiento',
					'nombre' => 'Nombre',
					'apellido_pat' => 'Apellido Paterno',
					'apellido_mat' => 'Apellido Materno',
					'tipo_documento' => 'Tipo de Documento',
					'numero_doc_identidad' => 'Número de Documento de Identidad',
					'idarea' => 'Área',
					'idrol' => 'Rol',
					'telefono' => 'Teléfono'
					);

				$messages = array();

				$rules = array(
					'email' => 'required|email|max:45',
					'genero' => 'required',
					'fecha_nacimiento' => 'required',
					'nombre' => 'required|alpha_spaces|min:2|max:45|alpha_spaces',
					'apellido_pat' => 'required|alpha_spaces|min:2|max:45|alpha_num_dash',
					'apellido_mat' => 'required|alpha_spaces|min:2|max:45|alpha_num_dash',
					'tipo_documento' => 'required',
					'numero_doc_identidad' => 'required|numeric|digits_between:8,16',
					'idarea' => 'required',
					'idrol' => 'required',
					'telefono' => 'min:7|max:20|alpha_num_dash',
				);
				$rules = array(
					'email' => 'required|email|max:45',
					'genero' => 'required',
					'fecha_nacimiento' => 'required',
					'password' => 'min:6|max:30|confirmed',
					'password_confirmation' => 'min:6|max:30',
					'nombre' => 'required|alpha_spaces|min:2|max:45',
					'apellido_pat' => 'required|alpha_spaces|min:2|max:45',
					'apellido_mat' => 'required|alpha_spaces|min:2|max:45',
					'tipo_documento' => 'required',
					'numero_doc_identidad' => 'required|numeric|digits_between:8,16',
					'idarea' => 'required',
					'idrol' => 'required',
					'telefono' => 'min:7|max:20',
				);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					$user_id = Input::get('user_id');
					$url = "user/edit_user"."/".$user_id;
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{
					$user_id = Input::get('user_id');
					$url = "user/edit_user"."/".$user_id;
					$user = User::find($user_id);
					$user->email = Input::get('email');
					$user->nombre = Input::get('nombre');
					$user->apellido_pat = Input::get('apellido_pat');
					$user->apellido_mat = Input::get('apellido_mat');
					$user->idtipo_documento = Input::get('tipo_documento');
					$user->numero_doc_identidad = Input::get('numero_doc_identidad');
					$user->idarea = Input::get('idarea');
					$user->idrol = Input::get('idrol');
					$user->genero = Input::get('genero');
					$user->telefono = Input::get('telefono');
					$user->fecha_nacimiento = date('Y-m-d H:i:s',strtotime(Input::get('fecha_nacimiento')));
					$password = Input::get('password');
					if(!empty($password))
						$user->password = Hash::make($password);
					$user->save();
					Session::flash('message', 'Se editó correctamente al usuario.');
					return Redirect::to('user/list_users');
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_disable_user()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$user_id = Input::get('user_id');
				$url = "user/edit_user"."/".$user_id;
				$user = User::find($user_id);
				$user->delete();
				Session::flash('message', 'Se inhabilitó correctamente al usuario.');
				return Redirect::to($url);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_enable_user()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$user_id = Input::get('user_id');
				$url = "user/edit_user"."/".$user_id;
				$user = User::withTrashed()->find($user_id);
				$user->restore();
				Session::flash('message', 'Se habilitó correctamente al usuario.');
				return Redirect::to($url);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function search_user()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$data["search"] = Input::get('search');
				$data["search_area"] = Input::get('search_area');
				$data["areas"] = Area::lists('nombre','idarea');
				if($data["search"] == null && $data["search_area"]==0){
					$data["users_data"] = User::getUsersInfo()->paginate(10);
					return View::make('user/listUsers',$data);
				}else{
					$data["users_data"] = User::searchUsers($data["search"],$data["search_area"])->paginate(10);
					return View::make('user/listUsers',$data);	
				}				
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_view_user($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1) && $id){
				$data["tipos_documento"] = TipoDocumento::lists('nombre','idtipo_documento');
				$data["areas"] = Area::lists('nombre','idarea');
				$data["roles"] = Rol::lists('nombre','idrol');
				$data["user_info"] = User::searchUserById($id)->get();
				if($data["user_info"]->isEmpty()){
					return Redirect::to('user/list_user');
				}
				$data["user_info"] = $data["user_info"][0];
				return View::make('user/viewUser',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}
}