<?php




class ChatHasUser extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $chat_id;

    public $user_id;


    public function initialize()
    {

        $this->belongsTo("chat_id", "Chat", "id" , NULL);
        $this->belongsTo("user_id", "User", "id" , NULL);




    }


}
