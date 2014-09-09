<?php




class UserRole extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $user_id;
     
    /**
     *
     * @var integer
     */
    public $role_id;

    public function initialize()
    {

        $this->belongsTo("role_id", "Role", "id", NULL);
        $this->belongsTo("user_id", "User", "id", NULL);

    }
}
