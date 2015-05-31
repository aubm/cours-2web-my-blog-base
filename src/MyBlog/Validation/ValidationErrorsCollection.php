<?php

namespace MyBlog\Validation;

class ValidationErrorsCollection
{
    private $_errors;
    private $_errors_count = 0;

    public function addValidationError(ValidationError $validation_error)
    {
        if (!isset($this->_errors[$validation_error->getField()])) {
            $this->_errors[$validation_error->getField()] = [];
        }

        $this->_errors[$validation_error->getField()][] = $validation_error;
        $this->_errors_count++;
    }

    public function getErrorsCount()
    {
        return $this->_errors_count;
    }

    /**
     * @return array
     */
    public function getErrorsForField($field)
    {
        return (isset($this->_errors[$field])) ? $this->_errors[$field] : [];
    }
}