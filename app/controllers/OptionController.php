<?php
use Phalcon\Mvc\View,
    Phalcon\Mvc\Model\Query;

class OptionController extends ControllerBase
{

    public function initialize()
    {
        $this->view->setTemplateAfter('main');


        Phalcon\Tag::setTitle('MashinoSmena.ru');
        parent::initialize();
    }


    public function indexAction()
    {

        if ($this->session->has('user_id')) {

            $user = User::findFirst($this->session->get('user_id'));


            // echo '<pre>'; print_r($user->toArray());echo '</pre>';

            $this->view->setVars(array(
                'user_field' => $user->toArray()

            ));
        }

    }


    public function contactAction()
    {
        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
        if ($this->session->has('auth')) {

            $user = User::findFirst($this->session->get('user_id'));

            $this->view->setVars(array(
                'user_id' => $id = $user->id,
                'first_name' => $name = (isset($user->first_name)) ? $user->first_name : false,
                'organization' => $org = (isset($user->organization)) ? $user->organization : false,
                'profession' => $profession = (isset($user->profession)) ? $user->profession : false,
                'phone' => $phone = (isset($user->phone)) ? $user->phone : false,
                'email' => $email = (isset($user->email)) ? $user->email : false,
                'country' => $country = (isset($user->country)) ? $user->country : false,
                'adress' => $adress = (isset($user->adress)) ? $user->adress : false,


            ));

        }



}


    public function confirmAction() {
        $this->view->disable();

       // print_r($_POST);
        $user_id = $this->session->get('user_id');
        $user =  User::findFirst($user_id);
        foreach($_POST as $key_field => $field){
            if($key_field == 'first_name' && strlen($field) >3){

            $user->first_name = $field;
            }

            if($key_field == 'last_name' && strlen($field) >3){

                $user->last_name = $field;
            }

            if($key_field == 'patronym'){

                $user->patronym = $field;
            }
            if($key_field == 'email'){

                $user->email = $field;
            }

            if($key_field == 'password' && strlen($field) >= 3){

               // echo strlen($field);
                $user->password = $this->security->hash($field);
            }


            if($key_field == 'phone'){

                $user->phone = $field;
            }
            if($key_field == 'location'){
                $user->location = $field;

            }
            if($key_field == 'adress'){

                $user->adress = $field;
            }
            if($key_field == 'country'){

                $user->country = $field;
            }
            if($key_field == 'organization'){
                $user->organization = $field;

            }
            if($key_field == 'profession'){
                $user->profession = $field;

            }
            if($key_field == 'sex'){
                $user->sex = $field;

            }
            if($key_field == 'vkontakte'){

                $user->vkontakte = $field;
            }
            if($key_field == 'facebook'){
                $user->facebook = $field;

            }
            if($key_field == 'icq'){
                $user->icq = $field;

            }
            if($key_field == 'skype'){
                $user->skype = $field;

            }
            if($key_field == 'birthdate'){

                $user->birthdate = $field;
            }




        }

        if($user->save()){
            echo json_encode(array('success' =>'Ваши данные сохранены !'));

        }
            else{

                echo json_encode(array('error' =>'Ошибка сохранения !'));
            }
    }

}
?>