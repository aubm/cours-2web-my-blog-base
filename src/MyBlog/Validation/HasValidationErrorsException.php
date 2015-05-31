<?php

namespace MyBlog\Validation;

class HasValidationErrorsException extends \Exception
{
    private $validation_errors_collection;

    /**
     * @return ValidationErrorsCollection
     */
    public function getValidationErrorsCollection()
    {
        return $this->validation_errors_collection;
    }

    public function setValidationErrorsCollection(ValidationErrorsCollection $validation_errors_collection)
    {
        $this->validation_errors_collection = $validation_errors_collection;
    }
}