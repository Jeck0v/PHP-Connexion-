<?php

session_start();

$_POST;

$_SESSION['pseudo'] = 'Toto';

header('location: accueil.php');