<?php

namespace Models;




class Avis extends AbstractModel implements \JsonSerializable {




     public function getAuthor(){

      $modelUser = new \Models\User();
         return $modelUser->findById($this->user_id);

    }

  private $user_id;
  
    private $content;
    public function getContent(){
        return $this->content;
    }

    public function setContent($content){
        $this->content = $content ;
    }


    private $id;
    public function getId() {
        return $this->id;
    }

    private int $velo_id;
    public function getVeloId(){
        return $this->id;
    }

    public function setVeloId($velo_id){
        $this->velo_id = $velo_id;
    }



    protected string $tableName = "avis";




    /** Retrouver les avis associé a un velo
     * 
     * @param int $velo_id
     * 
     * @return array|bool
     * 
     * 
     */
    public function findAllByVelo(int $velo_id){


        $sql = $this->pdo->prepare("SELECT * FROM {$this->tableName} WHERE velo_id = :velo_id");

        $velo = new \Models\Velo();

        $sql->execute([
            "velo_id" => $velo_id
        ]);

        $avis = $sql->fetchAll(\PDO::FETCH_CLASS, get_class($this));

        return $avis;
    }



    /** Enregistre un avis dasns la BDD 
     * 
     * @param Avis $avis
     */
    public function save(Avis $avis):void{


        $sql = $this->pdo->prepare("INSERT INTO {$this->tableName} (user_id, content, velo_id) VALUES 
        (:user_id, :content, :velo_id)");

        $velo = new \Models\Velo();

        $sql->execute([
            "user_id" => $avis->user_id,
            "content" => $avis->content,
            "velo_id" => $avis->velo_id
        ]);


    }


    public function jsonSerialize()
    {

        return [
            "author"=>$this->getAuthor(),
            "content"=>$this->content
        ];
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id): void
    {
        $this->user_id = $user_id;
    }
}





?>