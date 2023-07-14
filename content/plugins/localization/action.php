<?php

session_start();

require_once( '../../../config.php' );
require_once( '../../../init.php' );

if(is_login() && USER_ADMIN){
	if(isset($_POST['action'])){
		$root = '../../../';
		if($_POST['action'] == 'submit'){
			$path = $root.'locales';
			if($_POST['target'] === 'theme'){
				$path = $root.'content/themes/'.THEME_NAME.'/locales';
			}
			if(!file_exists($path)){
				mkdir($path, 0755, true);
			}
			file_put_contents($path.'/'.$_POST['lang'].'.json', $_POST['data']);
			if(file_exists($path)){
				//unlink($path);
				//header('Location: '.DOMAIN.'admin/dashboard.php?viewpage=plugin&name=backup-restore&status=deleted');
			} else {
				echo('c');
			}
			echo 'ok';
		}
	} else {
		echo('a');
	}
} else {
	exit('logout');
}

?>