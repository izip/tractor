<?php

use Phalcon\Mvc\View;


class OrdersController extends ControllerBase
{

    public function initialize()
    {
        $this->view->setTemplateAfter('main');
        parent::initialize();
    }

    public function indexAction()
    {
        if ($this->request->hasPost('od') && $this->request->getPost('od') == 'y') {
            $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
        }
        $zap ='';

        if ($this->request->hasPost('cat_id') && $this->request->isAjax()) {

            $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
            $cat_id = $this->request->getPost('cat_id');


            if(isset($cat_id) && is_numeric($cat_id)){
                if($this->request->hasPost('sub-cat')){
                    $zap =  "id = {$cat_id}";
                    $c_cat = 1;
                }
                else{
                    $zap =  "id = {$cat_id} or id_sub = {$cat_id}";
                    $c_cat = 1;
                }


                foreach(Categories::find(array("{$zap}")) as $csv )
                {

                    $c_cat =$c_cat + $csv->proposal->count();

                }

                if( $c_cat == 1){
                    $this->view->disable();
                    echo 1;
                    die();
                }
            }
        }

            foreach(Categories::find("{$zap}")as $cat){

            foreach ($cat->proposal as $prop) {

                foreach ($prop->dannproposal as $dann) {
                    $props[$prop->id][$dann->fieldtype->id] = $dann->dann;
                    $props[$prop->id]['cat'] = $prop->categories->name;

                }
            }
            }

            $this->view->setVars(array(
                'cl' => count($cat->proposal),
                'prop' => $props = (isset($props)) ? $props :false

            ));


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
                    'user_name' => $user = (isset($prop->user->first_name))? $prop->user->first_name: false,
                    'user_id' => $user_id = (isset($prop->user->id))? $prop->user->id: false,
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

    public function commentsAction()
    {
        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);

        if ($this->request->hasPost('comm') && $this->request->hasPost('order') && $this->request->isAjax()) {

            $comments = new Comments();
            $comments->proposal_id = $this->request->getPost('order');
            $comments->reciever_id = $this->session->get('user_id');
            $comments->text = $this->request->getPost('comm');
            $comments->creation_date = date("Y-m-d-H-i-s");
            $comments->save();


            $prop = Proposal::findFirst($this->request->getPost('order'));


            foreach ($prop->comments as $comm) {

                $com[$comm->id] = array(
                    $comm->user->first_name,
                    $comm->text,
                    $comm->creation_date
                );

            }
            $this->view->setVars(array(
                'comm' => $com

            ));


        }


    }


}


?>