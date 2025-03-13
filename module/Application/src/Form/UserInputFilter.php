<?php

namespace Application\Form;

use Laminas\InputFilter\InputFilter;

class UserInputFilter extends InputFilter
{
    public function __construct()
    {
        // Name Validation
        $this->add([
            'name' => 'name',
            'required' => true,
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                ['name' => 'NotEmpty'],
            ],
        ]);

        // Email Validation
        $this->add([
            'name' => 'email',
            'required' => true,
            'validators' => [
                ['name' => 'EmailAddress'],
            ],
        ]);

        // Password Validation
        $this->add([
            'name' => 'password',
            'required' => true,
            'filters' => [
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                ['name' => 'NotEmpty'],
            ],
        ]);
    }
}
