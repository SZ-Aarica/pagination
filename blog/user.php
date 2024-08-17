
<?php

class user
{
  private ?string $username = null;
  private ?string $email  = null;
  private ?string $password  = null;
  private ?string $repeatpass = null;



  public function getUsername(): string
  {
    return $this->username;
  }
  public function getRepeatpass(): string
  {
    return $this->repeatpass;
  }
  public function getEmail(): string
  {
    return $this->email;
  }
  public function getPassword(): string
  {
    return $this->password;
  }

  public function setRepeatpass($repeatpass) : void{
    $this->repeatpass = $repeatpass;

  }
  public function setUsername($username): void
  {
    $this->username = $username;
  }
  public function setEmail(string $email): void
  {
    $this->email = $email;
  }
  public function setPassword($password): void
  {
    $this->password = $password;
  }
}
?>