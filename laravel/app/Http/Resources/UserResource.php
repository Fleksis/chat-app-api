<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'is_privacy' => $this->is_privacy,
            'firstname' => ($this->is_privacy) ? $this->firstname : "",
            'lastname' => ($this->is_privacy) ? $this->lastname : "",
            'username' => $this->username,
            'email' => $this->email,
        ];
    }
}
