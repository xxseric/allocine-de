<?php

	include_once 'persistence/user_dao.php';

	setUserLevelById($_POST['user_id'], $_POST['user_level']);

	require_once 'liste_users.php';	

?>