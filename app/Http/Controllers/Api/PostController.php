<?php

namespace App\Http\Controllers\Api;


use App\Models\Post;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\EditPostRequest;
use Exception;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        try {

            $query = Post::query();
            $perpage = 1;
            $page = $request->input('page', 1);
            $search = $request->input('search');

            if ($search) {
                $query->whereRaw("titre LIKE '%" . $search . "%'");
            }

            $total = $query->count();

            $result = $query->offset(($page - 1) * $perpage)->limit($perpage)->get();
            return response()->json([
                'status_code' => 200,
                'status_message' => 'Le posts ont été récupéré',
                'current_page' => $page,
                'last_page' => ceil($total / $perpage),
                'items' => $result
                //'data' => Post::all()
            ]);
        } catch (Exception $e) {

            return response()->json($e);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePostRequest $request)
    {
        try {
            $post = new Post();
            $post->titre = $request->titre;
            $post->description = $request->description;
            $post->user_id = auth()->user()->id;
            $post->save();

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Le post a été ajouté',
                'data' => $post
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditPostRequest $request, Post $post)
    {
        try {
            $post->titre = $request->titre;
            $post->description = $request->description;
            if ($post->user_id == auth()->user()->id) {
                $post->save();
            } else {
                return response()->json([
                    'status_code' => 422,
                    'status_message' => 'Vous n\'etes pas l\'auteur',
                ]);
            }


            return response()->json([
                'status_code' => 200,
                'status_message' => 'Le post a été modifié',
                'data' => $post
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Post $post)
    {
        try {
            if ($post->user_id == auth()->user()->id) {
                $post->delete();
            } else {
                return response()->json([
                    'status_code' => 422,
                    'status_message' => 'Vous n\'etes pas l\'auteur suppression non autorisé',
                ]);
            }


            return response()->json([
                'status_code' => 200,
                'status_message' => 'Le post a été supprimé',
                'data' => $post
            ]);
        } catch (Exception $e) {

            return response()->json($e);
        }
    }
}
