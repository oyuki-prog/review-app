<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rule = [
            'title' => 'required|string|max:20',
            'body' => 'required|string|max:2000',
        ];

        $route = $this->route()->getName();
        if ($route === 'reviews.store') {
            $rule['image.*'] = 'required|image';
        }

        return $rule;
    }
}
