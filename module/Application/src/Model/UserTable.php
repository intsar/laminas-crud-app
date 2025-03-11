<?php
namespace Application\Model;

use Laminas\Db\TableGateway\TableGatewayInterface;

class UserTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    public function getUser($id)
    {
        return $this->tableGateway->select(['id' => $id])->current();
    }

    public function saveUser(User $user)
    {
        $data = [
            'name'     => $user->name,
            'email'    => $user->email,
            'password' => password_hash($user->password, PASSWORD_DEFAULT),
        ];

        if ($user->id) {
            $this->tableGateway->update($data, ['id' => $user->id]);
        } else {
            $this->tableGateway->insert($data);
        }
    }

    public function deleteUser($id)
    {
        $this->tableGateway->delete(['id' => $id]);
    }
}
