<?php
namespace Controllers;



class User extends AbstractController{

protected $defaultModelName = \Models\User::class;



/**
 * 
 * Creation d'un utilisateur
 * 
 * @return void
 */
public function signUp(){

    $username = null;
    $password = null;
    $email = null;
    $displayName = null;


    if(!empty($_POST['username'])) { 
        $username = htmlspecialchars($_POST['username']);}

    if(!empty($_POST['password'])) { 
        $password = $_POST['password'];}

    if(!empty($_POST['email'])) { 
            $email = htmlspecialchars($_POST['email']);}

    if(!empty($_POST['displayName'])) { 
            $displayName = htmlspecialchars($_POST['displayName']);}


        if($username && $password && $email && $displayName) {

            $user = new \Models\User();

            //verifier que le username n'est pas deja utilisé
        if($this->defaultModel->findByUsername($username)){

            $this->redirect([
                "type" => "user",
                "action" => "signup",
                "info" => "username deja utilisé"
            ]);
        }

            $user->setUsername($username);

            $user->setPassword($password);
            $user->setEmail($email);
            $user->setDisplayName($displayName);


            $this->defaultModel->register($user);


           

        }

        return $this->render("register/signup",["pageTitle" => "Sign Up"] );

}
    public function signIn()
    {
        $username = null;
        $password = null;

        if (!empty($_POST['username'])) {
            $username = htmlspecialchars($_POST['username']);

        }
        if (!empty($_POST['password'])) {
            $password = $_POST['password'];
        }

        if ($username && $password) {

            $userLogginIn = $this->defaultModel->findByUsername($username);



            if (!$userLogginIn) {
                $this->redirect([
                    "type" => "user",
                    "action" => "signin",
                    "info" => "username inexistant"
                ]);
            }

            if (!$userLogginIn->logIn($password)) {
                return $this->redirect(["type" => "user", "action" => "signin", "info" => "mot de passe incorrect"]);
            }


            return $this->redirect(["type" => "home", "action" => "index", "info" => "bienvenue ca marche pas de toute facon ! "]);


        }
        return $this->render("register/login", ["pageTitle" => "connexion"]);

    }
            public function signOut(){

            $this->defaultModel->logOut();

            return $this->redirect([

                'type' => 'velo',
                'action' => 'index',
                'info' => 'Deconnecté'
            ]);

        }
}





?>