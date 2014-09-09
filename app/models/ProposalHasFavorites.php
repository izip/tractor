<?php




class ProposalHasFavorites extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $proposal_id;
     
    /**
     *
     * @var integer
     */
    public $favorites_id;

    public function initialize()
    {
        $this->belongsTo("proposal_id", "Proposal", "id", NULL);
        $this->belongsTo("favorites_id", "Favorites", "id", NULL);



    }
     
}
