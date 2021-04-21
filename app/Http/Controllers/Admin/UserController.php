<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');  
        $this->middleware('can:edit-users'); 
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(2);
        $log = Auth::user();
        return view('admin.users.index',[
            'users' => $users,
            'log' => $log
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('Admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only([
            'name', 'email', 'password', 'password_confirmation'
        ]);

        $validator = $this->validator($data);

        if($validator->fails()){
            return redirect()->route('users.create')->withErrors($validator)->withInput();
            die();
        }else{
            $user = new User();
            $user->name = mb_convert_case($data['name'], MB_CASE_TITLE, 'UTF-8');
            $user->email = $data['email'];
            $user->password = Hash::make($data['password']);
            $user->save();

            return redirect()->route('users.index');
            die();
        }

       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        if($user){
            return view('admin.users.edit', ['user' => $user]);
            die();
        }else{
            return redirect()->route('users.index');
            die();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->only([
            'name', 'email','password','password_confirmation'
        ]);
        $user = User::find($id);
        if($user){
             $validator = Validator::make(['name' => $data['name'], 'email' => $data['email']], [
                 'name' => ['required', 'string', 'max:100'],
                 'email' => ['required', 'string', 'email', 'max:100']
             ]);

            if($validator->fails()){
                return redirect()->route('users.edit', [
                            'user' => $id
                        ])->withErrors($validator);
                        die();
            }else{
                //alteração do nome
                $user->name = mb_convert_case($data['name'], MB_CASE_TITLE, 'UTF-8');
                //verificando se o email ja foi alterado
                if($user->email != $data['email']){
                    $hasEmail = User::where('email', $data['email'])->get();
                    //verifica se o novo email já existe no campo
                    if(count($hasEmail) === 0){
                       $user->email = $data['email'];
                    }else{
                       $validator->errors()->add('email', __('validation.unique', [
                           'attribute' => 'email',
                       ]));
                    }
                }else{
                    //se o email foi igual
                }
            }
             //verifica se a senha foi digitada
            if(!empty($data['password'])){
                //verifica se a senha possui pelo menos 4 caract
                if(strlen($data['password']) >= 4 ){
                    //confirmação de senha
                if($data['password'] === $data['password_confirmation']){
                    $user->password = Hash::make($data['password']);
                }else{
                    $validator->errors()->add('password', __('validation.confirmed', [
                        'attribute' => 'password',
                    ]));
                }
                }else{
                    $validator->errors()->add('password', __('validation.min.string', [
                        'attribute' => 'password',
                        'min' => 4
                    ]));
                }
            
            }

            if(count($validator->errors()) > 0){
                return redirect()->route('users.edit', ['user' => $id])->withErrors($validator);
                die();
             }

             $user->save();

             return redirect()->route('users.index');
             die();
        }else{
            return redirect()->route('users.index')->with('error', 'Falha ao Editar o usuário' . $user->name);
            die();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->id != $id){
            $user = User::find($id);
            $user->delete();

            return redirect()->route('users.index');
            die();
        }else{
            return redirect()->route('users.index');
            die();
        }

    }

    public function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
            'password' => ['required', 'string', 'min:4', 'confirmed'],
        ]);
    }
}
