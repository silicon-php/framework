<?php

namespace Silicon\Validation;

use Silicon\Http\CustomRequest;

class RequestValidator extends Validator
{
    public function __construct(protected CustomRequest $request) {}

    public function required(array $fields): RequestValidator
    {
        foreach ($fields as $field) {
            if (!$this->request->input($field)) {
                throw new \InvalidArgumentException($field . " is required.");
            }
        }
        return $this;
    }
}
