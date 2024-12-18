<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostBookRequest extends FormRequest
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
        // @TODO implement
        // implemented
        return [
            'isbn' => 'required|string|min:13|max:13|unique:books',     // ISBN must be a unique 13-character string.
            'title' => 'required|string|max:255',                       // Title is required, with a maximum of 255 characters.
            'description' => 'required|string|max:1000',                // Description is required, max length of 1000 characters.
            'authors' => 'required|array|min:1',                        // Must provide at least one author in an array.
            'authors.*' => 'required|exists:authors,id',                // Each author must exist by ID in the 'authors' table.
            'published_year' => 'required|integer|between:1900,2020',   // Year must be between 1900 and 2020.
            'price' => 'required|numeric|min:0',                        // Price is required and cannot be negative.
        ];
    }
}
