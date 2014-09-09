<?php




class Controller extends \Phalcon\Mvc\Model
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
    public $name;

    public function initialize()
    {
        $this->hasMany("id", "Action", "controller_id",  NULL);


    }

}
