<?php




class DannProposal extends \Phalcon\Mvc\Model
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
    public $dann;
     
    /**
     *
     * @var integer
     */
    public $proposal_id;



    public $field_type_id;
    public $active;

    public function initialize() {

        $this->belongsTo("proposal_id", "Proposal", "id" , array(
                "foreignKey" => true)
        );

        $this->belongsTo("field_type_id" , "FieldType" , "id");
    }

     
}
