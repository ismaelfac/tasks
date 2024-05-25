<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
        return [
            'email' => 'required',
            'password' => 'required'
        ];
    }

    public function getCredentials()
    {
        $email = $this->get('email');
        if ($email) {
            return [
                'email' => $email,
                'password' => $this->get('password'),
                'active' => 1
            ];
        }else{
            return null;
        }
    }

    public function isEmail($value): bool
    {
        $factory = $this->container->make(ValidationFactory::class);
        return !$factory->make(['email' => $value], ['email' => 'email'])->fails();
    }
}
