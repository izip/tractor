<?php
use \Phalcon\Mvc\Router;
class ControllerBase extends Phalcon\Mvc\Controller
{

    protected function initialize()
    {



//        $this->assets->collection('base')
//            ->addJs('js/jquery-1.11.1.min.js')
//            ->addJs('js/underscore-min.js')
//            ->addJs('js/jquery.form.js')
//            ->addJs('js/jquery.MultiFile.js')
//            ->addJs('js/jquery.b2r.js')
//            ->addJs('js/jquery.noty.packaged.min.js')
//            ->addJs('js/jquery.mmenu.min.all.js')
//            ->addJs('js/jquery.response.js')
//            ->addJs('js/jquery-scrolltofixed-min.js')
//            ->addJs('js/option.js')
//            ->join(true)
//            ->addFilter(new Phalcon\Assets\Filters\Jsmin())
//            ->setTargetPath('js/base.js')
//            ->setTargetUri('js/base.js');
//
//        $this->assets->collection('baseCSS')
//
//            ->addCss('css/style.css')
//            ->join(true)
//            ->addFilter(new Phalcon\Assets\Filters\Cssmin())
//            ->setTargetPath('css/base.css')
//            ->setTargetUri('css/base.css');


        $this->flashSession->output();

    }

    protected function forward($uri){

        $uriParts = explode('/', $uri);
    	return $this->dispatcher->forward(
    		array(
    			'controller' => $uriParts[0],
    			'action' => $uriParts[1]
    		)
    	);
    }
}
