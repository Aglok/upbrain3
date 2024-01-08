<?php

namespace App\Http\Controllers;


use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;


class CommentsController
{
    /**
         * Выводит список комментариев по id страницы
         * @param $post_id integer
         * @return array Collection
     */
    public function showComments(int $post_id){

        $post = Post::where('id', $post_id)->first();
        $count = 0;

        if($post){
            $comments = $post->comments;
            $count = $comments->count();
            $commentsGroupById = $comments->groupBy('parent_id');
        }else{
            $commentsGroupById = false;
        }
        return [$commentsGroupById, $count];
    }

    /**
     * Сохраняет комментарии в БД
     * @param Request $request
     * @return RedirectResponse
     */
    public function saveComment(Request $request){
//        if($request->ajax()) {
            //dd($request->all());
            Comment::create($request->all());
            return redirect()->back();
//        }
    }
}