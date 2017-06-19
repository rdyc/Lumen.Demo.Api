<?php

namespace App\Http\Requests;

use Input;

class ArtistPost extends Request
{
    
    protected function validationData()
    {
        $payload = $this->json()->all();
        return $payload;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'title' => 'required|unique:posts|max:255',
            'body' => 'required',
        ];
    }

    public function isValid(){
        return $this->validate($request, $this->rules());
    }
}