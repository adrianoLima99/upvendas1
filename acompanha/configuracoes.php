<?php

define("SMARTY_DIR", "smarty/");
define("SITE", "");
define("TEMPLATE", "");
include(SMARTY_DIR . "Smarty.class.php");
$smarty = new Smarty;
$smarty->template_dir = SITE . "templates/" . TEMPLATE;
$smarty->compile_dir = SITE . "templates_c/";
?>   