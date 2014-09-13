<?php




class MessageChat extends \Phalcon\Mvc\Model
{


    public $id;

    public $chat_id;

    public $text;

    public $type;
    public $micro_dialog_id;
    public $read;

    public $creation_date;
    public $author_id;



    public function initialize()
    {
        $this->belongsTo("chat_id", "Chat", "id" , array(
                "foreignKey" => true)
        );

        $this->belongsTo("micro_dialog_id", "ChatMicroDialog", "id" , NULL);

        $this->belongsTo("author_id", "User", "id" ,NULL);
    }

}
