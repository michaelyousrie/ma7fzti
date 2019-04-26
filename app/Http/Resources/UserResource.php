<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'first_name'    => $this->first_name,
            'last_name'     => $this->last_name,
            'email'         => $this->email,
            'balance'       => $this->balance,
            'currency'      => $this->currency,
            'app_version'   => $this->app_version,
            'language_code' => $this->language_code,
            'api_token'     => $this->api_token
        ];
    }
}
