<?php

require '../vendor/autoload.php';
/**
 * Ce fichier contient tout ce qu'il faut lancer lors du démarrage de l'application
 */


/**
 * @return PDO
 */
function getPDO()
{
    $pdo = new PDO('mysql:host=localhost;dbname=calendar', 'root', '', [
        PDO::ATTR_ERRMODE,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    return $pdo;
}

function error404()
{
    require '../public/404.php';
    exit();
}

function render(string $view_name, $params = [])
{
    extract($params);
    include "../views/{$view_name}.php";
}

?>

