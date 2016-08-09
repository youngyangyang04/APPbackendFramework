<?php
namespace control;
use model\mod_robot;
include_once 'model/mod_robot.php';
class ctl_robot extends mod_robot{
	function register_or_not($rID){
		return $this->mod_login($rID);
	}
}
