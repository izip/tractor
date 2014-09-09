<?php




class DannOffers extends \Phalcon\Mvc\Model
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
    public $offers_id;
    public $field_type_id;
    public $active;

    public function initialize() {

    $this->belongsTo("offers_id", "Offers", "id" , array(
    "foreignKey" => true)
    );
        $this->belongsTo("field_type_id" , "FieldType" , "id");

    }
}
