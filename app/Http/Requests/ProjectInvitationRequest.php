<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class ProjectInvitationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('update', $this->route('project'));

        //$this->route('project') == $project get it from the route

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'email'=>['required','exists:users,email']
        ];
    }
    public function messages()
    {
        return [
            'email.exists' => 'The Invited User Must Have An Account!'
        ];
    }

}
