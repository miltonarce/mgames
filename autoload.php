<?php
/*
Aca va mi autoload para detectar mis clases
*/
session_start();
spl_autoload_register(function($className){
  $path = __DIR__."/classes/".$className.".php";
  if(file_exists($path)){
    require $path;
  }
});