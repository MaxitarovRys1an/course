<?php
class Rout{
   public static function view($uri, $filePath){
      $content="";
      $paths = explode ("/", $_SERVER['REQUEST_URI']);
      if (count($paths)>2){
         $uri = explode("/",  $uri)[1];
         $uri = '/'.$uri.'/'.$paths[2];
      }
      if($_SERVER['REQUEST_URI']==$uri && $_SERVER['REQUEST_METHOD']=='GET'){
         $content = file_get_contents($filePath);
         require_once('temmplate.php');
         exit();
      }
      
   }
   public static function post($uri, $handler){
      if($_SERVER['REQUEST_URI']==$uri && $_SERVER['REQUEST_METHOD']=='POST'){
         exit($handler());
      }
      
   }
   public static function get($uri, $handler){
      $paths = explode ("/", $_SERVER['REQUEST_URI']);
      $param = null;
      if (count($paths)>2){
         $uri = explode('/',  $uri)[1];
         $uri = '/'.$uri.'/'.$paths[2];
         $param = $paths[2];
      }
      if($_SERVER['REQUEST_URI']==$uri && $_SERVER['REQUEST_METHOD']=='GET'){
         exit($handler($param));
      }
   }
}
?>