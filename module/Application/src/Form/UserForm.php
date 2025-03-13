<?php

namespace Application\Form;

use Laminas\Form\Form;
use Laminas\Form\Element;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\NotEmpty;
use Laminas\Validator\EmailAddress;

class UserForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('user_form');

        // Name Field
        $this->add([
            'name' => 'name',
            'type' => Element\Text::class,
            'options' => [
                'label' => 'Name',
            ],
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => 'Enter Name',
                'required' => true,
            ],
        ]);

        // Email Field
        $this->add([
            'name' => 'email',
            'type' => Element\Email::class,
            'options' => [
                'label' => 'Email',
            ],
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => 'Enter Email',
                'required' => true,
            ],
        ]);

        // Password Field
        $this->add([
            'name' => 'password',
            'type' => Element\Password::class,
            'options' => [
                'label' => 'Password',
            ],
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => 'Enter Password',
                'required' => true,
            ],
        ]);

        // Submit Button
        $this->add([
            'name' => 'submit',
            'type' => Element\Submit::class,
            'attributes' => [
                'class' => 'btn btn-success btn-block',
                'value' => 'Save',
            ],
        ]);
    }
}
