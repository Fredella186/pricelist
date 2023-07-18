<?php
	include "connect.php";
    session_start();
    $session = $_POST['nama_session'];
    $_SESSION[$session] = array();

  