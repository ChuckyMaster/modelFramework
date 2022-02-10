<?php 
namespace Models;




class User extends AbstractModel implements \  JsonSerializable {


protected string $tableName = "users";

private $id;
public function getId(){
    return $this->id;
}

private $username;

public function getUsername(){
    return $this->username;
}


public function setUsername($username){
    $this->username = $username;
}
private $password;
public function getPassword(){
    return $this->password;
}


public function setPassword($password){
    $this->password = password_hash($password, PASSWORD_DEFAULT);
}

private $email;
public function getEmail(){
    return $this->email;
}


public function setEmail($email){
    $this->email = $email;
}
private $display_name;
public function getDisplayName(){
    return $this->display_name;
}


public function setDisplayName($display_name){
    $this->display_name = $display_name;
}


    /**
     * @return array|false
     *
     */
    public static function getUser(){

    if(isset($_SESSION['user'])){

        $userModel = new \Models\User();
        return $userModel->findById($_SESSION['user']['id']);
    } else {
        return false;
    }
}



/**
 * 
 * Ajouter un user dans la BDD
 * 
 * @param User $user
 * 
 * @return void
 */
public function register(User $user):void
{


    $sql = $this->pdo->prepare("INSERT INTO {$this->tableName} (username, password, email, display_name) VALUES
    
    (:username, :password, :email, :display_name)");

    $sql->execute([
        'username' => $user->username,
        'password' => $user->password,
        'email' => $user->email,
        'display_name' => $user->display_name
    ]);
}

    /**
     *
     * Trouver un username dans la BDD
     *
     * @param string $username
     *
     *
     */
    public function findByUsername($username){

        $sql = $this->pdo->prepare("SELECT * FROM {$this->tableName} WHERE username LIKE :username");

        $sql->execute([
            "username" => $username
        ]);

        $sql->setFetchMode(\PDO::FETCH_CLASS, get_class($this));
        return $sql->fetch();

    }

    /**
     *se connecter
     *
     * @param string $password
     *
     * @return bool
     *
     */
    public function logIn(string $password)
    {
        $result = false;
        if (password_verify($password, $this->password)){

            $_SESSION['user'] = ['id'=>$this->id, "username"=>$this->username, "displayName" =>$this->display_name];

            $result = true;

        }

        return $result;
    }

public function logOut(){


        session_unset();
}

public function  jsonSerialize()
{
    // TODO: Implement jsonSerialize() method.

    return [
        "id" => $this->id,
        "username" =>$this->username,
        "display_name" => $this->display_name
    ];
}


}




?>