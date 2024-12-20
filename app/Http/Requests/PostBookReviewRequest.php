<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostBookReviewRequest extends FormRequest
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
        return [
            // @TODO implement
            // implemented
            'review' => 'required|integer|min:1|max:10', // Review is required and should be an integer between 1 and 10.
            'comment' => 'required|string',              // Comment is required as a string.
        ];
    }
}
