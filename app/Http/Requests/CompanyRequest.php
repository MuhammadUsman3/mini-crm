<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CompanyRequest extends FormRequest
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
    public function rules(Request $request)
    {
        $rule = [
            'name' => 'required',
            'email' => 'required',
            'website' => 'required',
        ];

        if (!$request->expectsJson()) {
            $rule['logo'] = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        }

        return $rule;
    }
}
