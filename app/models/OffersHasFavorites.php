<?php




class OffersHasFavorites extends \Phalcon\Mvc\Model
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
    public $favorites_id;

    public function initialize()
    {
        $this->belongsTo("offers_id", "Offers", "id", NULL);
        $this->belongsTo("favorites_id", "Favorites", "id", NULL);



    }


     
}
