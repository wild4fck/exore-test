<?php

namespace App\Http\Requests\Admin;

use App\Models\Actor;
use App\Models\Article;
use App\Models\Performance;
use Illuminate\Validation\Rule;

class UpdateEmployeeRequest extends CreateEmployeeRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array {
        $rules = parent::rules();
        $rules['email'] = [
            'required',
            'string',
            'email',
            'max:255',
            Rule::unique('users')->ignore($this->route('user')->id),
        ];
        $rules['password'] = str_replace("required", "nullable", $rules['password']);
        return $rules;
    }
}
