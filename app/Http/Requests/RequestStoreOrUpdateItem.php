<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestStoreOrUpdateItem extends FormRequest
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
            'item_name' => 'required',
            'start_price' => 'required|numeric',
            'item_desc' => 'required',
            'item_image' => 'nullable',
        ];

        if($this->isMethod('POST')){
            $rules['item_image'] = 'required|image|mimes:jpg,jpeg,png,gif';
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'item_name' => "Barang",
            'start_price' => "Harga awal barang",
            'item_desc' => "Deskripsi barang",
            'item_image' => 'Gambar barang'
        ];
    }

    public function messages()
    {
        return [
            '*.required' => ':attribute wajib diisi',
            'start_price.numeric' => ':attribute harus berformat nomor',
        ];
    }
}
