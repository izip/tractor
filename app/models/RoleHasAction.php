<?php




class RoleHasAction extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $role_id;
     
    /**
     *
     * @var integer
     */
    public $role_action_id;

    public function initialize()
    {

        $this->belongsTo("role_id", "Role", "id", NULL);
        $this->belongsTo("role_action_id", "Action", "id", NULL);




    }
     
}
