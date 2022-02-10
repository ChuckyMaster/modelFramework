<?php


namespace Models;

//Creation d'une classe qui hérite de AbstractModel afin d'avoir 3 fonctions disponible:
// findAll() findById() remove()
class Velo extends AbstractModel implements \JsonSerializable{

    //Ici on defini le nom de la table en utilisant la variable $tableName de la class AbstractModel, on l'a met "protected"
    //pour qu'elle soit héritable

    protected string $tableName = "velos";

    // colonnes de la table velos :
    // -id
    // -name
    // -Description
    // -price
    // -image


    
    //Ensuite il nous ajouter un setter et getter à chaque colonne de la table, l'id n'aura qu'un getter
    private $id;

    public function getId(){
        return $this->id;
    }
    private $name;

    public function getName(){
        return $this->name;
    }

    public function setName($name){
        $this->name = $name;
    }
    private $description;
    public function getDescription(){
        return $this->description;
    }

    public function setDescription($description){
        $this->description = $description;
    }
    
    private $price;

    public function getPrice(){
        return $this->price;
    }

    public function setPrice($price){
        $this->price = $price;
    }
    private $image;
    public function getImage(){
        return $this->image;
    }

    public function setImage($image){
        $this->image = $image;
    }

    private $user_id;




    /**
     * 
     * Ajouter un velo dans la BDD
     * 
     * @param Velo $velo
     * 
     * @return void
     */
    public function save(Velo $velo):void{

        $sql = $this->pdo->prepare("INSERT INTO {$this->tableName} (name, description, image, price, user_id) VALUES 
        (:name, :description,:image, :price, :user_id)");


$sql->execute([
    'name' => $velo->name,
    'description' => $velo->description,
    'image' => $velo->image,
    'price' => $velo->price,
    'user_id' => $velo->user_id
]);
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



    public function getAvis(){

        $modelAvis = new \Models\Avis();

        $avis = $modelAvis->findAllByVelo($this->id);

        return $avis;



    }

    public function jsonSerialize(){

        return [
            "id"=>$this->id,
            "name" =>$this->name,
            "description" => $this->description,
            "avis" => $this->getAvis(),
            "image" => $this->image
        ];
    }



}










?>