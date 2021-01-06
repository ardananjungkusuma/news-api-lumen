<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::get();

        return response()->json($news, 200);
    }

    public function show($slug)
    {
        $news = News::where('slug', $slug)->first();

        if ($news) {
            return response()->json($news, 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => "News not found"
            ], 404);
        }
    }

    public function add(Request $request)
    {
        $news = News::create([
            'users_id' => $request->users_id,
            'slug' => Str::slug($request->title),
            'title' => $request->title,
            'body' => $request->body
        ]);

        if ($news) {
            return response()->json([
                'status' => true,
                'message' => 'News successfully created',
                'data' => $news
            ], 201);
        } else {
            return response()->json([
                'status' => false,
                'message' => "News unsuccessfully created"
            ], 400);
        }
    }

    public function edit(Request $request, $slug)
    {
        $news = News::where('slug', $slug)
            ->update([
                "title" => $request->title,
                "slug" => Str::slug($request->title),
                "body" => $request->body
            ]);

        if ($news) {
            return response()->json([
                'status' => true,
                'message' => 'News successfully edited',
                'data' => $news
            ], 201);
        } else {
            return response()->json([
                'status' => false,
                'message' => "News unsuccessfully edited"
            ], 400);
        }
    }

    public function delete($slug)
    {
        $news = News::where('slug', $slug)->first()->delete();

        if ($news) {
            return response()->json([
                'status' => true,
                'message' => 'News successfully deleted'
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => "News unsuccessfully deleted"
            ], 400)->header('Content-type', 'application/json');
        }
    }
}
