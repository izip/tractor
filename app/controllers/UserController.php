<?php
use Phalcon\Mvc\View;

class UserController extends ControllerBase
{

    public function initialize()
    {
        $this->view->setTemplateAfter('main');
        parent::initialize();
    }

    public function authAction()
    {
        // $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
        $this->view->setVar("tokenKey", $this->security->getTokenKey());
        $this->view->setVar("token", $this->security->getToken());


    }

    public function auth_phoneAction()
    {
        $this->view->disable();
        if ($this->security->checkToken()) {
            if (isset($_POST['code'])) {

                $phone = $this->request->getPost("phone");
                $us = User::findFirst(array("'{$phone}' = phone"));

                if (isset($us->phone) && $us->phone == $phone) {


                    $code = rand(1000, 9999);
                    $this->modelsCache->save("code", $code);
                    $this->elements->sms_send($phone, $code);
                    echo json_encode(array("success" => "Код авторизации отправлен вам на телефон !"));

                } else {

                    echo json_encode(array("error" => "Пользователя с таким телефоном не существует !"));

                }


            }


            if (isset($_POST['login_phone'])) {

                $phone = $this->request->getPost('login_phone');
                $code = $this->request->getPost('login_code');
                if ($this->modelsCache->get("code") == $code) {
                    $user = User::findFirst(array("'{$phone}' = phone"));
                    $this->session->set("auth", "Users");
                    $this->session->set("user_id", $user->id);
                    $this->flashSession->success(" Вы авторизованы ! " . $user->first_name);
                    $this->response->redirect("myoffers");

                } else {

                    $this->flashSession->error("Неправильный код авторизации!");
                    $this->response->redirect("user/auth");

                }


            }


        } else {

            $this->flashSession->error("Неправильный токен !");
            $this->response->redirect("user/auth");


        }


    }

    public function auth_mailAction()
    {

        $this->view->disable();

        if ($this->security->checkToken()) {

            if (isset($_POST['email'])) {

                $email = $this->request->getPost("email");
                $us = User::findFirst(array("'{$email}' = email"));

                if (!isset($us->email) || $us->email != $email) {

                    echo json_encode(array("error" => "Пользователя с таким email не существует !"));

                } else {

                    echo "1";

                }


            }


            if (isset($_POST['login_mail']) && isset($_POST['login_pass'])) {


                $email = $this->request->getPost("login_mail");
                $pass = $this->request->getPost("login_pass", 'trim');

                $user = User::findFirst(array("'{$email}' = email "));


                if (isset($user->email) && isset($user->password)) {

                    if ($user->email == $email && $this->security->checkHash($pass, $user->password)) {

                        foreach ($user->role as $role) {
                            $rlname = $role->name;
                        }
                        $this->session->set("auth", $rlname);
                        $this->session->set("user_id", $user->id);
                        $this->flashSession->success(" Вы авторизованы ! " . $user->first_name);
                        header('location: ../');

                    } elseif (!$this->security->checkHash($pass, $user->password)) {

                        // echo $user->password;

                        $this->flashSession->error("Неправильный пароль!");
                        $this->response->redirect("user/auth");


                    } elseif ($user->email != $email) {


                        $this->flashSession->error("Пользователя с таким email не существует");
                        $this->response->redirect("user/auth");
                    }

                }

            }


        } else {

            $this->flashSession->error("Неправильный токен !");
            $this->response->redirect("user/auth");


        }

    }


