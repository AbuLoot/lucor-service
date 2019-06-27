<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use URL;

use App\Page;
use App\News;
use App\Comment;

class NewsController extends Controller
{
    public function news()
    {
        $newsCategories = Page::where('slug', 'news')->get()->toTree();
        $news = News::orderBy('created_at', 'desc')->paginate(10);

        return view('pages.news', compact('news', 'newsCategories'));
    }

    public function newsCategory($page)
    {
        $newsCategory = Page::where('slug', $page)->first();
        $newsCategories = Page::where('slug', 'news')->get()->toTree();
        $news = News::where('page_id', $newsCategory->id)->paginate(10);

        return view('pages.news-category', compact('newsCategory', 'news', 'newsCategories'));
    }

    public function newsSingle($page)
    {
        $newsSingle = News::where('slug', $page)->first();

        return view('pages.news-single', compact('newsSingle'));
    }

    public function saveComment(Request $request)
    {
        $this->validate($request, [
            'comment' => 'required|min:5|max:500',
        ]);

        $url = explode('news/', URL::previous());
        $newsSingle = News::where('slug', $url[1])->first();

        if ($request->id == $newsSingle->id) {
            $comment = new Comment;
            $comment->parent_id = $request->id;
            $comment->parent_type = 'App\News';
            $comment->name = \Auth::user()->name;
            $comment->email = \Auth::user()->email;
            $comment->comment = $request->comment;
            // $comment->stars = (int) $request->stars;
            $comment->save();
        }

        if ($comment) {
            return redirect()->back()->with('status', 'Отзыв добавлен!');
        }
        else {
            return redirect()->back()->with('status', 'Ошибка!');
        }
    }
}
