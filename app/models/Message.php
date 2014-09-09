<?php




class Message extends \Phalcon\Mvc\Model
{


    public $id;

    public $dialogs_id;

    public $text;
     

     public $read;

    public $creation_date;
    public $author_id;
     


    public function initialize()
    {
        $this->belongsTo("dialogs_id", "Dialogs", "id" , array(
            "foreignKey" => true)
    );

        $this->belongsTo("author_id", "User", "id" ,NULL);
    }
     
}
