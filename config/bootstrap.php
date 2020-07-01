<?php
require_once __DIR__ . '/../vendor/autoload.php';
use Slim\Factory\AppFactory;
use Config\Database;



new Database();
$app = AppFactory::create();
$app->setBasePath("/segundoparcial/public");
//$app->addErrorMiddleware(true, true, true);
(require_once __DIR__ . '/routes.php')($app);

(require_once __DIR__ . '/middlewares.php')($app);

return $app;

?>