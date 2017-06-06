<?php

namespace App\Http\Controllers\Web;

use App\Helpers\Fitters\ArticleFilters;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{

    function __construct()
    {
        $this->middleware('auth')->except(['index','show']);
    }

    public function index(Category $category, ArticleFilters $fitters)
    {
        $articles = $this->getArticles($category,$fitters);

        return view('articles.index',compact('articles'));
    }

    protected function getArticles(Category $category, ArticleFilters $fitters)
    {
        $article = Article::withCount('comments')->latest()->filter($fitters);

        if ($category->exists){
            $article->where('category_id',$category->id);
        }
        return $article->paginate(10);

    }

    public function show($category,Article $article)
    {

        $article->load('comments');

        return view('articles.show',compact('article'));

    }

    public function create()
    {
        return view('articles.create');
    }



//    public function store(Request $request)
//    {
//
//        return $request->all();
//
//    }

    public function  destroy(Article $article)
    {
        $this->authorize('update',$article);

        $article->delete();

        $article->comments->each->delete();

        alert('文章删除成功','success');

        return redirect('/');

        dd($article);

    }

}