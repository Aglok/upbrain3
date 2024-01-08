<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection as Resource;

class ExamResultResource extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'exam_id' => $this->exam->id,
            'comments' => $this->comments,
            'exam_name' => $this->exam->name,
            'exam_answers' => $this->exam_answers->exam_answers,
            'result_expanded_answers' => $this->result_expanded_answers,
            'result_short_answers' => $this->result_short_answers,
            'short_answers' => $this->short_answers,
            'full_name' => $this->user->full_name,
            'start_date' => $this->exam->start_date,
            'images' => $this->images,
            'updated_at'=>  date($this->updated_at)
        ];
    }
}
