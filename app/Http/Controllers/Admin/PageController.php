<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::paginate(10);

        return view('Admin.Pages.index', [
            'pages' => $pages
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.Pages.create');

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
            'title', 'body'
       ]);

       $data['slug'] = Str::slug($data['title'], '-');
       $validator = Validator::make($data, [
           'title' => ['required', 'string', 'max:100'],
           'body' => ['string'],
           'slug' => ['required','string', 'max:100', 'unique:pages'] //o validador não permite criar uma pág com algum validador que já tenha.
       ]);

       if($validator->fails()){
            return redirect()->route('pages.create')->withErrors($validator)->withInput();
       }else{
           $page = new Page();

           $page->title = $data['title'];
           $page->slug = $data['slug'];
           $page->body = $data['body'];
           $page->save();

           return redirect()->route('pages.index');
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
        $pageEdit = Page::find($id);
        if($pageEdit){
            return view('Admin.Pages.edit', [
                'pageEdit' => $pageEdit
            ]);
        }else{
            return redirect()->route('pages.index');
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
            'title', 'body'
        ]);
       
        $page = Page::find($id);

        if($page){
            $validator = null;
            if($data['title'] != $page->title){
                $slug = Str::slug($data['title'], '-');
                if($slug != $page->slug){
                    $data['slug'] = $slug;
                }
                $validator = Validator::make($data, [
                    'title' => ['required', 'string', 'max:100'],
                    'body' => ['string'],
                    'slug' => ['required','string', 'max:100', 'unique:pages'] //o validador não permite criar uma pág com algum validador que já tenha.
                ]);
            }else{
                $validator = Validator::make($data, [
                    'title' => ['required', 'string', 'max:100'],
                    'body' => ['string'],
                    ]);
                $data['slug'] = $page->slug;
                }

            if($validator->fails()){
                print_r('Validator');
                return redirect()->route('pages.edit', ['page' => $id])->withErrors($validator);
                die();
            }else{
                $page->title = mb_convert_case($data['title'], MB_CASE_TITLE, 'UTF-8');

                $page->body = $data['body'];

                if($data['slug'] != $page->slug){
                    $page->slug = $data['slug'];
                }

                $page->save();

                return redirect()->route('pages.index');
                die();
            }   

        }else{
            return redirect()->route('pages.index')->with('error', 'Falha ao editar a página' . $page->title);
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
        $data = Page::find($id);
        if($data){
            $data->delete();

            return redirect()->route('pages.index');
        }else{
            return redirect()->route('pages.index');
        }
        

    }
}
