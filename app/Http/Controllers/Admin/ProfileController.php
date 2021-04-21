<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isEmpty;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        if($user){
            return view('Admin.profile.index', ['user' => $user]);
        }else{
            return redirect()->route('painel.index');
        }

    }
    public function save(Request $request)
    {
        $user = $request->only([
            'name', 'email', 'password', 'password_confirmation'
        ]);

        $user['id'] = Auth::user()->id;

        $validator = Validator::make(['name'=>$user['name'],'email' => $user['email']],[
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email','max:100'],
        ]);


        /* algo a validar:  */
        if($validator->fails()){
            return redirect()->route('profile')->withErrors($validator)->withInput();
        }else{
           $data = User::find(intval($user['id']));
            if(isset($data)){
                $data->name = mb_convert_case($user['name'], MB_CASE_TITLE, 'UTF-8');
                if($data->email != $user['email']){
                    $hasEmail = User::where('email', $user['email'])->get();
                    if(count($hasEmail) === 0){
                        $data->email = $user['email'];
                    }else{
                        $validator->errors()->add('email', __('validation.unique', [
                            'attribute' => 'email',
                        ]));
                    }
                }

                if(strlen($user['password']) === 0){
                }else{
                    if(strlen($user['password']) >= 4){
                        if($user['password'] === $user['password_confirmation']){
                            $data->password = Hash::make($user['password']);
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
                    return redirect()->route('profile', ['user' => $user])->withErrors($validator);
                    die();
                }else{
                    $data->save();
                    return redirect()->route('profile')->with('warning', 'Informações alteradas com sucesso');
                    die();
                }
            }else{
                return redirect()->route('profile')->withErrors($validator)->withInput();
                die();
            }
        
        }

    }
}
