<?php


use Phalcon\Mvc\Model\Validator\Email as Email;

class User extends \Phalcon\Mvc\Model
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
    public $first_name;
     
    /**
     *
     * @var string
     */
    public $last_name;
     
    /**
     *
     * @var string
     */
    public $patronym;
     
    /**
     *
     * @var string
     */
    public $email;
     
    /**
     *
     * @var string
     */
    public $password;
     
    /**
     *
     * @var string
     */
    public $phone;
     
    /**
     *
     * @var string
     */
    public $time_zone;
     
    /**
     *
     * @var string
     */
    public $location;

    /**
     *
     * @var string
     */

    public $adress;
     
    /**
     *
     * @var string
     */
    public $country;
     
    /**
     *
     * @var string
     */
    public $active;
     
    /**
     *
     * @var string
     */

    public $organization;

    /**
     *
     * @var string
     */
   public $profession;
    /**
     *
     * @var string
     */
    public $last_login;
     
    /**
     *
     * @var string
     */
    public $date_register;
     
    /**
     *
     * @var string
     */
    public $sex;
     
    /**
     *
     * @var string
     */
    public $vkontakte;
     
    /**
     *
     * @var string
     */
    public $facebook;
     
    /**
     *
     * @var string
     */
    public $icq;
     
    /**
     *
     * @var string
     */
    public $skype;
     
    /**
     *
     * @var string
     */
    public $comment;
     
    /**
     *
     * @var string
     */
    public $birthdate;
     
    /**
     *
     * @var string
     */
    public $forget_hash;
     
    /**
     *
     * @var string
     */
    public $fh_expire_date;
     
    /**
     *
     * @var string
     */
    public $receive_sms;
     
    /**
     *
     * @var string
     */
    public $photo_large;
     
    /**
     *
     * @var string
     */
    public $photo_medium;
     
    /**
     *
     * @var string
     */
    public $photo_avatar;
     
    /**
     *
     * @var string
     */
    public $sc_dir;
     
    /**
     *
     * @var string
     */
    public $profile_change_time;
     
    /**
     *
     * @var string
     */
    public $profile_checked;
     
    /**
     *
     * @var string
     */
    public $date_block;
     
    /**
     *
     * @var string
     */
    public $block_reason;
     
    /**
     *
     * @var string
     */
    public $session_id;
     
    /**
     *
     * @var string
     */
    public $reg_ip;
     
    /**
     *
     * @var string
     */
    public $phone_checked;
     
    /**
     *
     * @var string
     */
    public $sms_allow;
     
    /**
     * Validations and business logic
     */
    public function validation()
    {

        $this->validate(
            new Email(
                array(
                    "field"    => "email",
                    "required" => true,
                )
            )
        );
        if ($this->validationHasFailed() == true) {
            return false;
        }
    }

    public function initialize()
    {
        $this->hasMany("id", "Offers", "user_id",  NULL);
       $this->hasMany("id", "Proposal", "user_id" , NULL);
        $this->hasMany("id", "Notices", "user_id" , NULL);
        $this->hasMany("id", "Errors", "user_id" , NULL);
        $this->hasMany("id", "Comments", "reciever_id" , NULL);
        $this->hasMany("id", "Favorites", "user_id" , NULL);
        $this->hasMany("id", "Message", "author_id" , NULL);
        $this->hasMany("id", "MessageChat", "author_id" , NULL);

        $this->hasManyToMany(
            "id",
            "UserRole",
            "user_id", "role_id",
            "Role",
            "id"
        );

        $this->hasManyToMany(
            "id",
            "DialogsHasUser",
            "user_id", "dialogs_id",
            "Dialogs",
            "id"
        );
        $this->hasManyToMany(
            "id",
            "ChatHasUser",
            "user_id", "chat_id",
            "Chat",
            "id"
        );


    }


}
