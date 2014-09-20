<?php




class ChatMicroDialog extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;


    /**
     *
     * @var integer
     */
    public $chat_id;

    /**
     *
     * @var integer
     */
    public $base_mess_id;
    /**
     *
     * @var string
     */
    public $created_id;
    public $creation_date;







    public function initialize()
    {

        $this->belongsTo("chat_id" , "Chat" , "id");
        $this->hasMany("id" , "MessageChat" ,"micro_dialog_id");


    }

}
