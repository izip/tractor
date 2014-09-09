<?php




class FieldType extends \Phalcon\Mvc\Model
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

    public $category_id;
    public $dtype;
    public $pref;
     



    public function initialize()
    {

    $this->hasMany("id" , "DannOffers" , "field_type_id");
    $this->hasMany("id" , "DannProposal" , "field_type_id");
        $this->hasManyToMany(
            "id",
            "CategoriesHasFieldType",
            "field_type_id", "categories_id",
            "Categories",
            "id"
        );

    }

     
}
