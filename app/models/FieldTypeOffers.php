<?php




class FieldTypeOffers extends \Phalcon\Mvc\Model
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
    public $offers_id;
     
    /**
     *
     * @var string
     */
    public $creation_date;

    public function initialize()
    {
        $this->hasManyToMany(
            "id",
            "OffersHasFieldTypeOffers",
            "field_type_offers_id",
            "offers_id",
            "Offers",
            "id"
        );

    }
     
}
