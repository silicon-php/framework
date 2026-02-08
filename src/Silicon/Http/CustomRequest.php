<?php

namespace Silicon\Http;

use Silicon\Validation\RequestValidator;

abstract class CustomRequest
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    protected function getRequest(): Request
    {
        return $this->request;
    }

    public function validate()
    {
        try {
            $this->rules(new RequestValidator($this));
        } catch (\Exception $e) {
            throw new \Exception('Validation failed: ' . $e->getMessage());
        }
        return true;
    }

    abstract public function rules(RequestValidator $validator): void;

    abstract public function authorize(): bool;

    public function input(string $key, $default = null)
    {
        return $this->request->body->get($key, $default);
    }
}
