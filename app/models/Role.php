<?php




class Role extends \Phalcon\Mvc\Model
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


        $this->hasManyToMany(
             "id",
            "UserRole",
            "role_id" ,"user_id",
            "User",
            "id"

        );

        $this->hasManyToMany(
            "id",
            "RoleHasAction",
            "role_id" ,"role_action_id",
            "Action",
            "id"

        );


    }
}
