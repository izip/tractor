<?php




class Dialogs extends \Phalcon\Mvc\Model
{


    public $id;

   public $creation_date;


    public function initialize()
    {
        $this->hasMany("id", "Message", "dialogs_id" , array(
                "foreignKey" => true)
        );

        $this->hasManyToMany(
            "id",
            "DialogsHasUser",
            "dialogs_id", "user_id",
            "User",
            "id"
        );



    }


}
