<?php




class FieldTypeProposal extends \Phalcon\Mvc\Model
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
     * @var string
     */
    public $data;
     
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
        $this->hasManyToMany(
            "id",
            "ProposalHasFieldTypeProposal",
            "field_type_proposal_id",
            "proposal_id",
            "Proposal",
            "id"
        );

    }

}
