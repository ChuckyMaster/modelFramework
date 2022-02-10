<?php

namespace Controllers;


class Message extends AbstractController
{

    protected $defaultModelName = \Models\Message::class;

    public function index(){

        return $this->json($this->defaultModel->findAll());
    }


    public function new(){



        $request = $this->post("json", [
            "author" => "text",
            "contentArea" => "text"
        ]);


        if($request){

            $message = new \Models\Message();
            $message->setAuthor($request["author"]);
            $message->setContent($request["contentArea"]);
            $this->defaultModel->save($message);

            return $this->json('message send');


        }

        return $this->json("mauvaise requête");
    }

    public function suppr(){

        //recuperer la requete

        $request = $this->delete('json', ['id' => 'number']);

        if(!$request){
            return $this->json("Requête mal soumise", "delete");
        }

        //verifier qie le message existe
        //s'il n'existe pas renvoyer une réponse qui le signale

        $message = $this->defaultModel->findById($request['id']);

        if(!$message){
             return $this->json("Le message n'existe pas", "delete");

        }


        //supprimer le message

        $this->defaultModel->remove($message);

        return  $this->json("message supprimé", "delete");


    }






}