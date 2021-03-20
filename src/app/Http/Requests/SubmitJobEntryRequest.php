<?php

namespace App\Http\Requests;

use App\Models\JobEntry;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubmitJobEntryRequest extends FormRequest
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

        // @TODO: validation messages em portugues
        
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'email',
            ],
            'phone_number' => [
                'required',
                'numeric',
                'digits_between:12,13',
            ],
            'desired_role' => [
                'required',
                'string',
                'max:255',
            ],
            'school_level' => [
                'required',
                'string',
                Rule::in(JobEntry::SCHOOL_LEVELS),
            ],
            'resume' => [
                'required',
                'file',
                'mimes:pdf,doc,docx',
                'max:1024',
            ],
            'additional_info' => [
                'nullable',
                'string',
            ],
        ];
    }
}
