<?php
/*
  Aca va mi autoload para detectar mis clases, interfaces...
*/
session_start();
spl_autoload_register(function($className){
  $path = __DIR__."/classes/".$className.".php";
  if (file_exists($path)) {
    require $path;
  }
  $path_interfaces = __DIR__."/interfaces/".$className.".php";
  if (file_exists($path_interfaces)) {
    require $path_interfaces;
  }
});