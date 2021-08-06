<?php

namespace App\Http\Controllers;

use App\Models\Videos;
use Illuminate\Http\{Request, Response};
use Illuminate\Support\Facades\Validator;

class VideosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $search = $request->query('search');
        $per_page = 5;

        if (!empty($request->get('per_page'))) {
            $per_page = intval($request->get('per_page'));
        }

        if (!empty($search)) {
            $titleSearch = "%$search%";
            $videos = Videos::where('title', 'like', $titleSearch)
                ->paginate($per_page);
        } else {
            $videos = Videos::paginate($per_page);
        }

        return response()->json($videos);
    }

    public function store(Request $request)
    {
        $rules = $this->validateVideoCredentials();
        $messages = $this->videoCredentialsValidationMessages();
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $category_id = trim($request->json('categoryId'));
        $categoryId = !empty($category_id) ? $category_id : 1;

        $video = Videos::create([
            'categoryId' => $categoryId,
            'title' => trim($request->json('title')),
            'description' => trim($request->json('description')),
            'url' => trim($request->json('url')),
        ]);

        return response()->json($video, 201);
    }

    public function show(int $id)
    {
        $video = Videos::find($id);

        if (!$video) {
            return response()->json(['message' => 'Video not found'], 404);
        }

        return response()->json($video);
    }

    public function update(int $id, Request $request)
    {
        $video = Videos::find($id);

        if (!$video) {
            return response()->json(['message' => 'Video not found'], 404);
        }

        $rules = $this->validateVideoCredentials();
        $messages = $this->videoCredentialsValidationMessages();
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $category_id = trim($request->json('categoryId'));
        $categoryId = !empty($category_id) ? $category_id : 1;

        $video->categoryId = $categoryId;
        $video->title = $request->json('title');
        $video->description = $request->json('description');
        $video->url = $request->json('url');
        $video->save();

        return response()->json($video);
    }

    public function destroy(int $id)
    {
        $video = Videos::find($id);

        if (!$video) {
            return response()->json(['message' => 'Video not found'], 404);
        }

        Videos::destroy($id);

        return response()->json([], 204);
    }

    /**
     * @return string[]
     */
    private function validateVideoCredentials(): array
    {
        return [
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'url' => 'required|url|max:255',
        ];
    }

    /**
     * @return string[]
     */
    private function videoCredentialsValidationMessages(): array
    {
        return [
            'required' => 'The :attribute field is required.',
        ];
    }
}
