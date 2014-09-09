<?php




class Favorites extends \Phalcon\Mvc\Model
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
    public $user_id;
     
    /**
     *
     * @var string
     */


    public $creation_date;

    public function initialize()
    {
        $this->belongsTo("user_id", "User", "id" , array(
                "foreignKey" => true)
        );


        $this->hasManyToMany(
            "id",
            "OffersHasFavorites",
            "favorites_id", "offers_id",
            "Offers",
            "id"
        );

        $this->hasManyToMany(
            "id",
            "ProposalHasFavorites",
            "favorites_id", "proposal_id",
            "Proposal",
            "id"
        );



    }

     
}
