
<?php
class Bootstrap{
	function __construct(){

		$url = isset($_GET['url']) ? $_GET['url'] : null ;
		$url = rtrim($url,'/');
		$url = explode('/', $url);
		//print_r($url);
		if(empty($url[0])){
			require PATH_APPLICATION .'/controllers/Index.php';
			$controller = new Index();
			$controller->index();
			return false;
		}
		$file = PATH_APPLICATION .'/controllers/' . $url[0] .'.php';
		if(file_exists($file)){
			require $file;
		}else{
			$this->error();
		}
		$controller = new $url[0];
		$controller->loadModel($url[0]);

		if(isset($url[2])){
			if(method_exists($controller,$url[1])){
				$controller->{$url[1]}($url[2]);
			}else{
				$this->error();
			}
		}else{
			if(isset($url[1])){
				if(method_exists($controller,$url[1])){
					$controller->{$url[1]}();
				}else{
					$this->error();
				}
					//return false;
			}else{
				$controller->index();
			}
		}
		
	}

	function error(){
		require PATH_APPLICATION .'/controllers/error.php';
		$controller = new Error();
		$controller->index();
		return false;
	}
}
?>