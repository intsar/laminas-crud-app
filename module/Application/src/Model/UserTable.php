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

    // Fetch user by ID
    public function getUser($id)
    {
        $rowset = $this->tableGateway->select(['id' => (int) $id]);
        return $rowset->current();
    }

   public function saveUser(User $user)
    {
    $data = [
        'name'  => $user->name,
        'email' => $user->email,
        'password' => password_hash($user->password, PASSWORD_DEFAULT), // Hash password
    ];

    // Check if email already exists
    $existingUser = $this->tableGateway->select(['email' => $user->email])->current();

    if ($existingUser && (!$user->id || $existingUser->id !== $user->id)) {
        return ['error' => 'Email ID already exists. Please use a different email.'];
    }

    if ($user->id) {
        // Update user
        $this->tableGateway->update($data, ['id' => $user->id]);
    } else {
        // Insert new user
        $this->tableGateway->insert($data);
    }

    return ['success' => true];
    }

    // ✅ **New Method for Updating a User**
    public function updateUser($id, $data)
    {
        return $this->tableGateway->update($data, ['id' => (int) $id]);
    }

    // Delete user
    public function deleteUser($id)
    {
        return $this->tableGateway->delete(['id' => (int) $id]);
    }
}
