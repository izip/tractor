<?php




class Offers extends \Phalcon\Mvc\Model
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
     * @var integer
     */
    public $user_id;
     
    /**
     *
     * @var integer
     */
    public $category_id;
     
    /**
     *
     * @var string
     */
    public $creation_date;
    public $text;
    public $image;
    public $status;

    public function initialize()
    {
        $this->belongsTo("user_id", "User", "id" ,  array(
            "foreignKey" => array(
                "message" => "id не может Модифицирован"
            )
        ));

        $this->belongsTo("category_id", "Categories", "id" ,  array(
            "foreignKey" => array(
                "message" => "id не может Модифицирован"
            )
        ));



        $this->hasMany("id","DannOffers","offers_id" ,  NULL);
        $this->hasMany("id","Comments","offers_id",  NULL);

        $this->hasManyToMany(
            "id",
            "OffersHasFavorites",
            "offers_id", "favorites_id",
            "Favorites",
            "id"
        );


    }
}
