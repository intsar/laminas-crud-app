<?php
namespace Application\Model;

class User
{
    public $id;
    public $name;
    public $email;
    public $password;
    public $created_at;

    public function exchangeArray(array $data)
    {
        $this->id         = !empty($data['id']) ? $data['id'] : null;
        $this->name       = !empty($data['name']) ? $data['name'] : null;
        $this->email      = !empty($data['email']) ? $data['email'] : null;
        $this->password      = !empty($data['password']) ? $data['password'] : null;
        $this->created_at = !empty($data['created_at']) ? $data['created_at'] : null;
    }

    public function getArrayCopy()
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'email'      => $this->email,
            'created_at' => $this->created_at,
        ];
    }
}

