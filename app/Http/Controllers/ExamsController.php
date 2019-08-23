<?php

namespace App\Http\Controllers;

use App\Http\Resources\ExamResultResource;
use App\Models\ExamAnswer;
use App\Models\ExamResult;
use Auth;
use function request;

class ExamsController extends Controller
{
    /**
     * @param $id
     * @return string
     */
    public function examResults($id){
        if(request()->ajax()){
            $results = ExamResult::find($id);
            $results->exam_answers;
            return response()->json($results);
        }
    }

    /**
     * @param $id
     * @return string
     */
    public function examAnswers($id){
        if(request()->ajax()){
            $results = ExamAnswer::find($id);
            return response()->json($results);
        }
    }

    public function examUserInfo($id = null){

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
