<?php




class DialogsHasUser extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $dialogs_id;

    public $user_id;


    public function initialize()
    {

        $this->belongsTo("dialogs_id", "Dialogs", "id" , NULL);
         $this->belongsTo("user_id", "User", "id" , NULL);




    }


}
