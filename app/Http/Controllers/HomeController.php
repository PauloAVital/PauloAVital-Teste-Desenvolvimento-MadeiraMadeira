<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use DataTables;
use PhpParser\Node\Expr\Cast\Array_;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $teste = 123;
        return view('home', compact('teste'));
    }

    public function tag(Request $request)
    {      
        $client = new Client();

        $response = $client->request('GET', 'https://api.github.com/users/pauloavital/repos');
        $statusCode = $response->getStatusCode();
        $body = $response->getBody()->getContents();
        $retGithub = json_decode($body, true);
        
//dd($retGithub);
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
                    $btn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        //return view('admin.pages.tags.index', compact('teste2'));
        return view('admin.pages.tags.index');
    }
}
