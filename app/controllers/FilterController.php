<?php

use Phalcon\Mvc\View;


class FilterController extends ControllerBase
{
    public function initialize()
    {
        $this->view->setTemplateAfter('main');


        Phalcon\Tag::setTitle('MashinoSmena.ru');
        parent::initialize();
    }


    public function indexAction()
    {
        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);


//         $f = FieldType::findFirst(18);
//        $f->dtype = serialize(array("Гусеничный" ,"Колесный"));
//            $f->save();

        foreach (FieldType::find() as $fl) {
            if ($fl->id == 4) {
                $field[$fl->id] = array('', '', $fl->name, $fl->dtype, $fl->pref);
            }
        }
        $cat = Categories::findFirst();
        if ($cat->fieldtype->count() > 0) {
            foreach ($cat->fieldtype as $fiel) {
                $field[$fiel->id] = array($cat->id, $cat->name, $fiel->name, $fiel->dtype, $fiel->pref);

            }
        }


        foreach (Categories::find(array("id_sub = {$cat->id}")) as $cate) {

            $subcat[] = array($cate->id, $cate->name);
            foreach ($cate->fieldtype as $fies) {

                $field[$fies->id] = array($cat->id, $cat->name, $fies->name, $fies->dtype, $fies->pref);

            }

        }




        $this->view->setVars(array(
            'cat' => $cat = (isset($cat->id)) ? $cat->id : false,
            'field' => $field = (isset($field)) ? $field : false,
            'subcat' => $subcat = (isset($subcat)) ? $subcat : false
        ));

    }

    public function filterAction()
    {


        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
        if ($this->request->hasPost('cat_id') && $this->request->isAjax()) {


            if (is_numeric($this->request->getPost('cat_id')) && Categories::count(array("id_sub = {$this->request->getPost('cat_id')}")) > 0) {
                foreach (Categories::find(array("id_sub = {$this->request->getPost('cat_id')}")) as $cat) {

                    $sub_cat[] = array($cat->id, $cat->name);


                }
                $this->view->setVars(array(
                    'cat_name' => $sub_cat = (isset($sub_cat)) ? $sub_cat : false

                ));
            } else {
                $this->view->disable();
                echo 1;
            }

        }


    }


    public function setplaceAction()
    {

        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
        if (is_numeric($this->request->getPost('cat_id')) && $this->request->hasPost('cat_id') && $this->request->isAjax()) {
            $cat_id = $this->request->getPost('cat_id');

            foreach (FieldType::find() as $fl) {
                if ($fl->id == 4) {
                    $field[$fl->id] = array($fl->name, $fl->dtype, $fl->pref);
                }
            }
            if(!$this->request->hasPost('sub')){
            foreach (Categories::find(array("id ={$cat_id} or id_sub ={$cat_id}")) as $categ) {

                foreach ($categ->fieldtype as $fil) {
                    if(strpos($fil->dtype,"a:" ) !== false){
                        $field[$fil->id] = array($fil->name, unserialize($fil->dtype), $fil->pref);
                    }
                    else{


                        $field[$fil->id] = array($fil->name, $fil->dtype, $fil->pref);
                    }
                }

            }
            }
            else{
                $ct = Categories::findFirst($cat_id)->id_sub;
                foreach (Categories::find(array("id ={$ct} or id ={$cat_id}")) as $categ) {

                    foreach ($categ->fieldtype as $fil) {
                        if(strpos($fil->dtype,"a:" ) !== false){
                        $field[$fil->id] = array($fil->name, unserialize($fil->dtype), $fil->pref);
                        }
                        else{


                            $field[$fil->id] = array($fil->name, $fil->dtype, $fil->pref);
                        }
                    }

                }

            }



            $this->view->setVars(array(
                'field' => $field = (isset($field)) ? $field : false

            ));

        }
        else{
            $this->view->setVars(array(
                'field' => $field = (isset($field)) ? $field : false

            ));
        }


    }

    public function filterformAction()
    {
    $this->view->disable();
        //$this->elements->var_print($this->request->getPost());
      $this->modelsCache->save('filter-'.$this->session->get('user_id') ,$this->request->getPost(),3600 );
        echo 1;
    }


}

?>