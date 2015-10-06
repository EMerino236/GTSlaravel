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
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
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
				$rules = array(
							'username' => 'required|min:6|max:45|unique:users',
							'email' => 'required|email|max:45',
							'genero' => 'required',
							'fecha_nacimiento' => 'required',
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
				$validator = Validator::make(Input::all(), $rules);
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
					
					return Redirect::to('user/create_user');
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
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
				$data["users_data"] = User::getUsersInfo()->paginate(10);
				return View::make('user/listUsers',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
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
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
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
				$validator = Validator::make(Input::all(), $rules);
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
					return Redirect::to($url);
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
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
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
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
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
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
				$data["users_data"] = User::searchUsers($data["search"])->paginate(10);
				return View::make('user/listUsers',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}
}