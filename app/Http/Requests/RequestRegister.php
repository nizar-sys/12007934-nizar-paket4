<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestRegister extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'name' => 'required',
            'no_telp' => 'required|numeric',
            'email' => 'required|email',
            'password' => 'required'
        ];

        return $rules;
    }

    public function attributes()
    {
        return [
            'name' => "Nama lengkap",
            'no_telp' => "Nomor telepon",
            'password' => "Kata sandi"
        ];
    }

    public function messages()
    {
        return [
            '*.required' => ':attribute wajib diisi',
            'no_telp.numeric' => ":attribute harus menggunakan nomor",
            'email.email' => "Format email salah"
        ];
    }
}
