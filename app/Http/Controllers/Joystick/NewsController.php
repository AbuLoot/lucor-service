<?php

namespace App\Http\Controllers\Joystick;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Page;
use App\News;
use App\ImageTrait;

use Storage;

class NewsController extends Controller
{
    use ImageTrait;

    public function index()
    {
        $news = News::orderBy('sort_id')->paginate(50);

        return view('joystick-admin.news.index', compact('news'));
    }

    public function create()
    {
        $pages = Page::orderBy('sort_id')->get()->toTree();

        return view('joystick-admin.news.create', ['pages' => $pages]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:2|max:80|unique:news',
        ]);

        $news = new News;

        $news->sort_id = ($request->sort_id > 0) ? $request->sort_id : $news->count() + 1;
        $news->page_id = $request->page_id;
        $news->slug = (empty($request->slug)) ? str_slug($request->title) : $request->slug;
        $news->title = $request->title;
        $news->headline = $request->headline;
        $news->video = $request->headline;

        if ($request->hasFile('image')) {

            $imageName = $request->image->getClientOriginalExtension();

            // Creating present images
            $this->resizeImage($request->image, 370, 240, '/img/news/present-'.$imageName, 100);

            // Storing original images
            $this->resizeImage($request->image, 1024, 768, '/img/news/'.$imageName, 90);

            $news->image = $imageName;
        }

        $news->title_description = $request->title_description;
        $news->meta_description = $request->meta_description;
        $news->content = $request->content;
        $news->lang = $request->lang;
        $news->status = ($request->status == 'on') ? 1 : 0;
        $news->save();

        return redirect('/admin/news')->with('status', 'Запись добавлена.');
    }

    public function edit($id)
    {
        $news = News::findOrFail($id);
        $pages = Page::orderBy('sort_id')->get()->toTree();

        return view('joystick-admin.news.edit', compact('news', 'pages'));
    }

    public function update(Request $request, $id)
    {    	
        $this->validate($request, [
            'title' => 'required|min:2|max:80',
        ]);

        $news = News::findOrFail($id);
        $news->sort_id = ($request->sort_id > 0) ? $request->sort_id : $news->count() + 1;
        $news->page_id = $request->page_id;
        $news->slug = (empty($request->slug)) ? str_slug($request->title) : $request->slug;
        $news->title = $request->title;
        $news->headline = $request->headline;
        $news->video = $request->video;

        if ($request->hasFile('image')) {

            if ($news->image != NULL AND file_exists('img/news/'.$news->image)) {
                Storage::delete('img/news/present-'.$news->image);
                Storage::delete('img/news/'.$news->image);
            }

            $imageName = $request->image->getClientOriginalName();

            // Creating present images
            $this->resizeImage($request->image, 370, 240, '/img/news/present-'.$imageName, 100);

            // Storing original images
            $this->resizeImage($request->image, 1024, 768, '/img/news/'.$imageName, 90);

            $news->image = $imageName;
        }

        $news->title_description = $request->title_description;
        $news->meta_description = $request->meta_description;
        $news->content = $request->content;
        $news->lang = $request->lang;
        $news->status = ($request->status == 'on') ? 1 : 0;
        $news->save();

        return redirect('/admin/news')->with('status', 'Запись обновлена.');
    }

    public function destroy($id)
    {
        $news = News::find($id);

        if (file_exists('img/news/'.$news->image)) {
            Storage::delete('img/news/present-'.$news->image);
            Storage::delete('img/news/'.$news->image);
        }

        $news->delete();

        return redirect('/admin/news')->with('status', 'Запись удалена.');
    }
}