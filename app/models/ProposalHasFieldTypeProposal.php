<?php




class ProposalHasFieldTypeProposal extends \Phalcon\Mvc\Model
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
    public $field_type_proposal_id;


    public function initialize()
    {
        $this->belongsTo("proposal_id", "Proposal", "id", NULL);
        $this->belongsTo("field_type_proposal_id", "FieldTypeProposal", "id", NULL);



    }


     
}
