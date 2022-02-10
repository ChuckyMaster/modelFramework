<?php

namespace Controllers;


class Message extends AbstractController
{

    protected $defaultModelName = \Models\Message::class;

    public function index(){

        return $this->json($this->defaultModel->findAll());
    }


    public function new(){


        $request = file_get_contents('php://input');


        $requestDeserialize= json_decode($request, true);

        $author = null;
        $content = null;

        if(!empty($requestDeserialize['author'])){
            $author = htmlspecialchars($requestDeserialize['author']);
        }

        if (!empty($requestDeserialize['contentArea'])){
            $content = htmlspecialchars($requestDeserialize['contentArea']);
        }

        if($author && $content){

            $message = new \Models\Message();
            $message->setAuthor($author);
            $message->setContent($content);
            $this->defaultModel->save($message);

            return $this->json('message send');


        }

        return $this->json("mauvaise requête");
    }

    public function suppr(){

        //recuperer la requete

        $request = $this->delete('json', ['id' => 'number']);
        if($request){
            return $this->json("Requête mal soumise", "delete");
        }

        //verifier qie le message existe
        //s'il n'existe pas renvoyer une réponse qui le signale

        $message = $this->defaultModel->findById($request['id']);


        //supprimer le message

        $this->defaultModel->remove($message);

        return  $this->json("message supprimé", "delete");


    }






}