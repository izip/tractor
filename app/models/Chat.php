<?php




class Chat extends \Phalcon\Mvc\Model
{


    public $id;

    public $title;

    public $created_id;

    public $creation_date;


    public function initialize()
    {
        $this->hasMany("id", "MessageChat", "chat_id" , array(
                "foreignKey" => true)
        );

        $this->hasMany("id", "ChatMicroDialog", "chat_id" , NULL
        );
        $this->hasManyToMany(
            "id",
            "ChatHasUser",
            "chat_id", "user_id",
            "User",
            "id"
        );



    }


}
