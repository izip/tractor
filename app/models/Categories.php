<?php




class Categories extends \Phalcon\Mvc\Model
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

    public $id_sub;

    public function initialize()
    {
        $this->hasMany("id", "Offers", "category_id",  NULL);
        $this->hasMany("id", "Proposal", "category_id" , NULL);
        $this->hasManyToMany(
            "id",
            "CategoriesHasFieldType",
            "categories_id", "field_type_id",
            "FieldType",
            "id"
        );

    }


}
