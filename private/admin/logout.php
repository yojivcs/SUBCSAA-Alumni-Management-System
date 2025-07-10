<?php
require_once '../../php/config.php';
require_once '../../php/session_handler.php';

CustomSessionHandler::init();
CustomSessionHandler::destroy();

header("Location: /screens/login.php");
exit();
?> 