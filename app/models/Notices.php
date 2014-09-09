<?php




class Notices extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;
     
    /**
     *
     * @var string
     */
    public $text;
     
    /**
     *
     * @var integer
     */
    public $user_id;
     
    /**
     *
     * @var string
     */
    public $creation_date;
     
    /**
     *
     * @var integer
     */
    public $creator_id;

    public function initialize()
    {
        $this->belongsTo("user_id", "User", "id" , array(
                "foreignKey" => true)
        );


    }

}
