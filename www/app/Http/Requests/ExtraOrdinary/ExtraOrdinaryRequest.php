<?php

namespace App\Http\Requests\ExtraOrdinary;

use Illuminate\Foundation\Http\FormRequest;

class ExtraOrdinaryRequest extends FormRequest
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
            'worker_id' => 'required|integer',
            'ref_date' => 'required|date',
            'extraordinary_time' => 'required|string|max:5',
            'extraordinary_justification' => 'required|string|max:2'
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
            'worker_id' => 'required|integer',
            'ref_date' => 'required|date',
            'extraordinary_time' => 'required|string|max:5',
            'extraordinary_justification' => 'required|string|max:2'
        ];
    }

    /**
     * validation messages
     */
    public function messages()
    {
        return [
            'required' => 'Il campo è obbligatorio',
            'unique' => 'Già in uso',
            'min' => 'Richiesti min. caratteri',
            'max' => 'Lunghezza eccessiva'
        ];
    }
}
