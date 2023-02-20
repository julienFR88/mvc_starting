<?php

/**
 * La classe Conf contient la configuration du site.
 */
class Conf{
	/**
	 * Le niveau de débogage. 1 = activé, 0 = désactivé.
	 * @var integer
	 */
	static $debug = 1;
	/**
	 * Les informations de connexion à la base de données.
	 * @var array
	 */
	static $databases = array(

		'default' => array(
			'host'		=> 'localhost',
			'database'	=> 'tuto',
			'login'		=> 'root',
			'password'	=> ''
		)
	);


}

/**
 * La classe Router gère le routage des URL.
 */
Router::prefix('cockpit','admin');


Router::connect('','posts/index');
Router::connect('cockpit','cockpit/posts/index');
Router::connect('blog/:slug-:id','posts/view/id:([0-9]+)/slug:([a-z0-9\-]+)');
Router::connect('blog/*','posts/*');

// Ce code PHP contient deux classes principales, Conf et Router. 
// La classe Conf contient des constantes statiques qui stockent la configuration du site, 
// notamment le niveau de débogage et les informations de connexion à la base de données. La classe Router est utilisée pour gérer le routage des URL.

// Le code utilise également des fonctions statiques telles que prefix() et connect() pour configurer les URL de routage. 
// Le préfixe "cockpit" est ajouté au chemin de l'URL pour les pages d'administration, 
// tandis que les URL de blog sont configurées pour inclure un slug et un identifiant. 
// Les URL sont ensuite liées à des contrôleurs et des actions spécifiques dans l'application.

// En somme, ce code permet de configurer la base de données, les URL de routage et les paramètres de débogage pour un site web.

