<?php




class CategoriesHasFieldType extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $categories_id;

    /**
     *
     * @var integer
     */
    public $field_type_id;

    public function initialize()
    {
        $this->belongsTo("categories_id", "Categories", "id", NULL);
        $this->belongsTo("field_type_id", "FieldType", "id", NULL);



    }



}
