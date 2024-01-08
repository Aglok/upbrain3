<?php

namespace App\Http\Controllers;

use App\Http\Resources\ExamResultResource;
use App\Models\ExamAnswer;
use App\Models\ExamResult;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use function request;

class ExamsController extends Controller
{
    /**
     * @param int $id
     * @return JsonResponse|void
     */
    public function examResults(int $id){
        if(request()->ajax()){
            $results = ExamResult::find($id);
            $results->exam_answers;
            return response()->json($results);
        }
    }

    /**
     * @param int $id
     * @return JsonResponse|void
     */
    public function examAnswers(int $id){
        if(request()->ajax()){
            $results = ExamAnswer::find($id);
            return response()->json($results);
        }
    }

    /**
     * @param int|null $id
     * @return AnonymousResourceCollection
     */
    public function examUserInfo(int $id = null){

        if(request()->ajax()){

            if(!isset($id)){
                $results = ExamResult::with('user', 'exam', 'exam_answers')->where('user_id', Auth::id())->get();
            }
            else{
                $results = ExamResult::with('user', 'exam', 'exam_answers')
                    ->where('user_id', Auth::id())
                    ->where('exam_id', $id)
                    ->get();
            }
            return ExamResultResource::collection($results);
        }
    }
}
