<?php

class UsersController extends Controller
{
  //fonction pour se logger
  function login()
  {
    //debug($this->Session->read('User'));
    if ($this->request->data) {
      $data = $this->request->data;
      $data->password = sha1($data->password);
      $this->loadModel('User');
      $user = $this->User->findFirst(array(
        'conditions' => [
          'login' => $data->login,
          'password' => $data->password
        ]
      ));
      if (!empty($user)) {
        $this->Session->write('User', $user);
      }
      $this->request->data->password = '';
    }
    if ($this->Session->isLogged()) 
    {
      if ($this->Session->user('role') == 'admin') 
      {
        $this->redirect('cockpit');
      }
      else 
      {
        $this->redirect('');
      }
    }
  }

  //fonction delogger
  function logout()
  {
    unset($_SESSION['User']);
    $this->Session->setFlash('Vous êtes déconnectés !');
    $this->redirect('/');
  }
}
