<?php

namespace Models;



class Message extends AbstractModel implements \JsonSerializable
{

    protected string $tableName = "messages";

    private int $id;

    private string $author;

    private string $content;

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @param string $author
     */
    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }



    /**
     * Ajouter un message dans la BDD
     *
     * @param Message $message
     *
     * @return void
     */
    public function save(Message $message): void{

        $sql = $this->pdo->prepare("INSERT INTO {$this->tableName} (author, content) VALUES (:author, :content)");

        $sql->execute([
            "author" => $message->author,
            "content" => $message->content
        ]);


    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        // TODO: Implement jsonSerialize() method.

        return [
            "id" => $this->id,
            "author" =>$this->author,
            "content" =>$this->content
        ];
    }

}