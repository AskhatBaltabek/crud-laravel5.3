<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Article;
use Validator;
use Response;
use Illuminate\Support\Facades\Input;

class ArticleController extends Controller
{
    public function __construct (Request $request)
    {
      $this->middleware(['auth', 'admin']);
    }

    public function index(){
      // we need to show all data from "blog" table
      $model_name = 'article';
      $blogs = Article::all();
      // show data to our view
      return view('blog.index', compact('blogs', 'model_name'));
    }

    // edit data function
    public function editItem(Request $req) {
      $blog = Article::find ($req->id);
      $blog->title = $req->title;
      $blog->body = $req->body;
      $blog->save();
      return response()->json($blog);
    }

    // add data into database
    public function addItem(Request $req) {
      $rules = array(
        'title' => 'required',
        'body' => 'required'
      );
      // for Validator
      $validator = Validator::make ( Input::all (), $rules );
      if ($validator->fails())
      return Response::json(array('errors' => $validator->getMessageBag()->toArray()));

      else {
        $blog = new Article();
        $blog->title = $req->title;
        $blog->body = $req->body;
        $blog->save();
        return response()->json($blog);
      }
    }
    // delete item
    public function deleteItem(Request $req) {
      Article::find($req->id)->delete();
      return response()->json();
    }
}
