<?php




class OffersHasFieldTypeOffers extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $offers_id;
     
    /**
     *
     * @var integer
     */
    public $field_type_offers_id;

    public function initialize()
    {
        $this->belongsTo("offers_id", "Offers", "id", NULL);
        $this->belongsTo("field_type_offers_id", "FieldTypeOffers", "id", NULL);



    }
     
}
