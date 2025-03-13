<?php
namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Application\Form\UserForm;
use Application\Form\UserInputFilter;
use Application\Model\UserTable;
use Application\Model\User;

class UserController extends AbstractActionController
{
    private $userTable;

    public function __construct(UserTable $userTable)
    {
        $this->userTable = $userTable;
    }

    public function addAction()
    {
        $form = new UserForm();
        $form->setInputFilter(new UserInputFilter());

        $request = $this->getRequest();
        $errorMessage = null;

        if ($request->isPost()) {
            $form->setData($request->getPost());

        if ($form->isValid()) {
            $data = $form->getData();
            unset($data['submit']); // Remove submit field before saving
            $user = new User();
            $user->exchangeArray($data);

            // Save user and check for errors
            $result = $this->userTable->saveUser($user);

            if (isset($result['error'])) {
                $errorMessage = $result['error'];
            } else {
                return $this->redirect()->toRoute('user', ['action' => 'index']);
            }
        }
    }

    return new ViewModel([
        'form' => $form,
        'errorMessage' => $errorMessage, // Pass error to view
    ]);
    }


    // Read
    public function indexAction()
    { 
        $users = $this->userTable->fetchAll();
        return new ViewModel(['users' => $users]);
    }

   public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('user', ['action' => 'index']);
        }

        // Fetch the user
        $user = $this->userTable->getUser($id);
        if (!$user) {
            return $this->redirect()->toRoute('user', ['action' => 'index']);
        }

        $form = new UserForm();
        $form->bind($user);
        $form->setInputFilter(new UserInputFilter());

        $request = $this->getRequest();
        $errorMessage = null;

        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $data = $form->getData();
                // Save user and check for errors
                $result = $this->userTable->saveUser($data);

                if (isset($result['error'])) {
                    $errorMessage = $result['error'];
                } else {
                    return $this->redirect()->toRoute('user', ['action' => 'index']);
                }
            }
        }

        return new ViewModel([
            'form' => $form,
            'errorMessage' => $errorMessage,
            'user' => $user, // Pass user data to view
        ]);
    }


    // Delete
    public function deleteAction()
    {
        $id = $this->params()->fromRoute('id');
        $this->userTable->deleteUser($id);
        return $this->redirect()->toRoute('user', ['action' => 'index']);
    }
}
