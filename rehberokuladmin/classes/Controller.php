<?php
class Controller{
	protected $request;
	protected $action;
        public static $title;
        public static $active_id;
        public static $child_active_id;
        public static $link;

	public function __construct($action, $request){
		$this->action = $action;
		$this->request = $request;
                self::$link = $request['id'];
                settype(self::$active_id, 'integer');
                settype(self::$child_active_id, 'integer');
                
	}

	public function executeAction(){
		return $this->{$this->action}();
	}

	protected function returnView($viewModel, $fullView){
            $view = 'views/'. strtolower(get_class($this)). '/' . $this->action. '.php';
            if(!isset($_SESSION['is_logged_in'])){
                require('views/login/index.php');
            } else if($fullView && isset($_SESSION['is_logged_in'])) {
                //$view = 'views/home/index.php';
                //echo '<script>alert(1);</script>';
                require('views/main.php');
            } else {
                require($view);
            }
	}
        
        public static function getRequestId() {
            return self::$link;
        }
}