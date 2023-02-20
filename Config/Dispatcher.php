<?php

/**
 * La classe Dispatcher est responsable de dispatcher les requêtes HTTP entrantes 
 * à la méthode de contrôleur appropriée en fonction de l'URL demandée.
 */
class Dispatcher{
	/**
	 * @var Request l'objet Request contenant les informations sur la requête actuelle
	 */
	var $request;

	/**
	 * Constructeur de la classe Dispatcher, initialise l'objet Request et route la requête.
	 */
	function __construct(){
		$this->request = new Request(); // Instanciation de l'objet Request
		Router::parse($this->request->url,$this->request); // Appel de la méthode statique parse de la classe Router pour parser l'URL de la requête 
		$controller = $this->loadController(); // Chargement du controller correspondant à la requête
		$action = $this->request->action; // Récupération de l'action de la requête
		if($this->request->prefix){
			// Ajout du préfixe si présent
			$action = $this->request->prefix.'_'.$action;
		}
		if(!in_array($action , array_diff(get_class_methods($controller),get_class_methods('Controller'))))
		{
			// Vérification si l'action est une méthode valide du controller
			$this->error('Le controller '.$this->request->controller.' n\'a pas de méthode '.$action); 
		}
		
		call_user_func_array(array($controller,$action),$this->request->params); // Appel de la méthode de l'action avec les paramètres de la requête
		$controller->render($action); // Appel de la méthode render du controller pour générer la vue
	}

	/**
	 * Affiche une page d'erreur 404 avec le message spécifié.
	 *
	 * @param string $message le message à afficher sur la page d'erreur
	 */
	function error($message)
	{
		$controller = new Controller($this->request); // Instanciation du controller pour afficher la page d'erreur
		$controller->e404($message); // Appel de la méthode e404 du controller avec le message d'erreur en paramètre
	}

	/**
	 * Charge le fichier de contrôleur correspondant à la requête demandée et crée une instance du contrôleur.
	 *
	 * @return object une instance du contrôleur correspondant à la demande
	 */
	function loadController(){
		$name = ucfirst($this->request->controller).'Controller'; // Nom du controller 
		$file = __ROOT__.__DS__.'Src/Controller'.__DS__.$name.'.php'; // Chemin du fichier correspondant au controller
		if(!file_exists($file))
		// Vérifie si le fichier existe, sinon on appelle la méthode error pour afficher une page d'erreur
		{
			$this->error('Le controller '.$this->request->controller.' n\'existe pas !');
		} 
		require $file; // Inclusion du fichier du controller 
		$controller = new $name($this->request); // Instanciation du controller avec l'objet Request en paramètre
		
		return $controller; // Retourne l'objet controller  
	}


}