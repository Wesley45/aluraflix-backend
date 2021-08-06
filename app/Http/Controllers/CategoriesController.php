<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Class CategoriesController
 * @package App\Http\Controllers
 */
class CategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $per_page = 5;
        if (!empty($request->get('per_page'))) {
            $per_page = intval($request->get('per_page'));
        }

        $categories = Categories::paginate($per_page);
        return response()->json($categories);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $rules = $this->validateCategoryCredentials();
        $messages = $this->categoryCredentialsValidationMessages();
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $category = Categories::create([
            'title' => trim($request->json('title')),
            'color' => trim($request->json('color'))
        ]);

        return response()->json($category, 201);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        $category = Categories::find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        return response()->json($category);
    }

    /**
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(int $id, Request $request)
    {
        $category = Categories::find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $rules = $this->validateCategoryCredentials();
        $messages = $this->categoryCredentialsValidationMessages();
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $category->title = trim($request->json('title'));
        $category->color = trim($request->json('color'));
        $category->save();

        return response()->json($category);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        $category = Categories::find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        Categories::destroy($id);

        return response()->json([], 204);
    }

    public function getVideos(int $id)
    {
        $category = Categories::with('videos')->where('id', $id)->first();

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        return response()->json($category);
    }

    /**
     * @return string[]
     */
    private function validateCategoryCredentials(): array
    {
        return [
            'title' => 'required|max:255',
            'color' => 'required|max:8'
        ];
    }

    /**
     * @retiiiurn string[]
     */
    private function categoryCredentialsValidationMessages(): array
    {
        return [
            'required' => 'The :attribute field is required.'
        ];
    }
}
