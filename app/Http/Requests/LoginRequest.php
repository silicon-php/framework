<?php

namespace App\Http\Requests;

use Silicon\Http\CustomRequest;
use Silicon\Validation\RequestValidator;

class LoginRequest extends CustomRequest
{
    public function rules(RequestValidator $validator): void
    {
        $validator
            ->required(["email", "password"])
            ->email($this->input("email"))
            ->password($this->input("password"), 8);
    }

    public function authorize(): bool
    {
        return true;
    }

    public function email(): string
    {
        return $this->input('email');
    }

    public function password(): string
    {
        return $this->input('password');
    }
}
