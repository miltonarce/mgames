<?php
class Auth
{

  public function login ($usuario, $password)
  {
    $user = new Usuario;
    if($user->getUser($usuario)){
      if(password_verify($password, $user->password)){
        $this->loginUser($user);
        return true;
      }else{
        return false;
      }
    }else{
      return false;
    }
  }

  public function loginUser(Usuario $user)
  {
    
    $_SESSION['id'] = $user->id;
    $_SESSION['username'] = $user->usuario;
  }

  public function logout()
  {
    unset($_SESSION['id']);
    unset($_SESSION['username']);
  }

  public static function isLogged()
	{
		if(isset($_SESSION['id'])) {
			return true;
		} else {
			return false;
    }
  }
}