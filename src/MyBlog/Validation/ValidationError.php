<?php

namespace MyBlog\Validation;

class ValidationError
{
    private $field;
    private $message;

    public function __construct($field, $message)
    {
        $this->field = $field;
        $this->message = $message;
    }

    public function getField()
    {
        return $this->field;
    }

    public function __toString()
    {
        return $this->message;
    }
}