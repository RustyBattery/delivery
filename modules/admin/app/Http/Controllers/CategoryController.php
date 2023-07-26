<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $response = [
            'categories' => Category::paginate(5),
        ];
        return view('categories.index', $response);
    }

    public function store(CategoryRequest $request)
    {
        $data = $request->validated();
        $category = Category::create($data);
        return back();
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $data = $request->validated();
        $category->update($data);
        return back();
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return back();
    }
}
