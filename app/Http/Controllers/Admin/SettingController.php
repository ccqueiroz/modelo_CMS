<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isEmpty;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $data = Setting::all();
        $description = [
            'title' => 'Título do Site',
            'subtitle' => 'Subtítulo do Site',
            'email' => 'E-mail para contato',
            'bgcolor' => 'Cor de Fundo',
            'textcolor' => 'Cor do Texto'
        ];

        $dataArray = array();
        foreach($data as $x){
            $dataArray[] = $x;
        }

        return view('Admin.settings.index', [
            'data' => $dataArray,
            'description' => $description
        ]);
    }

    public function save(Request $request)
    {
       $data = $request->only([
            'title', 'subtitle', 'email', 'bgcolor', 'textcolor'
            ]);

        $validador = $this->validator($data);

        if($validador->fails()){
            return redirect()->route('settings')->withErrors($validador);
        }else{
            //title
            $userTitle = Setting::where('name', 'title');
            $userTitle->update([
                'content' => mb_convert_case(strval($data['title']), MB_CASE_TITLE, 'UTF-8')
              ]);          
    
            //subtitle
            $userSubTitle = Setting::where('name', 'subtitle');
            $userSubTitle->update([
                'content' => mb_convert_case(strval($data['subtitle']), MB_CASE_TITLE, 'UTF-8')
            ]);

            //email
            $userEmail = Setting::where('name', 'email');
            $userEmail->update(
               [ 'content' => $data['email']]
            );
    
            //bgcolor
            $userBgColor = Setting::where('name', 'bgcolor');
            if(strlen($data['bgcolor']) === 0){
                $bgcolor = str_split($data['bgcolor']);

                //adição de cor padrão
                $data['bgcolor'] = '#fffafa';
                $userBgColor->update([
                    'content' => $data['bgcolor']
                ]);
            }else{
                $bgcolor = str_split($data['bgcolor']);

                if($bgcolor[0] != "#"){
                    array_unshift($bgcolor, '#');
                    $data['bgcolor'] = implode('', $bgcolor);
                    $userBgColor->update([
                        'content' => $data['bgcolor']
                    ]);                    
                }else{
                    $userBgColor->update([
                        'content' => $data['bgcolor']
                    ]);                    
                }
            }
            //textcolor
            $userTextColor = Setting::where('name', 'textcolor');
            if(strlen($data['textcolor']) === 0 ){
                $textcolor = str_split($data['textcolor']);

                //adição de cor padrão
                $data['textcolor'] = '#000000';
                $userTextColor->update([
                    'content' => $data['textcolor']
                ]);
            }else{
                $textcolor = str_split($data['textcolor']);


                if($textcolor[0] != "#"){
                    array_unshift($bgcolor, '#');
                    $data['textcolor'] = implode('', $textcolor);
                    $userTextColor->update([
                        'content' => $data['textcolor']
                    ]);    
                }else{
                    $userTextColor->update([
                        'content' => $data['textcolor']
                    ]);    
                }
            }
            return redirect()->route('settings');
            die();
        }
    }

    private function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['string', 'email', 'max:100'],
            'title' => ['max:100'],
            'subtitle' => ['max:100'],
            'bgcolor' => ['max:7'],
            'textcolor' => ['max:7']
        ]);
    }
}
