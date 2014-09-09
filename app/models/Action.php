<?php




class Action extends \Phalcon\Mvc\Model
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
     
    /**
     *
     * @var integer
     */
    public $role_id;
     




    public function initialize()
    {

$this->belongsTo("controller_id" , "Controller" , "id");

        $this->hasManyToMany(
            "id",
            "RoleHasAction",
            "role_action_id" ,"role_id",
            "Role",
            "id"

        );

    }
     
}
