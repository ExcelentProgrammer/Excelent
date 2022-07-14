<?php
ob_start();

use App\Model\User;
use Pecee\SimpleRouter\SimpleRouter;
use Excelent\Error\Error;

const ROOT_PATH = __DIR__;

require_once "../vendor/autoload.php";

require_once '../Router/web.php';

SimpleRouter::setDefaultNamespace('App\Controller');

SimpleRouter::start();

Error::view();
?>

