<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'speaker_id'=>'required|exists:speakers,id',
            'name'=>'required|string',
            'address'=>'required|string',
            'description'=>'required|string',
            'image'=>'required|image',
            'ticket_price'=>'required|numeric',
            'ticket_number'=>'required|integer',
            'date'=>'required|date',
            'category'=>'required|string',
            'longitude'=>'required|numeric',
            'latitude'=>'required|numeric',
        ];
    }
}
