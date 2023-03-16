<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestStoreOrUpdateAuction extends FormRequest
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
        $rules =  [
            'item_id' => 'required|exists:items,id',
        ];

        if($this->isMethod('POST')){
            $rules['item_id'] .= '|unique:auctions,item_id';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'item_id.required' => "Barang lelang wajib diisi",
            'item_id.exists' => "Barang lelang tidak ada di sistem",
            'item_id.unique' => "Barang sudah dilelang"
        ];
    }
}
