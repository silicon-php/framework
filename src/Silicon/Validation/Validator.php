<?php

namespace Silicon\Validation;

use Respect\Validation\Validator as v;

class Validator
{
    public function email($value): Validator
    {
        try {
            v::email()->assert($value);
            return $this;
        } catch (\Exception $e) {
            throw new \InvalidArgumentException($value . ' Invalid email format.');
        }
    }

    public function password($value, $min = 6): Validator
    {
        try {
            v::stringType()
                ->length($min, null)
                ->regex('/[A-Za-z]/')
                ->regex('/\d/')
                ->regex('/[^A-Za-z\d]/')
                ->assert($value);
            return $this;
        } catch (\Exception $e) {
            throw new \InvalidArgumentException($value . ' Invalid password format.');
        }
    }

    public function number($value, $min = null, $max = null): Validator
    {
        try {
            v::number()->assert($value);
            if ($max) {
                v::max($max)->assert($value);
            }
            if ($min) {
                v::min($min)->assert($value);
            }
            return $this;
        } catch (\Exception $e) {
            throw new \InvalidArgumentException($value . ' Invalid number format.');
        }
    }

    public function uuid($value): Validator
    {
        try {
            v::uuid()->assert($value);
            return $this;
        } catch (\Exception $e) {
            throw new \InvalidArgumentException($value . ' Invalid UUID format.');
        }
    }

    public function phone($value): Validator
    {
        try {
            v::phone()->assert($value);
            return $this;
        } catch (\Exception $e) {
            throw new \InvalidArgumentException($value . ' Invalid phone format.');
        }
    }

    public function alphanumeric($value): Validator
    {
        try {
            v::alnum()->assert($value);
            return $this;
        } catch (\Exception $e) {
            throw new \InvalidArgumentException($value . ' Invalid alphanumeric format.');
        }
    }

    public function boolean($value): Validator
    {
        try {
            v::boolVal()->assert($value);
            return $this;
        } catch (\Exception $e) {
            throw new \InvalidArgumentException($value . ' Invalid boolean format.');
        }
    }

    public function date($value): Validator
    {
        try {
            v::date()->assert($value);
            return $this;
        } catch (\Exception $e) {
            throw new \InvalidArgumentException($value . ' Invalid date format.');
        }
    }

    public function time($value): Validator
    {
        try {
            v::time()->assert($value);
            return $this;
        } catch (\Exception $e) {
            throw new \InvalidArgumentException($value . ' Invalid time format.');
        }
    }

    public function string($value): Validator
    {
        try {
            v::stringType()->assert($value);
            return $this;
        } catch (\Exception $e) {
            throw new \InvalidArgumentException($value . ' Invalid string format.');
        }
    }

    public function array($value, $valid = []): Validator
    {
        try {
            if (!empty($valid)) {
                v::arrayType()
                    ->each(v::in($valid))
                    ->assert($value);
            } else {
                v::arrayType()->assert($value);
            }
            return $this;
        } catch (\Exception $e) {
            throw new \InvalidArgumentException($value . ' Invalid array format.');
        }
    }

    public function regex($value, $regex): Validator
    {
        try {
            v::regex($regex)->assert($value);
            return $this;
        } catch (\Exception $e) {
            throw new \InvalidArgumentException($value . ' Invalid regex format.');
        }
    }
}
