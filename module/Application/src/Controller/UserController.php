<?php
namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Application\Model\User;
use Application\Model\UserTable;

class UserController extends AbstractActionController
{
    private $userTable;

    public function __construct(UserTable $userTable)
    {
        $this->userTable = $userTable;
    }

    // Create
    public function addAction()
    {
        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $user = new User();
            $user->exchangeArray($data);
            $this->userTable->saveUser($user);
            return $this->redirect()->toRoute('user', ['action' => 'index']);
        }
        return new ViewModel();
    }

    // Read
    public function indexAction()
    { 
        $users = $this->userTable->fetchAll();
        return new ViewModel(['users' => $users]);
    }

    // Update
    public function editAction()
    {
        $id = $this->params()->fromRoute('id');
        $user = $this->userTable->getUser($id);

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $data['id'] = $id;
            $user->exchangeArray($data);
            $this->userTable->saveUser($user);
            return $this->redirect()->toRoute('user', ['action' => 'index']);
        }

        return new ViewModel(['user' => $user]);
    }

    // Delete
    public function deleteAction()
    {
        $id = $this->params()->fromRoute('id');
        $this->userTable->deleteUser($id);
        return $this->redirect()->toRoute('user', ['action' => 'index']);
    }
}
