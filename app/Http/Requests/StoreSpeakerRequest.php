<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSpeakerRequest extends FormRequest
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
            'name'=>'required',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|confirmed',
            'image'=>'required|image',
            'job_title'=>'required|string',
            'description'=>'required|string',
            'company_name'=>'required|string',
            'facebook_url'=>'required|url',
            'twitter_url'=>'required|url',
            // 'stripe_account_id'=>'required|string',
        ];
    }
}
// 'city'=>'required|string',
            // 'country'=>'required|string',
            // 'line1'=>'required|string',
            // 'postal_code'=>'required|number',
            // 'state'=>'required|string',