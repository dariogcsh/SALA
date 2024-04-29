<?php session_start();

if (isset($_SESSION['CodiClie'])){
	header("Location: menu.php");
} elseif (isset($_SESSION['CodiEmpl'])) {
	header("Location: menu.php");
} else {
	header("Location: login.php");
	session_destroy();
}
?>