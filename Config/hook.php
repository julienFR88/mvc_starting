<?php
if($this->request->prefix == 'admin'){
	$this->layout = 'admin'; 

	if (!$this->Session->isLogged() || $this->Session->user('role') != 'admin') 
	{
		// session_destroy();
		$this->redirect('users/login');
	}
}
?>