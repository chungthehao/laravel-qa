<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    // To specify which columns that we need to return
    public function toArray($request)
    {
        // return parent::toArray($request);

        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'votes_count' => $this->votes_count,
            'answers_count' => $this->answers_count,
            'view' => $this->view,
            'status' => $this->status,
            'excerpt' => $this->excerpt,
            'created_date' => $this->created_date,
            'user' => new UserResource($this->user),
        ];
    }
}