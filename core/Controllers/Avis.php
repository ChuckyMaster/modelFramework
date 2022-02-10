<?php


namespace Controllers;

class Avis extends AbstractController{

    protected $defaultModelName = \Models\Avis::class;

    /**
 * 
 * Creer un nouvelle avis
 * @return void
 * 
 */
public function new(){

  $user =  $this->getUser();

    if(!user){

        return $this->redirect([
            'type' => 'velo',
            'action' => 'index',
            'info' => 'connectez vous'
        ]);
    }

    if( !empty($_POST['veloId']) && ctype_digit($_POST['veloId'])) {
        $veloId = $_POST['veloId'];

    }



     if (!empty($_POST['content'])) {
         $content = htmlspecialchars(($_POST['content']));
     }



     //verifier que le velo existe


     $modelVelo = new \Models\Velo();

     $velo = $modelVelo->findById($veloId);

    if(!$veloId || !$content) {

        return $this->redirect([
            'type' => 'velo',
            'action' => 'show',
            'id' => $velo->getId(),
            'info' => 'Remplir les champs svp'
        ]);
    }



    if (!$velo) {
        return $this->redirect([
            "action" => "index",
            "type" => "velo"
        ]);
     }

    $avis = new \Models\Avis();

    $avis->setUserId($user->getId());
    $avis->setContent($content);
    $avis->setVeloId($veloId);


     $this->defaultModel->save($avis);



     return $this->redirect([
        "action" => "show",
        "type" => "velo",
        "id" => $veloId
    ]);





    
}






}




?>