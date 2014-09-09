<?php
use Phalcon\Mvc\View,
    Phalcon\Mvc\Model\Query;


class CronController extends ControllerBase
{
    public function initialize()
    {
        $this->view->setTemplateAfter('main');


        Phalcon\Tag::setTitle('MashinoSmena.ru');
        parent::initialize();
    }

    public function indexAction()
    {



    }

}
//        $this->load->library('crontab');
//      $cron =  new Crontab();
//      $cron->on('* * * * *')->doJob("usr/bin/php ".$_SERVER["DOCUMENT_ROOT"]."/test.php >/dev/null 2>&1");
//
//
//        $cron->activate();
//       echo $cron->listJobs();