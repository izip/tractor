<?php




class Proposal extends \Phalcon\Mvc\Model
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
     * @var integer
     */
    public $category_id;
     

    public $creation_date;
    public $price_hour;
    public $date_from;
    public $date_to;
    public $status;
    public $text;



    public function initialize()
    {
        $this->belongsTo("user_id", "User", "id" , array(
                "foreignKey" => true)
        );

        $this->belongsTo("category_id", "Categories", "id" , array(
                "foreignKey" => true)
        );


        $this->hasMany("id","Comments","proposal_id");

        $this->hasMany("id","DannProposal","proposal_id");
        $this->hasManyToMany(
            "id",
            "ProposalHasFavorites",
            "proposal_id", "favorites_id",
            "Favorites",
            "id"
        );


    }

}
