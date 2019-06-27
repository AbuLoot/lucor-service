<?php

namespace App\Http\Controllers\Joystick;

use Illuminate\Http\Request;

use DB;
use Image;
use Storage;
use Validator;

use App\Http\Controllers\Controller;
use App\Mode;
use App\Option;
use App\Comment;
use App\Company;
use App\Product;
use App\Category;
use App\ImageTrait;

class ProductController extends Controller
{
    use ImageTrait;

    public function index()
    {
        $products = Product::orderBy('updated_at','desc')->paginate(50);
        $categories = Category::get()->toTree();
        $modes = Mode::all();

        // $categories_part = Category::whereIn('slug', ['gadjets', 'life-style'])->orderBy('sort_id')->get();

        // $ids = collect();
        // $ids = $categories_part->descendants()->pluck('id');

        // dd($ids);
        // foreach ($categories_part as $key => $category_item) {

        //     if ($category_item->children && count($category_item->children) > 0) {

        //         $ids[$key] = $category_item->children->pluck('id');
        //     }
        // }

        // $group_ids = $ids->collapse();
        // dd($group_ids);


        return view('joystick-admin.products.index', ['categories' => $categories, 'products' => $products, 'modes' => $modes]);
    }

    public function search(Request $request)
    {
        $text = trim(strip_tags($request->text));

        $products = Product::search($text)->paginate(50);
        $modes = Mode::all();

        $products->appends([
            'text' => $request->text,
        ]);

        return view('joystick-admin.products.found', compact('text', 'modes', 'products'));
    }

    public function priceForm()
    {
        $categories = Category::get()->toTree();

        return view('joystick-admin.products.price-edit', ['categories' => $categories]);
    }

    public function categoryProducts($id)
    {
        $category = Category::find($id);
        $categories = Category::get()->toTree();
        $products = Product::where('category_id', $category->id)->orderBy('created_at')->paginate(50);
        $modes = Mode::all();

        return view('joystick-admin.products.index', ['category' => $category, 'categories' => $categories, 'products' => $products, 'modes' => $modes]);
    }

    public function actionProducts(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'products_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator);
        }

        if (is_numeric($request->action)) {
            Product::whereIn('id', $request->products_id)->update(['status' => $request->action]);
        }
        else {
            $mode = Mode::where('slug', $request->action)->first();
            $products = Product::whereIn('id', $request->products_id)->get();

            foreach ($products as $product) {
                $product->modes()->toggle($mode->id);
            }
        }