    public function reg_socialAction()
    {
        $this->view->disable();

        if (isset($_POST["email"])) {
            $email = $this->request->getPost("email", 'email');

            $us = User::findFirst(array("'{$email}' = email"));

            if (isset($us->email)) {


                if ($us->email == $email) {
                    foreach ($us->role as $role) {
                        $rlname = $role->name;
                    }
                    $this->session->set("auth", $rlname);
                    $this->session->set("user_id", $us->id);
                    echo json_encode(array("success" => "Добро пожаловать " . $us->first_name . " " . $us->last_name));


                }

            } else {


                $pass = $this->elements->generate_password(8);
                $user = new User;
                $user->first_name = $this->request->getPost('first_name');
                $user->last_name = $this->request->getPost('last_name');

                $user->active = "y";
                $user->reg_ip = $this->request->getClientAddress();
                $user->last_login = date("Y-m-d-H-i-s");
                $user->date_register = date("Y-m-d-H-i-s");
                $user->email = $this->request->getPost('email', 'email');

                $user->password = $this->security->hash($pass);

                $user->save();

                $userDir = $_SERVER['DOCUMENT_ROOT'] . "/public/upload/users/user-" . $user->id;
                mkdir($userDir, 0777, true);
                $user->sc_dir = $userDir;
                $user->save();
                $role = new UserRole;
                $role->user_id = $user->id;
                $role->role_id = 4;
                $role->save();
                $this->elements->email_send($_POST['email'], "Ваш пароль от сериса mashinosmena.ru", "<p>Пароль <p>" . $pass);

                echo json_encode(array("success" => "Добро пожаловать " . $_POST['first_name'] . " " . $_POST['last_name']));
            }
        }
    }

    public function registerAction()
    {
        $this->view->disable();

        if ($this->security->checkToken()) {
            if (isset($_POST['code']) && isset($_POST["email"]) && $_POST["phone"]) {
                $email = $this->request->getPost("email");
                $phone = $this->request->getPost("phone");


                $us = User::findFirst(array("'{$email}' = email  or  '{$phone}' = phone"));

                if (isset($us->email) || isset($us->phone)) {


                    if ($us->email == $email) {
                        echo json_encode(array("error" => "Пользователь с таким Email уже существует !"));


                    } elseif ($us->phone == $phone) {
                        echo json_encode(array("error" => "Пользователь с таким телефоном уже существует"));


                    }
                } else {
                    $code = rand(1000, 9999);
                    $this->modelsCache->save("code", $code);
                    $this->elements->sms_send($phone, $code);
                    $this->elements->email_send($email, "Код авторизации mashinosmena.ru", "<p>Код авторизации <p>" . $code);
                    echo json_encode(array("success" => "Код подтерждения отправлен вам на email и сотовый телефон"));
                }


            } else {
                if ($this->modelsCache->get("code") == $_POST['reg_valid'] && isset($_POST['reg_phone']) && isset($_POST['reg_name']) && isset($_POST['reg_mail'])) {


                    $pass = $this->elements->generate_password(8);
                    //   print_r($_POST);
                    $user = new User;
                    $user->first_name = $this->request->getPost('reg_name');

                    $user->email = $this->request->getPost('reg_mail');
                    $user->phone = $this->request->getPost('reg_phone');
                    $user->active = "y";
                    $user->reg_ip = $this->request->getClientAddress();
                    $user->last_login = date("Y-m-d-H-i-s");
                    $user->date_register = date("Y-m-d-H-i-s");
                    $user->password = $this->security->hash($pass);


                    $user->save();
                    $userDir = $_SERVER['DOCUMENT_ROOT'] . "/public/upload/users/user-" . $user->id;
                    mkdir($userDir, 0777, true);
                    $user->sc_dir = $userDir;
                    $user->save();

                    $role = new UserRole;
                    $role->user_id = $user->id;
                    $role->role_id = 4;
                    $role->save();
                    $this->elements->sms_send($_POST['reg_phone'], "mashinosmena.ru - пароль  -- " . $pass);
                    $this->elements->email_send($_POST['reg_mail'], "mashinosmena.ru - пароль", "<p>Пароль <p>" . $pass);
                    foreach ($user->role as $role) {
                        $rlname = $role->name;
                    }
                    $this->session->set("auth", $rlname);
                    $this->session->set("user_id", $user->id);
                    $this->flashSession->success("Вы зарегистрированы и авторизованы !");
                    $this->response->redirect("myoffers");


                } else {

                    $this->flashSession->error("Неправильный код !");
                    $this->response->redirect("user/auth");


                }
            }

        } else {

            $this->flashSession->error("Неправильный токен !");
            $this->response->redirect("user/auth");

        }

    }

    public function authrAction()
    {
        $this->view->disable();
        $auth = $this->session->get('auth');

        if ($auth) {
            echo 1;
        }
    }

}