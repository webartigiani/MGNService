<?php

namespace App\Http\Requests\Workers;

use Illuminate\Foundation\Http\FormRequest;

class WorkerRequest extends FormRequest
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
            'nome' => 'required|string|max:64',
            'cognome' => 'required|string|max:64',
            'codice_fiscale' => 'required|string|max:16',
            'data_assunzione' => 'required|date',
            'ore_settimanali' => 'required|Integer'
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
            'nome' => 'required|string|max:64',
            'cognome' => 'required|string|max:64',
            'codice_fiscale' => 'required|string|max:16',
            'data_assunzione' => 'required|date',
            'ore_settimanali' => 'required|Integer'
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
