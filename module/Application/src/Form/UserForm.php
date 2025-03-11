<?php
namespace Application\Form;

use Laminas\Form\Form;
use Laminas\Form\Element;
use Laminas\InputFilter\InputFilter;

class UserForm extends Form
{
    public function __construct()
    {
        parent::__construct('user_form');

        $this->add([
            'name' => 'id',
            'type' => Element\Hidden::class,
        ]);

        $this->add([
            'name' => 'name',
            'type' => Element\Text::class,
            'options' => [
                'label' => 'Name',
            ],
            'attributes' => [
                'class'       => 'form-control',
                'placeholder' => 'Enter your name',
                'required'    => true,
            ],
        ]);

        $this->add([
            'name' => 'email',
            'type' => Element\Email::class,
            'options' => [
                'label' => 'Email',
            ],
            'attributes' => [
                'class'       => 'form-control',
                'placeholder' => 'Enter your email',
                'required'    => true,
            ],
        ]);

        $this->add([
            'name' => 'submit',
            'type' => Element\Submit::class,
            'attributes' => [
                'value' => 'Submit',
                'class' => 'btn btn-primary mt-3',
            ],
        ]);

        $this->setInputFilter($this->createInputFilter());
    }

    private function createInputFilter()
    {
        $inputFilter = new InputFilter();

        $inputFilter->add([
            'name'     => 'name',
            'required' => true,
            'filters'  => [['name' => 'StringTrim']],
        ]);

        $inputFilter->add([
            'name'     => 'email',
            'required' => true,
            'validators' => [
                [
                    'name' => 'EmailAddress',
                ],
            ],
        ]);

        return $inputFilter;
    }
}
