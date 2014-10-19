<?php

use Phalcon\Events\Event,
	Phalcon\Mvc\User\Plugin,
	Phalcon\Mvc\Dispatcher,
	Phalcon\Acl,
    Phalcon\Http\Response ;


class Security extends Plugin
{

	public function __construct($dependencyInjector)
	{
		$this->_dependencyInjector = $dependencyInjector;
	}

	public function getAcl()
	{
		//if (!isset($this->persistent->acl)) {



			$acl = new Phalcon\Acl\Adapter\Memory();

			$acl->setDefaultAction(Phalcon\Acl::DENY);


            //Register roles
            $rol = Role::find(array("cache" => array("key" => "role" )));


            foreach($rol as $ros) {
            $roles[strtolower($ros->name)] =  new Phalcon\Acl\Role($ros->name);
            }

			foreach ($roles as $role) {
				$acl->addRole($role);
			}


			foreach (Action::find(array("cache" => array("key" => "action" ))) as  $actions) {
				$acl->addResource(new Phalcon\Acl\Resource($actions->controller->name), $actions->name);
			}



			//Grant access to public areas to both users and guests
        foreach ($rol as $role) {
                foreach ($role->action as $action) {
            $roledann[$role->name][$action->controller->name][] = $action->name;

                }
			}

           // print_r($roledann);

            foreach ($roledann as  $keys => $dann) {

            foreach($dann as $key => $dan) {
                $acl->allow($keys , $key, $dan);
            }
            }


			//The acl is stored in session, APC would be useful here too
			//$this->persistent->acl = $acl;
	//	}

		//return $this->persistent->acl;
        return $acl;
	}


	public function beforeDispatch(Event $event, Dispatcher $dispatcher)
	{



		$auth = $this->session->get('auth');
		if (!$auth){
			$role = 'Guests';
		} else {
			$role = $auth;
		}

		$controller = $dispatcher->getControllerName();
		$action = $dispatcher->getActionName();


		$acl = $this->getAcl();


		$allowed = $acl->isAllowed($role, $controller, $action);
		if ($allowed != Acl::ALLOW && $role == 'Guests') {
			$this->flashSession->error("Доступ запрещен !");

            $this->response->redirect("user/auth");
			return false;
		}
        if ($allowed != Acl::ALLOW && $role == 'Users') {
            $this->flashSession->error("Раздел находится в разработке !");

            $this->response->redirect("../");
            return false;
        }

	}

}
