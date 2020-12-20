<?php
class Bootstrap{
	private $controller;
	private $action;
	private $request;

	public function __construct($request){
		$this->request = $request;
		if($this->request['controller'] == "" && isset($_SESSION['is_logged_in'])){
                    $this->controller = 'home';
		} else if(!isset($_SESSION['is_logged_in'])) {
                    $this->controller = 'login';
                } else {
                    $this->controller = $this->request['controller'];
		}
		if($this->request['action'] == ""){
                    $this->action = 'index';
                    
		} else {
                    $this->action = $this->request['action'];
		}
                Security::changeSessionIdAndCsrf();
                Security::checkIfUserIsActive();
	}

	public function createController(){
		// Check Class
		if(class_exists($this->controller)){
			$parents = class_parents($this->controller);
			// Check Extend
			if(in_array("Controller", $parents)){
				if(method_exists($this->controller, $this->action)){
					return new $this->controller($this->action, $this->request);
				} else {
					// Method Does Not Exist
                                        echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
					return;
				}
			} else {
				// Base Controller Does Not Exist
				echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
				return;
			}
		} else {
			// Controller Class Does Not Exist
                        echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
			return;
		}
	}
}