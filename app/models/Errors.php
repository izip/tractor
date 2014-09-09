<?php




class Errors extends \Phalcon\Mvc\Model
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
    public $time;
     
    /**
     *
     * @var string
     */
    public $action;
     
    /**
     *
     * @var integer
     */
    public $user_id;
     
    /**
     *
     * @var string
     */
    public $source_line;
     
    /**
     *
     * @var string
     */
    public $error_text;
     
    /**
     *
     * @var string
     */
    public $error_type;


    public function initialize()
    {
        $this->belongsTo("user_id", "User", "id" , array(
            "foreignKey" => true)
        );

    }


}
