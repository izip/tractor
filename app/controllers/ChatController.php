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
        if ($this->request->isAjax() && $this->request->getPost('chat_list') == 'y') {

            $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
        }

        // $this->view->disable();
        if ($this->session->has('user_id')) {
            $user_id = $this->session->get('user_id');
        }



        foreach (Chat::find(array('order' => 'creation_date DESC' , 'limit' =>10)) as $chat) {


            $chats[$chat->id] = $chat->toArray();

        }

        // echo '<pre>'; print_r($mes); echo '</pre>';


        $this->view->setVars(array(

            'chat_col' => $chat->count(),

            'chats' => $chats

        ));

    }


    public function chatAction()
    {

        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);


        if ($this->request->hasPost('chat_id')) {

            $chat = Chat::findFirst($this->request->getPost('chat_id'));


            if ($chatmicrodialog = $chat->chatmicrodialog) {


                foreach ($chatmicrodialog as $micro) {


                    foreach ($micro->messagechat as $mess) {
                        if ($mess->id == $micro->base_mess_id) {

                            $microd[$micro->id]['base'] = $mess->toArray();
                        } else {

                            $microd[$micro->id]['mess'][] = $mess->toArray();

                        }


                    }


                }

                //  echo '<pre>';  print_r($microd); echo '<pre>';
            }


            $this->view->setVars(array(
                'chat' => $microd = (isset($microd)) ? $microd : false,
                'chat_id' => $this->request->getPost('chat_id')

            ));

        }


    }

    public function addchatAction()
    {

        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);


    }

    public function addchatconfirmAction()
    {
        $this->view->disable();

        // print_r($_POST);
        $user_id = $this->session->get('user_id');
        if ($this->request->isAjax() && isset($_POST['type_chat_mess']) && $_POST['form']['title'] && $_POST['form']['text']) {

            $chat = new Chat();
            $chu = new ChatHasUser();
            $micro = new ChatMicroDialog();
            $mess = new MessageChat();

            $chat->title = $_POST['form']['title'];
            $chat->created_id = $user_id;
            $chat->creation_date = date("Y-m-d-H-i-s");
            $chat->save();

            $chu->chat_id = $chat->id;
            $chu->user_id = $user_id;
            $chu->save();

            $mess->chat_id = $chat->id;
            $mess->text = $_POST['form']['text'];
            $mess->author_id = $user_id;
            $mess->type = $_POST['type_chat_mess'];
            $mess->creation_date = date("Y-m-d-H-i-s");
            $mess->save();

            $micro->chat_id = $chat->id;
            $micro->base_mess_id = $mess->id;
            $micro->creation_date = date("Y-m-d-H-i-s");
            $micro->save();

            $mess->micro_dialog_id = $micro->id;
            $mess->save();

            echo json_encode(array('message' => 'Тема создана', 'chat_id' => $chat->id));
        }
        else{
            echo  json_encode(array('error' => 'Заполните поле сообщения'));
        }


    }


    public function addmessAction()
    {

        $this->view->disable();

       // print_r($_POST);

        $user_id = $this->session->get('user_id');
        if( $this->request->getPost('text')){

        if($this->request->isAjax() && $this->request->hasPost('micro_id')){

        $micro = ChatMicroDialog::findFirst($this->request->getPost('micro_id'));
        $mess = new MessageChat();
        $mess->chat_id = $micro->chat->id;
        $mess->text = $this->request->getPost('text');
        $mess->type = $this->request->getPost('type_mess');
        $mess->micro_dialog_id = $this->request->getPost('micro_id');
        $mess->author_id = $user_id;
        $mess->creation_date = date("Y-m-d-H-i-s");
            if ($mess->save() == false) {
                echo "Мы не можем сохранить робота прямо сейчас: \n";
                foreach ($mess->getMessages() as $message) {
                    echo $message, "\n";
                }
            }

        }
        else{
            $micro = new ChatMicroDialog();
            $mess = new MessageChat();
            $mess->chat_id = $this->request->getPost('chat_id');
            $mess->text = $this->request->getPost('text');
            $mess->type = $this->request->getPost('type_mess');
            $mess->author_id = $user_id;
            $mess->creation_date = date("Y-m-d-H-i-s");
            $mess->save();

            $micro->chat_id = $this->request->getPost('chat_id');
            $micro->base_mess_id = $mess->id;
            $micro->creation_date = date("Y-m-d-H-i-s");
            $micro->save();
            $mess->micro_dialog_id = $micro->id;
            $mess->save();
            }

        }

        echo json_encode(array('success' =>'Сохранено'));
    }

    public function delchatAction()
    {
        $this->view->disable();
        $user_id = $this->session->get('user_id');

        if($this->request->isAjax() && $this->request->hasPost('chat_id')){

            $chat = Chat::findFirst($this->request->getPost('chat_id'));
            if($chat->created_id == $user_id){

            foreach($chat->messagechat as $mess){

                $mess->delete();
            }
            foreach($chat->chatmicrodialog as $micro){

                $micro->delete();
            }
            $cht = ChatHasUser::findFirst(array('chat_id = '.$this->request->getPost('chat_id')));
            $cht->delete();

                $chat->delete();

                echo json_encode(array('success' => 1));
            }

            else{
                echo json_encode(array('error' => 'Удалить чат может только его создатель'));
            }

        }

        if($this->request->isAjax() && $this->request->hasPost('micro_id')){

           $micro =  ChatMicroDialog::findFirst($this->request->getPost('micro_id'));


            if($micro->chat->created_id == $user_id){

            foreach($micro->messagechat as $mess){

                $mess->delete();
            }

            $micro->delete();
                echo json_encode(array('success' => 1));
            }
            else{
                echo json_encode(array('error' => 'Удалить микродиалог может только его создатель'));

            }

        }

        if($this->request->isAjax() && $this->request->hasPost('micro_mess_id')){


            $mess = MessageChat::findFirst($this->request->getPost('micro_mess_id'));
            if($mess->author_id == $user_id){

                $mess->delete();
                echo json_encode(array('success' => 1));
            }
            else{

                echo json_encode(array('error' => 'Удалить сообщение может только его создатель'));
            }
        }


    }


    public function chat_userAction()
    {
        $this->view->disable();

        if ($this->request->isAjax() && $this->request->hasPost('chat_id')) {

            $chat = Chat::findFirst($_POST['chat_id']);
            $user = User::findFirst($chat->created_id);
            echo json_encode(array(
                'user_id' => $user->id,
                'user_name' => $user->first_name

            ));

        }
        if ($this->request->isAjax() && $this->request->hasPost('micro_id')) {

            $micro = ChatMicroDialog::findFirst($this->request->getPost('micro_id'));

            $user = User::findFirst($micro->chat->created_id);
            echo json_encode(array(
                'user_id' => $user->id,
                'user_name' => $user->first_name

            ));
        }
        if ($this->request->isAjax() && $this->request->hasPost('micro_mess_id')) {

            $mess = MessageChat::findFirst($this->request->getPost('micro_mess_id'));

            $user = User::findFirst($mess->author_id);
            echo json_encode(array(
                'user_id' => $user->id,
                'user_name' => $user->first_name

            ));
        }

    }


}


?>