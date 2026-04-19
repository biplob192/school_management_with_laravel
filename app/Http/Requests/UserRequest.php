<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        return ($this->isMethod('POST') ? $this->store() : $this->update());
    }

    protected function store()
    {
        return [
            'name'              => 'required|max:100',
            'email'             => 'email|unique:users',
            'phone'             => 'required|unique:users|regex:/^(013|014|015|016|017|018|019)[0-9]{8}$/',
            'password'          => 'required|confirmed',
            'role'              => 'in:Super Admin,Admin,Teacher,Student',
            'profile_image'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            // This password validation should enable in the production stage.
            // 'password'  => [
            //     'required',
            //     'confirmed',
            //     Password::min(6)
            //         ->mixedCase()
            //         ->numbers()
            //         ->symbols()
            // ],
        ];
    }

    protected function update()
    {
        return [
            'name'          => 'required|max:100',
            'email'         => ['email', Rule::unique('users')->ignore($this->route('id'))],
            'phone'         => ['required', 'regex:/^(013|014|015|016|017|018|019)[0-9]{8}$/', Rule::unique('users')->ignore($this->route('id'))],
            'password'      => ['sometimes', 'confirmed'],
            'role'          => 'in:Super Admin,Admin,Teacher,Student',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',


            // Use 'user' instead of 'id' in apiResourceRoute
            // 'email' => ['required', 'email', Rule::unique('users')->ignore($this->route('user'))],
            // 'phone' => ['required', Rule::unique('users')->ignore($this->route('user'))],
            // 'phone' => ['required', Rule::unique('users')->ignore($this->route('id'))],
        ];
    }
}
