<?php

use Phalcon\Mvc\View;


class MyordersController extends ControllerBase
{

    public function initialize()
    {
        $this->view->setTemplateAfter('main');


        Phalcon\Tag::setTitle('MashinoSmena.ru');
        parent::initialize();
    }


    public function indexAction()
    {
        if ($this->request->hasPost('od') && $this->request->getPost('od') == 'y') {
            $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
        }
        if ($this->session->has('user_id')) {

            $user_id = $this->session->get('user_id');
            $user = User::findFirst($user_id);

            foreach ($user->proposal as $prop) {

                foreach ($prop->dannproposal as $dann) {
                    $props[$prop->id][$dann->fieldtype->id] = $dann->dann;
                    $props[$prop->id]['cat'] = $prop->categories->name;

                }
            }


            $this->view->setVars(array(

                'cl' => count($user->proposal),
                'prop' => $props = (isset($props)) ? $props :false

            ));

        }


    }


    public function orderAction()
    {
        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);

        if ($this->request->hasPost('order') && $this->request->isAjax()) {

            $prop = Proposal::findFirst($this->request->getPost('order'));
            if (count($prop) > 0) {
                if (count($prop->dannproposal) > 0) {
                    foreach ($prop->dannproposal as $dann) {

                        $order[$prop->id][$dann->fieldtype->id] = $dann->dann;


                    }
                }

                if (count($prop->comments) > 0) {
                    foreach ($prop->comments as $comm) {
                        $com[$comm->id] = array($comm->user->first_name, $comm->text, $comm->creation_date);
                    }
                }


                $this->view->setVars(array(
                    'order_id' => $pr = (isset($prop->id)) ? $prop->id : false,
                    'order' => $order = (isset($order)) ? $order : false,
                    'order_name' => $name = (isset($prop->name)) ? $prop->name : false,
                    'order_text' => $text = (isset($prop->text)) ? $prop->text : false,
                    'order_cat' => $cat_name = (isset($prop->categories->name)) ? $prop->categories->name : false,
                    'comm' => $com = (isset($com)) ? $com : false
                ));
            }
        }
    }


    public function addorderAction()
    {
        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
        if($this->request->isAjax()){
            $cat_id = Categories::findFirst()->id;
          foreach(Categories::find(array("id_sub = 0")) as $cat){

              $cat_dann[$cat->id] = $cat->name;

          }

            if(count(Categories::find(array("id_sub = {$cat_id}")))>0){
                foreach(Categories::find(array("id_sub = {$cat_id}")) as $categ){

                    $sub_cat[$categ->id] = $categ->name;
                }

            }
            $this->view->setVars(array(
                'cat' => $cat_dann = (isset($cat_dann)) ? $cat_dann:false,
                'sub_cat' => $sub_cat = (isset($sub_cat)) ? $sub_cat:false
            ));
        }


    }


    public function subcatAction(){

        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
        if($this->request->hasPost('cat_id') && $this->request->isAjax()){

            $cat_id = $this->request->getPost('cat_id');
            foreach(Categories::find(array("id_sub = {$cat_id}")) as $categ){
                $sub_cat[$categ->id] = $categ->name;

            }


            $this->view->setVars(array(
                'sub_cat' => $sub_cat = (isset($sub_cat)) ? $sub_cat :false

            ));
        }
    }


    public function redorderAction()
    {

        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
        if ($this->request->hasPost('order') && $this->request->isAjax()) {

            $prop = Proposal::findFirst($this->request->getPost('order'));


            if (count($prop->dannproposal) > 0) {
                foreach ($prop->dannproposal as $dann) {

                    $dan[$dann->fieldtype->id] = $dann->dann;

                }
            }
            $categories = $prop->categories;
            $cat_id = $prop->categories->id;

            foreach(Categories::find(array("id_sub = 0")) as $cat){

                $cat_dann[$cat->id] = $cat->name;

            }
            if($prop->categories->id_sub == 0){
                $par_cat = $cat_id;
                if(count(Categories::find(array("id_sub = {$cat_id}")))>0){
                    foreach(Categories::find(array("id_sub = {$cat_id}")) as $categ){

                        $sub_cat[$categ->id] = $categ->name;
                    }

                }
            }
            else{

                if(count(Categories::find(array("id = {$categories->id_sub}")))>0){
                    $categ =  Categories::findFirst(array("id = {$categories->id_sub}"));
                        foreach(Categories::find(array("id_sub = {$categ->id}")) as $cate){
                        $sub_cat[$cate->id] = $cate->name;
                        }
                    $par_cat = $categ->id;
                 //   $this->elements->var_print($sub_cat);
                }

            }

            $this->view->setVars(array(
                'order_id' => $id = (isset($prop->id)) ? $prop->id: false,
                'par_cat' => $par_cat = (isset($par_cat)) ? $par_cat:false,
                'cat_id' => $cat_id = (isset($cat_id)) ? $cat_id:false,
                'cat' => $cat_dann = (isset($cat_dann)) ? $cat_dann:false,
                'sub_cat' => $sub_cat = (isset($sub_cat)) ? $sub_cat:false,
                'price_hour' => $price = (isset($prop->price_hour)) ? $prop->price_hour: false,
                'date_to' => $date = (isset($prop->date_to)) ? $prop->date_to :false,
                'date_from' => $date = (isset($prop->date_from)) ? $prop->date_from :false,
                'text' => $text = (isset($prop->text)) ? $prop->text :false,
                'dann' => $dan = (isset($dan)) ? $dan :false,


            ));

        }


    }




    public function addorderformAction()
    {
        $this->view->disable();

        if ($this->security->checkToken()) {
            ///  $this->elements->var_print($_POST);

            function valid_order()
            {

                $sub_mess = '';


                if (!isset($_POST['name-tex']) || strlen($_POST['name-tex']) < 3) {

                    $sub_mess['name-tex'] = "Не корректно заполнено поле Вид техники !";

                }

                if (!isset($_POST['city-tex']) || strlen($_POST['city-tex']) < 3) {

                    $sub_mess['city-tex'] = "Не корректно заполнено поле Город !";

                }

                if (!isset($_POST['price-tex']) || strlen($_POST['city-tex']) < 3) {

                    $sub_mess['price-tex'] = "Не заполнено поле Цена !";

                }

                if (!isset($_POST['price-usd'])) {

                    $sub_mess['price-usd'] = "Попытка подделки формы !";

                }
                if (!isset($_POST['date-to-tex']) || strlen($_POST['date-to-tex']) < 3) {

                    $sub_mess['date-to-tex'] = "Не заполнено поле Дата начала показа!";

                }
                if (!isset($_POST['date-from-tex']) || strlen($_POST['date-from-tex']) < 3) {

                    $sub_mess['date-from-tex'] = "Не заполнено поле Дата окончания показа!";

                }
                if (!isset($_POST['text-tex']) || strlen($_POST['text-tex']) < 3) {

                    $sub_mess['text-tex'] = "Не заполнено поле Описание !";

                }


                if (is_array($sub_mess)) {
                    echo json_encode($sub_mess);
                    return false;
                } else {

                    return true;

                }


            }

            if (valid_order()) {
                if($this->request->hasPost('order_id')){

                    $prop = Proposal::findFirst($this->request->getPost('order_id'));
                }
                else{
                    $prop = new Proposal();

                }

                $prop->user_id = $this->session->get('user_id');
                if($this->request->hasPost('sub_cat_id')){
                $prop->category_id = $this->request->getPost('sub_cat_id');
                }
                else{
                    $prop->category_id = $this->request->getPost('cat_id');
                }
                $prop->creation_date = date('Y-m-d-H-i-s');
                $prop->date_to = $this->request->getPost('date-to-tex');
                $prop->date_from = $this->request->getPost('date-from-tex');
                $prop->text = $this->request->getPost('text-tex');
                $prop->price_hour = $this->request->getPost('price-usd');

                if ($this->request->hasPost('public') && $this->request->getPost('public') == 'y') {

                    $prop->status = 1;
                }
                $prop->save();


                if ($this->request->hasPost('name-tex')) {
                    if($this->request->hasPost('order_id')){

                        $dann = DannProposal::findFirst(array("proposal_id = {$prop->id} and field_type_id = 22"));
                        if(isset($dann->id)){
                        $dann->dann = $this->request->getPost('name-tex');
                        $dann->proposal_id = $prop->id;
                        $dann->field_type_id = 22;
                        $dann->active = 1;
                        $dann->save();
                        }
                        else{

                            $dann = new DannProposal();
                            $dann->dann = $this->request->getPost('name-tex');
                            $dann->proposal_id = $prop->id;
                            $dann->field_type_id = 22;
                            $dann->active = 1;
                            $dann->save();

                        }
                    }
                    else{
                    $dann = new DannProposal();
                    $dann->dann = $this->request->getPost('name-tex');
                    $dann->proposal_id = $prop->id;
                    $dann->field_type_id = 22;
                    $dann->active = 1;
                    $dann->save();
                    }

                }
                if ($this->request->hasPost('city-tex')) {
                    if($this->request->hasPost('order_id')){

                        $dann = DannProposal::findFirst(array("proposal_id = {$prop->id} and field_type_id = 4"));
                        if(isset($dann->id)){
                            $dann->dann = $this->request->getPost('city-tex');
                            $dann->proposal_id = $prop->id;
                            $dann->field_type_id = 4;
                            $dann->active = 1;
                            $dann->save();
                        }
                        else{

                            $dann = new DannProposal();
                            $dann->dann = $this->request->getPost('city-tex');
                            $dann->proposal_id = $prop->id;
                            $dann->field_type_id = 4;
                            $dann->active = 1;
                            $dann->save();

                        }
                    }
                    else{
                        $dann = new DannProposal();
                        $dann->dann = $this->request->getPost('city-tex');
                        $dann->proposal_id = $prop->id;
                        $dann->field_type_id = 4;
                        $dann->active = 1;
                        $dann->save();
                    }

                }


                if ($this->request->hasPost('price-tex')) {
                    if($this->request->hasPost('order_id')){

                        $dann = DannProposal::findFirst(array("proposal_id = {$prop->id} and field_type_id = 5"));
                        if(isset($dann->id)){
                            $dann->dann = $this->request->getPost('price-tex');
                            $dann->proposal_id = $prop->id;
                            $dann->field_type_id = 5;
                            $dann->active = 1;
                            $dann->save();
                        }
                        else{

                            $dann = new DannProposal();
                            $dann->dann = $this->request->getPost('price-tex');
                            $dann->proposal_id = $prop->id;
                            $dann->field_type_id = 5;
                            $dann->active = 1;
                            $dann->save();

                        }
                    }
                    else{
                        $dann = new DannProposal();
                        $dann->dann = $this->request->getPost('price-tex');
                        $dann->proposal_id = $prop->id;
                        $dann->field_type_id = 5;
                        $dann->active = 1;
                        $dann->save();
                    }

                }



                echo json_encode(array('success' => "Предложение  добавлено", 'order_id' => $prop->id));
            }

        }
    }




    public function delorderAction()
    {
        $this->view->disable();
        if ($this->request->hasPost('order') && $this->request->isAjax()) {

            $prop = Proposal::findFirst($this->request->getPost('order'));
            foreach ($prop->dannproposal as $dann) {

                $dann->delete();
            }

            foreach ($prop->favorites as $fav) {
                foreach (ProposalHasFavorites::find(array("proposal_id = {$prop->id}")) as $favs) {

                    $favs->delete();
                }
                $fav->delete();
            }

            foreach ($prop->comments as $comm) {

                $comm->delete();

            }
            $prop->delete();
        }


    }




}


?>