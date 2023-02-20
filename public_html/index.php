<?php
$debut = microtime(true); 

define('__WEBROOT__',dirname(__FILE__)); 
define('__ROOT__',dirname(__WEBROOT__)); 
define('__DS__',DIRECTORY_SEPARATOR);
define('CORE',__ROOT__.__DS__.'Config'); 
define('__BASE_URL__',dirname(dirname($_SERVER['SCRIPT_NAME']))); 

require CORE.__DS__.'includes.php'; 
new Dispatcher(); 

?>
<div style="position:fixed;bottom:0; background:#900; color:#FFF; line-height:30px; height:30px; left:0; right:0; padding-left:10px; ">
<?php 
echo 'Page générée en '. round(microtime(true) - $debut,5).' secondes'; 
?>
</div>