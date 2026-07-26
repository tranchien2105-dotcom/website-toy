<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            'site_name' => 'required|max:255',

            'slogan' => 'nullable|max:255',

            'logo' => 'nullable|image',

            'favicon' => 'nullable|image',

            'primary_color' => 'required',

            'secondary_color' => 'required',

            'email' => 'nullable|email',

            'phone' => 'nullable',

            'address' => 'nullable',

            'facebook' => 'nullable',

            'instagram' => 'nullable',

            'youtube' => 'nullable',

            'tiktok' => 'nullable',

            'zalo' => 'nullable',

            'footer_text' => 'nullable',

            'copyright' => 'nullable',

            'meta_title' => 'nullable',

            'meta_description' => 'nullable',

            'meta_keywords' => 'nullable',

            'google_map' => 'nullable'

        ];
    }
}
