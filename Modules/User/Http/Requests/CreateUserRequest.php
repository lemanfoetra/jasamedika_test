<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'role_code' => 'required',
            'name'      => 'required',
            'email'     => 'required|unique:users,id,' . $this->id,
        ];
        if ($this->id == null) {
            $rules = array_merge($rules, [
                'password'  => 'required|min:8|confirmed',
            ]);
        } else if ($this->password != null) {
            $rules = array_merge($rules, [
                'password'  => 'required|min:8|confirmed',
            ]);
        }
        return $rules;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
