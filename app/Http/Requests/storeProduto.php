<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storeProduto extends FormRequest
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
      return [
         'nome' => 'required|max:255',
         'descricao' => 'required',
         'preco' => 'required',
         'estoque_min' => 'required',
         'peso'=>'required_if:tipo,==,1'
      ];

}