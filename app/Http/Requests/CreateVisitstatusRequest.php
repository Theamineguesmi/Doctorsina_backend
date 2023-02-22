<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateVisitstatusRequest extends FormRequest {

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
            'alias' => 'required|unique:visitstatus,alias,'.$this->visitstatus, 
		];
	}

	public function messages()
    {
        return [
            'alias.required' => 'Enter alias for visit status',
			'alias.unique' => 'Alias visit status must be unique',
        ];
    }
}
