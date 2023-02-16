<?php
class Conf{
	
	static $debug = 1; 

	static $databases = array(

		'default' => array(
			'host'		=> 'localhost',
			'database'	=> 'tuto',
			'login'		=> 'root',
			'password'	=> ''
		)
	);


}

Router::prefix('cockpit','admin');


Router::connect('','posts/index');
Router::connect('cockpit','cockpit/posts/index');
Router::connect('blog/:slug-:id','posts/view/id:([0-9]+)/slug:([a-z0-9\-]+)');
Router::connect('blog/*','posts/*');
