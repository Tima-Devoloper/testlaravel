<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class CheckResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $user = User::where('id',$request->id)->first();

        return [
            'user'  => $user->id,
            'photo_url' => $request->photo_url,
            'type'  => $request->type,
            'created_at' => $request->created_at,
            'code'  => $request->code,
            'status'    =>  $request->status
        ];
    }
}
