<?php

/**
 * Classe Controller
 *
 * Cette classe est le contrôleur de base pour toutes les pages de l'application.
 *
 * @property Request $request    L'objet Request associé à cette instance du contrôleur.
 * @property array   $vars       Un tableau associatif de variables à transmettre à la vue.
 * @property string  $layout     Le nom du layout à utiliser pour la vue.
 * @property boolean $rendered   Indique si la vue a déjà été rendue.
 * @property Session $Session    L'objet Session associé à cette instance du contrôleur.
 * @property Form    $Form       L'objet Form associé à cette instance du contrôleur.
 *
 * @package     MonApplication
 * @subpackage  Controllers
 */
class Controller{
	/**
	 * L'objet Request associé à cette instance du contrôleur.
	 *
	 * @var Request|null
	 */
	public $request;
	/**
	 * Un tableau associatif de variables à transmettre à la vue.
	 *
	 * @var array
	 */  				
	private $vars     = array();
	/**
	 * Le nom du layout à utiliser pour la vue.
	 *
	 * @var string
	 */	
	public $layout    = 'default';

	/**
	 * Indique si la vue a déjà été rendue.
	 *
	 * @var boolean
	 */	private $rendered = false;

	/**
	 * Le constructeur de la classe Controller.
	 *
	 * @param Request|null $request L'objet Request à associer à cette instance du contrôleur.
	 */
	function __construct($request = null){
		if($request){
			$this->request = $request; 	
			$this->Session = new Session();
			$this->Form = new Form($this);	
			require __ROOT__.__DS__.'config'.__DS__.'hook.php'; 		
		}
		
	}


	/**
	 * Rend la vue associée à cette instance du contrôleur.
	 *
	 * @param string $view Le nom de la vue à rendre.
	 *
	 * @return boolean Indique si la vue a été rendue avec succès.
	 */
	public function render($view){
		if($this->rendered){ return false; }
		extract($this->vars); 
		if(strpos($view,'/')===0){
			$view = __ROOT__.__DS__.'Template'.$view.'.php';
		}else{
			$view = __ROOT__.__DS__.'Template'.__DS__.$this->request->controller.__DS__.$view.'.php';
		}
		ob_start(); 
		require($view);
		$content_for_layout = ob_get_clean();  
		require __ROOT__.__DS__.'Template'.__DS__.'layout'.__DS__.$this->layout.'.php'; 
		$this->rendered = true; 
	}

	/**
	 * Définit une variable à transmettre à la vue.
	 *
	 * @param string|array $key   Le nom de la variable, ou un tableau associatif de variables.
	 * @param mixed        $value La valeur de la variable.
	 *
	 * @return void
	 */
	public function set($key,$value=null){
		if(is_array($key)){
			$this->vars += $key; 
		}else{
			$this->vars[$key] = $value; 
		}
	}

		/**
    *Charge un modèle.
    *@param string $name Le nom du modèle à charger.
    *@return void
	  */
	function loadModel($name){
		if(!isset($this->$name)){
			$file = __ROOT__.__DS__.'Src/Model'.__DS__.$name.'.php'; 
			require_once($file);
			$this->$name = new $name();
			if(isset($this->Form)){
				$this->$name->Form = $this->Form;  
			}
		}

	}

	 	/**
    *Affiche une erreur 404.
    *@param string $message Le message à afficher.
    *@return void
	  */
	function e404($message){	
		header("HTTP/1.0 404 Not Found");
		$this->set('message',$message); 
		$this->render('/errors/404');
		die();
	}

	/**
	 * Récupère une instance du contrôleur demandé et exécute une action.
	 * @param string $controller Le nom du contrôleur à instancier (sans le suffixe "Controller").
	 * @param string $action Le nom de l'action à exécuter.
	 * @return mixed Le résultat de l'exécution de l'action.
	 */
	function request($controller,$action){
		$controller .= 'Controller';
		require_once __ROOT__.__DS__.'Src/Controller'.__DS__.$controller.'.php';
		$c = new $controller();
		return $c->$action(); 
	}


	/**
	 * Effectue une redirection HTTP vers l'URL spécifiée.
	 * @param string $url L'URL de destination de la redirection.
	 * @param int|null $code Le code HTTP de la redirection (par défaut 302).
	 * @return void
	 */
	function redirect($url,$code = null ){
		if($code == 301){
			header("HTTP/1.1 301 Moved Permanently");
		}
		header("Location: ".Router::url($url)); 
	}
}
?>