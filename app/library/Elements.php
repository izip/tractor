<?php

use Phalcon\Mvc\Controller,
    Phalcon\Mvc\View;

class Elements extends Phalcon\Mvc\User\Component
{



    public function getmenu()
    {
        $text = '';
        $ty = Categories::find(array("id_sub = 0"));
        $text .= '<li ><a data-cat="all">Все </a> </li>';
        foreach ($ty->toArray() as $category) {



            $text .= '<li ><a data-cat="'.$category['id'].'">'.
               $category['name'].' </a> </li>';

        }

        return $text;
}

    public function getsubmenu()
    {
        $text = '';
        $tyc = Categories::find(array("id_sub > 0"));

        foreach ($tyc->toArray() as $category) {



            $text .= '<li ><a data-cat="'.$category['id'].'" sub-cat="'.$category['id_sub'].'">'.
                $category['name'].' </a> </li>';

        }

        return $text;
    }

    function generate_password($number)
    {
        $arr = array('a','b','c','d','e','f',
            'g','h','i','j','k','l',
            'm','n','o','p','r','s',
            't','u','v','x','y','z',
            'A','B','C','D','E','F',
            'G','H','I','J','K','L',
            'M','N','O','P','R','S',
            'T','U','V','X','Y','Z',
            '1','2','3','4','5','6',
            '7','8','9','0');
        // Генерируем пароль
        $pass = "";
        for($i = 0; $i < $number; $i++)
        {
            // Вычисляем случайный индекс массива
            $index = rand(0, count($arr) - 1);
            $pass .= $arr[$index];
        }
        return $pass;
    }

    public function sms_send ($phone , $mess) {


        $zapr = array ('login'=>'raidhon', 'psw'=>'rt45rt46rt47' , 'phones'=> $phone , 'mes' =>$mess ,'charset'=>'UTF-8');
        $zapr = http_build_query($zapr);
        $ch = curl_init('http://my.smscab.ru/sys/send.php');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $zapr);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        $result = curl_exec($ch); // выполняем запрос curl
        curl_close($ch);


    }

    public function email_send ($email , $subject, $mess) {


        $to =  $email;
          $headers = "From: techagregator.ru <$to>\r\nContent-type: text/html; charset=UTF-8 \r\n";
        mail ($to, $subject, $mess, $headers);


    }


    public function var_print($r) {

        echo "<pre>"; var_dump($r); echo "</pre>";

    }


    public function dir_valid($user_id) {

        if (file_exists($_SERVER['DOCUMENT_ROOT'].'/public/upload/users')) {
        } else {
            mkdir($_SERVER['DOCUMENT_ROOT'].'/public/upload/users');
        }

        if (file_exists($_SERVER['DOCUMENT_ROOT'].'/public/upload/users/user-'.$user_id)) {
        } else {
            mkdir($_SERVER['DOCUMENT_ROOT'].'/public/upload/users/user-'.$user_id);
        }

        if (file_exists($_SERVER['DOCUMENT_ROOT'].'/public/upload/users/user-'.$user_id.'/offers')) {
        } else {
            mkdir($_SERVER['DOCUMENT_ROOT'].'/public/upload/users/user-'.$user_id.'/offers');
        }



    }

    public function delete($arg){
        $d=opendir($arg);
        while($f=readdir($d)){
            if($f!="."&&$f!=".."){
                if(is_dir($arg."/".$f))
                    delete($arg."/".$f);
                else
                    unlink($arg."/".$f);
            }
        }
        rmdir($arg);
    }

    public function widget($controllerName,$actionName)
    {

        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);

        $this->view->start();

        $this->view->render($controllerName, $actionName);

        $this->view->finish();

        $this->view->setRenderLevel(View::LEVEL_MAIN_LAYOUT);

        return $this->view->getContent();
    }




}