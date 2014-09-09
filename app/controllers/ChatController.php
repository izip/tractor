<?php


use Phalcon\Mvc\View;

class ChatController extends ControllerBase
{


    public function initialize()
    {
        $this->view->setTemplateAfter('main');


        Phalcon\Tag::setTitle('MashinoSmena.ru');
        parent::initialize();
    }

    public function indexAction()
    {
       // $this->view->disable();
        if ($this->session->has('user_id')) {
    $user_id = $this->session->get('user_id');
        }

       $user =  User::findFirst($user_id);

        foreach($user->chat as $chat){


                $chats[$chat->id] = $chat->toArray();

        }

       // echo '<pre>'; print_r($mes); echo '</pre>';


        $this->view->setVars(array(
            'user_id' => $user->id,
            'chat_col' => $chat->count(),

            'chats' => $chats

        ));

    }



    public function chatAction() {

        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);


        if($this->request->hasPost('chat_id')){

        $chat = Chat::findFirst($this->request->getPost('chat_id'));


            if( $chatmicrodialog = $chat->chatmicrodialog){


            foreach($chatmicrodialog as $micro){


                foreach($micro->messagechat as $mess){
                    if($mess->id == $micro->base_mess_id){

                        $microd[$micro->id]['base'] = $mess->toArray();
                    }
                    else{

                        $microd[$micro->id]['mess'][] = $mess->toArray();

                    }


                }


            }

            //  echo '<pre>';  print_r($microd); echo '<pre>';
            }


            $this->view->setVars(array(
                'chat' => $microd = (isset($microd))? $microd:false

            ));

        }


    }

    public function addchatAction(){

        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);


    }
    public function addchatconfirmAction(){
        $this->view->disable();

        print_r($_POST);
       $user_id = $this->session->get('user_id');
        if(isset($_POST['type_chat_mess']) && $_POST['form']['title'] && $_POST['form']['text']){

            $chat = new Chat();
            $chu = new ChatHasUser();
            $micro = new ChatMicroDialog();
            $mess = new MessageChat();

            $chat->title = $_POST['form']['chat_title'];

        }




    }



    public function addmessAction(){

    $this->view->disable();


    }

    public function delchatAction(){
        $this->view->disable();


    }


    public function chat_userAction(){
        $this->view->disable();

        if(isset($_POST['chat_id'])){

            $chat = Chat::findFirst($_POST['chat_id']);
                  $user =   User::findFirst($chat->created_id);
            echo json_encode(array(
                'user_id' => $user->id,
                'user_name' => $user->first_name

            ));

        }



    }


}


?>