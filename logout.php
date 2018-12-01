<?php

require 'autoload.php';

$auth = new Auth;

$auth->logout();

header('Location: login.php');