<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Tag;
use App\Http\Controllers\CommentsController as Comments;

class BlogController extends Controller
{
    public $meta = [
        'title' =>'Блог преподавателей Upbrain',
        'keywords' => 'Школа, Оборазование, ЕГЭ, ОГЭ, Образование сегодня',
        'description' => 'Блог - это крик души, в котором преподаватели рассказывают, о том как выживать в нынешней системе. Как выживать и находить выходы из печальной утопии.',
        'image' =>  'images/bg/header/img_header_prize.jpg'
    ];
    /**
     * Выводит список постов в блоге
     * @return object
     */

    public function showBlogList()
    {
        //Принимает класс BlogPresent который добавляет к каждому объекту $post, дополнительные свойства и методы
        //Потом через map формирует новые объекты

           /* $posts = Post::all()
            ->present(BlogPresent::class)->map(function($post){
                return
                    (object)[
                    'id' => $post->id,
                    'user_id' => $post->user_id,
                    'title' => $post->title,
                    'keywords' => $post->keywords,
                    'author' => $post->author(),
                    'description' => $post->description,
                    'cut' => $post->cut,
                    'text' => $post->text,
                    'image' => $post->image,
                    'alt'=> $post->alt,
                    'link' => $post->link,
                    'tags' => $post->arrayTags(),
                    'published' => $post->published,
                    'text_html' => $post->text_html,
                    'created_at' => $post->createdAt(),
                ];
            })->take(5);
            */

        $posts = Post::where('published' , 1)->paginate(5);

        $arrayNumbers = $this->pagePaginate($posts);

        return view('blog.list', [
            'posts' => $posts,
            'post' => (object)($this->meta),
            'arrayNumbers' => $arrayNumbers
        ]);
    }

    public function pagePaginate($posts){

        $arrayNumbers = [];

        $from = $posts->currentPage() - $posts->perPage();

        if($from < 1)
            $from = 1;

        $to = $posts->currentPage() + $posts->perPage();

        if($to > $posts->lastPage())
            $to = $posts->lastPage();

        for($i=$from; $i<=$to; $i++){
            array_push($arrayNumbers, $i);
        }

        return $arrayNumbers;
    }

    public function jsonBlogList(Request $request)
    {
        if($request->isXmlHttpRequest()){

            $posts = Post::paginate(5);
            return response()->json($posts);
        }
    }
    /**
     * Выводит пост
     * @param $id integer
     * @param $comments CommentsController
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showPost($id, Comments $comments)
    {
            $post = Post::where('id',  $id)->firstOrFail();
            $tags = $post->tags()->get();

            $data_comments = $comments->showComments($id);
            $comments = $data_comments[0];
            $count = $data_comments[1];

        return view('blog.post', [
            'post' => $post,
            'tags' => $tags,
            'comments' => $comments,
            'count' => $count
            ]);
    }
    /**
     * Выводит список постов по тегу
     * @param $id integer
     * @param $name
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showPostsForTag($name ,$id){

            $tag = Tag::find($id);
            //Используем модель Tag,
            // связываем обратной связью с постами,
            // получаем посты которые связаны с этой моделью через id тега
            $posts = $tag->posts;
            $count = $posts->count();

            return view('blog.list', ['count' => $count, 'posts' => $posts, 'post' => (object)$this->meta]);
    }

    /**
     * Выводит список постов автора
     * @param $id integer
     * @param $name
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showPostsOfAuthor($name ,$id){

        $posts = Post::whereUserId($id)->get();
        $count = $posts->count();
        return view('blog.list', ['count' => $count, 'posts' => $posts, 'post' => (object)$this->meta]);
    }

}
