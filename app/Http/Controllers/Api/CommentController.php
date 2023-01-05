<?php

namespace App\Http\Controllers\Api;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $comments = CommentResource::collection(Comment::get());
        return $this->apiResponse($comments,'ok',200);
    }


    public function show($id)
    {
        $comment = Comment::find($id);
        if($comment){
            return $this->apiResponse(new CommentResource($comment),'ok',200);
        }
        return $this->apiResponse(null,'The Comment Not Found',404);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'comment' => 'required',
            'post_id' => 'required',
            'user_id' => 'required',
        ]);

        if($validator->fails())
        {
            return $this->apiResponse(null,$validator->errors(),404);
        }

        $comment= Comment::create($request->all());
        if($comment){
            return $this->apiResponse(new CommentResource($comment),'The Comment Save Success',201);
        }
        return $this->apiResponse(null,'The Comment Not Save',404);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'comment' => 'required',
            'post_id' => 'required',
            'user_id' => 'required',
        ]);

        if($validator->fails())
        {
            return $this->apiResponse(null,$validator->errors(),404);
        }

        $comment= Comment::find($id);

        if(!$comment){
            return $this->apiResponse(null,'The Comment Not Found',404);
        }

        $comment->update($request->all());

        if($comment){
            return $this->apiResponse(new CommentResource($comment),'The Comment Update Success',201);
        }
    }

    public function destroy($id)
    {
        $comment= Comment::find($id);

        if(!$comment){
            return $this->apiResponse(null,'The Comment Not Found',404);
        }

        $comment->delete($id);

        if($comment){
            return $this->apiResponse(new CommentResource($comment),'The Comment Delete Success',201);
        }
    }
}
