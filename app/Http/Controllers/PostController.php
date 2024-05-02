<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\SearchFormRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostRessource;
use App\Models\Post;
use Exception;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SearchFormRequest $request)
    {


        try {
            //Prepare un requete sql
            $query = Post::query();
            $perPage = 5;

            //Récupere la liste des articles correspondant au paramètre poassé dans l'URL
            if ($request->has('search')) {
                $search = $request->input('search');
                $query->where("title", "LIKE", "%$search%");
            }


            //Système de pagination
            $result = $query->orderBy('updated_at', 'desc')->paginate($perPage);

            //Retourne une reponse pour informer le client(react, angular...)
            return response()->json([
                'status' => 200,
                'message' => 'Liste des article',
                'currentPage' => $result->currentPage(),
                'lastPage' => $result->lastPage(),
                'items' => PostRessource::collection($result->items()),
            ]);
        } catch (Exception $e) {
            //Retourne une reponse pour informer le client(react, angular...) en cas d'erreur
            return response()->json($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePostRequest $request)
    {
        try {
            $post = new Post();

            $post->title = $request->title;
            $post->user_id = auth()->user()->id;
            $post->description = $request->description;
            $post->save();

            //Retourne une reponse pour informer le client(react, angular...)
            return response()->json([
                'status' => 200,
                'message' => 'Le post a été crée avec success',
                'data' => new PostRessource($post),
            ]);
        } catch (Exception $e) {
            //Retourne une reponse pour informer le client(react, angular...) en cas d'erreur
            return response()->json($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        try {
            //Retourne une reponse pour informer le client(react, angular...)
            return response()->json([
                'status' => 200,
                'message' => 'Le post a été récupéré avec success',
                'data' => new PostRessource($post),
            ]);
        } catch (Exception $e) {
            //Retourne une reponse pour informer le client(react, angular...) en cas d'erreur
            return response()->json($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        try {
            $post->title = $request->title;
            $post->description = $request->description;
            $post->save();

            //Retourne une reponse pour informer le client(react, angular...)
            return response()->json([
                'status' => 200,
                'message' => 'Le post a été modifié avec success',
                'data' => new PostRessource($post),
            ]);
        } catch (Exception $e) {
            //Retourne une reponse pour informer le client(react, angular...) en cas d'erreur
            return response()->json($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        try {
            if ($post->user_id === auth()->user()->id) {
                $post->delete();
            } else {
                //Retourne une reponse pour informer le client(react, angular...)
                return response()->json([
                    'status' => 422,
                    'message' => "Vous n'êtes pas l'auteur de ce post",
                ]);
            }

            //Retourne une reponse pour informer le client(react, angular...)
            return response()->json([
                'status' => 200,
                'message' => 'Le post a été supprimé avec success',
                'data' => new PostRessource($post),
            ]);
        } catch (Exception $e) {
            //Retourne une reponse pour informer le client(react, angular...) en cas d'erreur
            return response()->json($e->getMessage());
        }
    }
}
