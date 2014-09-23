<?php


use Phalcon\Mvc\View;

class ContactController extends ControllerBase
{


    public function initialize()
    {
        $this->view->setTemplateAfter('main');


        Phalcon\Tag::setTitle('MashinoSmena.ru');
        parent::initialize();
    }

    public function indexAction(){




    }

}