        return response()->json(['status' => true]);
    }

    public function create()
    {
        $categories = Category::get()->toTree();
        $companies = Company::get();
        $options = Option::orderBy('sort_id')->get();
        $grouped = $options->groupBy('data');
        $modes = Mode::all();

        return view('joystick-admin.products.create', ['modes' => $modes, 'categories' => $categories, 'companies' => $companies, 'options' => $options, 'grouped' => $grouped]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:2|max:80|unique:products',
            'category_id' => 'required|numeric',
            // 'images' => 'mimes:jpeg,jpg,png,svg,svgs,bmp,gif',
        ]);

        $category = Category::findOrFail($request->category_id);
        $introImage = null;
        $images = [];
        $dirName = $category->id.'/'.time();
        Storage::makeDirectory('img/products/'.$dirName);

        if ($request->hasFile('images')) {

            foreach ($request->file('images') as $key => $image)
            {
                if (isset($image)) {

                    $imageName = 'image-'.$key.uniqid().'-'.str_slug($request->title).'.'.$image->getClientOriginalExtension();

                    // Creating preview image
                    if ($key == 0) {
                        $this->cropImage($image, 370, 370, '/img/products/'.$dirName.'/preview-'.$imageName, 100);
                        $introImage = 'preview-'.$imageName;
                    }

                    // $watermark = Image::make('img/watermark.png');

                    // Storing original images
                    // $image->storeAs('/img/products/'.$dirName, $imageName);
                    $this->cropImage($image, 800, 800, '/img/products/'.$dirName.'/'.$imageName, 90);

                    // Creating present images
                    $this->cropImage($image, 370, 370, '/img/products/'.$dirName.'/present-'.$imageName, 100);

                    // Creating mini images
                    // $this->resizeImage($image, 80, 100, '/img/products/'.$dirName.'/mini-'.$imageName, 100);

                    $images[$key]['image'] = $imageName;
                    $images[$key]['present_image'] = 'present-'.$imageName;
                    // $images[$key]['mini_image'] = 'mini-'.$imageName;
                }
            }
        }

        // Saving Background
        if ($request->hasFile('background')) {

            $backgroundName = $request->background->getClientOriginalName();

            $request->background->storeAs('img/products/'.$dirName, $backgroundName);
        }

        $product = new Product;
        $product->sort_id = ($request->sort_id > 0) ? $request->sort_id : $product->count() + 1;
        $product->category_id = $request->category_id;
        $product->slug = str_slug($request->title);
        $product->title = $request->title;
        $product->title_extra = $request->title_extra;
        $product->direction = $request->direction;
        $product->color = $request->color;
        $product->background = (isset($backgroundName)) ? $backgroundName : '';
        $product->company_id = $request->company_id;
        $product->barcode = $request->barcode;
        $product->price = $request->price;
        $product->days = $request->days;
        $product->count = $request->count;
        // $product->condition = $request->condition;
        // $product->presense = $request->presense;
        $product->meta_description = $request->meta_description;
        $product->description = $request->description;
        $product->characteristic = $request->characteristic;
        $product->image = $introImage;
        $product->images = serialize($images);
        $product->path = $dirName;
        $product->lang = $request->lang;
        $product->mode = (isset($request->mode)) ? $request->mode : 0;
        $product->status = $request->status;
        $product->save();

        if ( ! is_null($request->modes_id)) {
            $product->modes()->attach($request->modes_id);
        }

        if ( ! is_null($request->options_id)) {
            $product->options()->attach($request->options_id);
        }

        return redirect('admin/products')->with('status', 'Товар добавлен!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::get()->toTree();
        $companies = Company::get();
        $options = Option::orderBy('sort_id')->get();
        $grouped = $options->groupBy('data');
        $modes = Mode::all();

        return view('joystick-admin.products.edit', ['modes' => $modes, 'product' => $product, 'categories' => $categories, 'companies' => $companies, 'options' => $options, 'grouped' => $grouped]);
    }

    public function editPage($id)
    {
        $product = Product::findOrFail($id);

        return view('joystick-admin.products.page', ['product' => $product]);
    }

    public function saveHtml($id)
    {
        $product = Product::find($id);
        $product->description = $_GET['html'];
        $product->save();

        return response()->json($product->title);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|min:2|max:80',
            'category_id' => 'required|numeric',
        ]);

        $product = Product::findOrFail($id);

        $backgroundName = $product->background;
        $images = unserialize($product->images);
        $dirName = $product->path;

        if ( ! file_exists('img/products/'.$product->category_id) OR empty($product->path)) {
            $dirName = $product->category->id.'/'.time();
            Storage::makeDirectory('img/products/'.$dirName);
            $product->path = $dirName;
        }

        if ($request->hasFile('images')) {

            $introImage = null;

            foreach ($request->file('images') as $key => $image)
            {
                if (isset($image)) {

                    $imageName = 'image-'.$key.uniqid().'-'.str_slug($request->title).'.'.$image->getClientOriginalExtension();

                    // Creating preview image
                    if ($key == 0) {

                        if ($product->image != NULL AND $product->image != 'no-image-middle.png' AND file_exists('img/products/'.$product->path.'/'.$product->image)) {
                            Storage::delete('img/products/'.$product->path.'/'.$product->image);
                        }

                        $this->cropImage($image, 370, 370, '/img/products/'.$dirName.'/preview-'.$imageName, 100);
                        $introImage = 'preview-'.$imageName;
                    }

                    // $watermark = Image::make('img/watermark.png');

                    // Storing original images
                    $this->cropImage($image, 800, 800, '/img/products/'.$dirName.'/'.$imageName, 90);

                    // Creating present images
                    $this->cropImage($image, 370, 370, '/img/products/'.$dirName.'/present-'.$imageName, 100);

                    // Creating mini images
                    // $this->resizeImage($image, 80, 100, '/img/products/'.$dirName.'/mini-'.$imageName, 100);

                    if (isset($images[$key])) {

                        if ($images[$key]['image'] != 'no-image-middle.png') {
                            Storage::delete([
                                'img/products/'.$product->path.'/'.$images[$key]['image'],
                                'img/products/'.$product->path.'/'.$images[$key]['present_image'],
                                // 'img/products/'.$product->path.'/'.$images[$key]['mini_image']
                            ]);
                        }

                        $images[$key]['image'] = $imageName;
                        $images[$key]['present_image'] = 'present-'.$imageName;
                        // $images[$key]['mini_image'] = 'mini-'.$imageName;
                    }
                    else {
                        $images[$key]['image'] = $imageName;
                        $images[$key]['present_image'] = 'present-'.$imageName;
                        // $images[$key]['mini_image'] = 'mini-'.$imageName;
                    }
                }
            }

            $images = array_sort_recursive($images);
        }

        // Resave background
        if ($request->hasFile('background')) {

            if (file_exists('img/products/'.$product->path.'/'.$product->background)) {
                Storage::delete('img/products/'.$product->path.'/'.$product->background);
            }

            $backgroundName = $request->background->getClientOriginalName();

            $request->background->storeAs('img/products/'.$product->path, $backgroundName);
        }

        // Change directory for new category
        if ($product->category_id != $request->category_id AND file_exists('img/products/'.$product->path)) {

            $dirName = $request->category_id.'/'.time();
            Storage::move('img/products/'.$product->path, 'img/products/'.$dirName);
            $product->path = $dirName;
        }

        // Delete images
        if (isset($request->remove_images)) {

            foreach ($request->remove_images as $key => $value) {

                if (!isset($request->images[$value])) {

                    if ($product->image === 'preview-'.$images[$value]['image']) {

                        Storage::delete('img/products/'.$product->path.'/'.$product->image);
                        $introImage = 'no-image-middle.png';
                    }

                    Storage::delete([
                        'img/products/'.$product->path.'/'.$images[$value]['image'],
                        'img/products/'.$product->path.'/'.$images[$value]['present_image'],
                        // 'img/products/'.$product->path.'/'.$images[$value]['mini_image']
                    ]);

                    unset($images[$value]);
                }
            }

            $images = array_sort_recursive($images);
        }

        $product->sort_id = ($request->sort_id > 0) ? $request->sort_id : $product->count() + 1;
        $product->category_id = $request->category_id;
        $product->slug = str_slug($request->title);
        $product->title = $request->title;
        $product->title_extra = $request->title_extra;
        $product->direction = $request->direction;
        $product->color = $request->color;
        $product->background = $backgroundName;
        $product->company_id = $request->company_id;
        $product->barcode = $request->barcode;
        $product->price = $request->price;
        $product->days = $request->days;
        $product->count = $request->count;
        // $product->condition = $request->condition;
        // $product->presense = $request->presense;
        $product->meta_description = $request->meta_description;
        $product->description = $request->description;
        $product->characteristic = (isset($request->characteristic)) ? $request->characteristic : '';
        if (isset($introImage)) $product->image = $introImage;
        $product->images = serialize($images);
        $product->lang = $request->lang;
        $product->mode = (isset($request->mode)) ? $request->mode : 0;
        $product->status = $request->status;
        $product->save();

        if ( ! is_null($request->modes_id)) {
            $product->modes()->sync($request->modes_id);
        }

        if ( ! is_null($request->options_id)) {
            $product->options()->sync($request->options_id);
        }

        return redirect('admin/products')->with('status', 'Товар обновлен!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if (! empty($product->images)) {

            $images = unserialize($product->images);

            foreach ($images as $image)
            {
                if ($product->image != NULL AND $product->image != 'no-image-middle.png' AND file_exists('img/products/'.$product->path.'/'.$product->image)) {
                    Storage::delete('img/products/'.$product->path.'/'.$product->image);
                }

                if ($image['image'] != 'no-image-middle.png') {
                    Storage::delete([
                        'img/products/'.$product->path.'/'.$image['image'],
                        'img/products/'.$product->path.'/'.$image['present_image'],
                        // 'img/products/'.$product->path.'/'.$image['mini_image']
                    ]);
                }
            }

            Storage::deleteDirectory('img/products/'.$product->path);
        }

        $product->delete();

        return redirect('/admin/products');
    }

    public function comments($id)
    {
        $product = Product::findOrFail($id);

        return view('joystick-admin.products.comments', ['product' => $product]);
    }

    public function destroyComment($id)
    {
        $comment = Comment::find($id);
        $comment->delete();

        return redirect('/admin/products/'.$comment->parent_id.'/comments')->with('status', 'Запись удалена!');
    }
}