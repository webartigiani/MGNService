<?php

namespace App\Http\Requests\Veicoli;

use Illuminate\Foundation\Http\FormRequest;

class VeicoloRequest extends FormRequest
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
        if ($this->isMethod('post')) {
            return $this->createRules();
        } elseif ($this->isMethod('put')) {
            return $this->updateRules();
        }
    }

    /**
     * Define validation rules to store method for resource creation
     *
     * @return array
     */
    public function createRules(): array
    {
        return [
            'manufacter' => 'required|string|max:128',
            'model' => 'required|string|max:128',
            'licence_plate' => 'required|string|max:10|unique:veichles',
            'enabled' => 'required'
        ];
    }

    /**
     * Define validation rules to update method for resource update
     *
     * @return array
     */
    public function updateRules(): array
    {
        return [
            'manufacter' => 'required|string|max:128',
            'model' => 'required|string|max:128',
            'licence_plate' => 'required|string|max:10',
            'enabled' => 'required'
        ];
    }

    /**
     * validation messages
     */
    public function messages()
    {
        return [
            'required' => 'Il campo è obbligatorio',
            'unique' => 'Numero di targa già in uso',
            'min' => 'Richiesti min. caratteri',
            'max' => 'Lunghezza eccessiva'
        ];
    }
}
