<?php




class Comments extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;
     
    /**
     *
     * @var integer
     */
    public $offers_id;
     
    /**
     *
     * @var string
     */
    public $text;

     public $reciever_id;
    /**
     *
     * @var integer
     */
    public $proposal_id;
     
    /**
     *
     * @var string
     */
    public $creation_date;


    public function initialize()
    {
        $this->belongsTo("offers_id", "Offers", "id" , null);
        $this->belongsTo("proposal_id", "Proposal", "id" , null);

        $this->belongsTo("reciever_id", "User", "id" , array(
                "foreignKey" => true)
        );

    }
     
}
