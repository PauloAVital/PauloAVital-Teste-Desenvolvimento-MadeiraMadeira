<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use DataTables;
use App\User;

class HomeController extends Controller
{
    private $objuser;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->objuser = new User();
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {        
        return view('home');
    }

    public function search()
    {      
        //return view('admin.pages.tags.index', compact('teste2'));
        $users = $this->objuser->all();
        //dd($users);
        return view('admin.pages.search.index', compact('users'));
    }

    public function searchUser(Request $request) {
        
        $request->validate([
	        'name' => 'required'
	    ], [
	        'name.required' => 'Preencha o Nome'
        ]);

        $name = ($request->query('name') != '') ? $request->query('name'): 'pauloavital';
        
        $client = new Client();

        $response = $client->request('GET', 'https://api.github.com/users/'.$name.'/repos');
        $statusCode = $response->getStatusCode();
        $body = $response->getBody()->getContents();
        $retGithub = json_decode($body, true);
        
        $response = array();
        foreach ($retGithub as $result) {
            $elements = array(
                    "name" => $result['name'], 
                    "description" => $result['description'],
                    "tag_url" => $result['tags_url'],
                    "language" => $result['language']
                );
            array_push($response, $elements);
        }

        if ($request->ajax()) {
            return DataTables::of($response)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" class="edit btn btn-info btn-sm">tag</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.pages.search.index');
    }

    public function searchTerm(Request $request) {
        $request->validate([
	        'termo' => 'required'
	    ], [
	        'termo.required' => 'Preencha o Campo'
        ]);
        
        $termo = ($request->query('termo') != '') ? $request->query('termo'): 'angular';
        $language = ($request->query('language') != '') ? $request->query('language'): 'PHP';       
        $tipo = ($request->query('tipo') == 0) ? 'date' : 'star';
        $order = ($request->query('order') == 0) ? 'asc' : 'desc';

        $client = new Client();

        $response = $client->request('GET', 'https://api.github.com/search/repositories?q='.$termo.'+language:'.$language.'&sort='.$tipo.'&order='.$order.'');
        $statusCode = $response->getStatusCode();
        $body = $response->getBody()->getContents();
        $retGithub = json_decode($body, true);
        
        $response = array();
       
        foreach ($retGithub['items'] as $result) {
            
            $elements = array(
                    "name" => $result['name'], 
                    "description" => $result['description'],
                    "tag_url" => $result['html_url'],
                    "language" => $result['language']
                );
            array_push($response, $elements);
        }

        if ($request->ajax()) {
            return DataTables::of($response)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" id="buttonLocalizar" class="edit btn btn-info btn-sm" onclick="cadastrar()">tag</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.pages.search.index');
    }
}
