<?php
use Phalcon\Mvc\View;



class MessageController extends ControllerBase
{


    public function initialize()
    {
        $this->view->setTemplateAfter('main');


        Phalcon\Tag::setTitle('MashinoSmena.ru');
        parent::initialize();
    }


    public function indexAction()
    {

        if($this->request->hasPost('d')){

            $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
        }
        if ($this->session->has('user_id')) {
            $id = $this->session->get('user_id');
            $user = User::findFirst($id);
        }

        foreach ($user->dialogs as $dialogs)
        {
            foreach ($dialogs->user as $dialog_users) {
                if($dialog_users->id != $id)
                    $dia[$dialogs->id]['dialog_users'] = array($dialog_users->first_name,$dialog_users->id ,$dialog_users->organization);
            }

            foreach ($dialogs->message as $message) {
                //$author = $message->user->first_name;
                $status = $message->read;

                $dia[$dialogs->id]['dialog_info'] = array($status);
                //$text = $message->text;
                //echo $author." ->  : ".$text."</br>";
            }
        }

        //print_r($dia);

        $this->view->setVars(array(
            "dialogs" => count($user->dialogs),
            "dia" => $dia =(isset($dia)) ? $dia :false
        ));
    }

    public function dialogAction()
    {
		$this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);

	    //$this->view->setVar("tokenKey",$this->security->getTokenKey());
	    //$this->view->setVar("token",$this->security->getToken());

        if (isset($_POST['dialog'])) {
            $dialog_id = $this->request->getPost('dialog');
            $dialog = Dialogs::findFirst($dialog_id);

            foreach ($dialog->message as $message) {
                $author = $message->user->first_name;
                $text = $message->text;

                $date = new DateTime($message->creation_date);
                $date = $date->format('Y-m-d H:i');

                $var[$message->id] = array('author'=>$author, 'text'=>$text, 'date'=>$date ,'org' => $message->user->organization);
            }


                $this->view->setVars(array(
                    "var" => $var =(isset($var)) ? $var :false
                ));

        }
    }

    public function addAction() {
	    $this->view->disable();

	    function valid_form_offer(){
		    $sub_mess = '';
		    //if ($this->security->checkToken()) {}

		    if(isset($_POST['text_answer']) && strlen($_POST['text_answer']) < 2)
			    $sub_mess['text_offer'] = 'Введите текст сообщения';

		    if(is_array($sub_mess)) {
			    echo json_encode($sub_mess);
			    return false;
		    } else {
			    return true;
		    }
	    }
	    if ( valid_form_offer()) {
			$dialog_id = $this->request->getPost('dialog');
			$text_answer = $this->request->getPost('text_answer');
			$user_id = $this->session->get('user_id');

		    // Если НЕТ: создать диалог -> связь -> сообщение привязанное к диалогу
		    // Если ЕСТЬ: создать сообщение привязанное к диалогу
		    $dialog = Dialogs::findFirst($dialog_id);
		    if(isset($dialog->id)) {
				$message = new Message();
			    $message->dialogs_id = $dialog_id;
			    $message->text = $text_answer;
			    $message->creation_date = date("Y-m-d-H-i-s");
			    $message->author_id = $user_id;
			    $message->save();
			    if ($message->save() == false) {
				    foreach ($message->getMessages() as $message) {
						echo $message;
					    exit;
				    }
				}
		    } else {
			    $dialog = new Dialogs();
			    $dialog->creation_date;
			    $dialog->save();
			    if ($dialog->save() == false) {
				    foreach ($dialog->getMessages() as $message) {
					    echo $message;
					    exit;
				    }
			    }

			    $dialogsHasUser = new DialogsHasUser();
			    $dialogsHasUser->dialogs_id = $dialog->id;
			    $dialogsHasUser->user_id = $user_id;
			    $dialogsHasUser->save();
			    if ($dialogsHasUser->save() == false) {
				    foreach ($dialogsHasUser->getMessages() as $message) {
					    echo $message;
					    exit;
				    }
			    }
			    $dialogsHasUser = new DialogsHasUser();
			    $dialogsHasUser->dialogs_id = $dialog->id;
			    $dialogsHasUser->user_id = $user_id;
			    $dialogsHasUser->save();
			    if ($dialogsHasUser->save() == false) {
				    foreach ($dialogsHasUser->getMessages() as $message) {
					    echo $message;
					    exit;
				    }
			    }

			    $message = new Message();
			    $message->dialogs_id = $dialog_id;
			    $message->text = $text_answer;
			    $message->creation_date = date("Y-m-d-H-i-s");
			    $message->author_id = $user_id;
			    $message->save();
			    if ($message->save() == false) {
				    foreach ($message->getMessages() as $message) {
					    echo $message;
					    exit;
				    }
			    }
		    }

		    echo '1';
	    }
    }


    public function adddialogAction(){
        $this->view->disable();
        if($this->request->hasPost('user_id')  && $this->request->isAjax()){

            if($this->request->getPost('user_id') == $this->session->get('user_id')){
                echo 2;
                die();
            }
          $user =  User::findFirst($this->request->getPost('user_id'));
            if($this->request->hasPost('dn')){
            $text = "Мой email - ".$user->email." Мой телефон - ".$user->phone;
            }
            elseif( $this->request->hasPost('text')){
            $text = $this->request->getPost('text');
            }
            foreach($user->dialogs as $dial){
            foreach($dial->user as $us){
                if($us->id == $this->session->get('user_id')){
                    $dial_id = $dial->id;
                }
            }

            }
            if(isset($dial_id)){

                $mess = new Message();
                $mess->dialogs_id = $dial_id;
                $mess->text = $text;
                $mess->creation_date = date('Y-m-d-H-i-s');
                $mess->author_id = $this->session->get('user_id');
                $mess->save();
                echo 1;
            }
            else{
                $dialog = new Dialogs();
                $dialog->creation_date = date('Y-m-d-H-i-s');
                $dialog->save();

                $dial_h = new DialogsHasUser();
                $dial_h->dialogs_id = $dialog->id;
                $dial_h->user_id = $this->session->get('user_id');
                $dial_h->save();

                $dial_h = new DialogsHasUser();
                $dial_h->dialogs_id = $dialog->id;
                $dial_h->user_id = $this->request->getPost('user_id');
                $dial_h->save();
                $mess = new Message();
                $mess->dialogs_id = $dialog->id;
                $mess->text = $text;
                $mess->creation_date = date('Y-m-d-H-i-s');
                $mess->author_id = $this->session->get('user_id');
                $mess->save();

            echo 1;
            }
        }

    }


    public function deleteAction() {
        $this->view->disable();

        if($this->request->hasPost('d_id') && $this->request->isAjax()){
            $dialog_ids = $this->request->getPost('d_id');

            foreach(Message::find(array("dialogs_id = {$dialog_ids}")) as $mes){

                $mes->delete();
            }
            foreach(DialogsHasUser::find(array("dialogs_id = {$dialog_ids}"))as $ds){

                $ds->delete();
            }
            Dialogs::findFirst($dialog_ids)->delete();

            echo 1;
        }

    }
}


?>