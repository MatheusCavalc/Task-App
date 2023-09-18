<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function __construct(LayoutController $layoutController)
    {
        $this->middleware(function ($request, $next) use ($layoutController) {
            $layoutController->shareCommonData();
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('App/Category/Index', [
            'categories' => Category::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('App/Category/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->request->add(['user_id' => auth()->user()->id]);

        $data = $request->validate([
            'user_id' => 'required',
            'name' => 'required|max:255',
        ]);

        Category::create($data);

        return redirect('/categories')->with('message', 'Category created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return Inertia::render('App/Category/Edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->request->add(['user_id' => auth()->user()->id]);

        $data = $request->validate([
            'user_id' => 'required',
            'name' => 'required|max:255',
        ]);

        $category->update($data);

        return redirect('/categories')->with('message', 'Category updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->back()
                ->with('message', 'Category delete');
    }
}
