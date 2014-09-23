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

        print_r($_POST);
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
            if($key_field == 'password'){


            }
            if($key_field == 'phone'){


            }
            if($key_field == 'location'){


            }
            if($key_field == 'adress'){


            }
            if($key_field == 'country'){


            }
            if($key_field == 'organization'){


            }
            if($key_field == 'profession'){


            }
            if($key_field == 'sex'){


            }
            if($key_field == 'vkontakte'){


            }
            if($key_field == 'facebook'){


            }
            if($key_field == 'icq'){


            }
            if($key_field == 'skype'){


            }
            if($key_field == 'birthdate'){


            }




        }

        $user->save();

    }

}
?>