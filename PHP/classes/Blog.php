<?php
class Blog{
   public static function handlerAddArticle(){
      $title = $_POST['title'];
      $content= $_POST['content'];
      $autor= $_POST['autor'];
      $mysqli = new mysqli("127.0.0.1", "root", "", "block 30/10", "3306",);
      $mysqli->query("INSERT INTO articles (title, content, autor) VALUES ('$title','$content','$autor')");
      header("Location: /");
   }
   public static function getArticleById($articleid){
      global $mysqli;
      $result = $mysqli->query("SELECT * FROM articles WHERE id = '$articleid'");
   return json_encode($result->fetch_assoc());
   }
   public static function getArticles(){
      global $mysqli;
$result = $mysqli->query("SELECT * FROM articles");
$articles = [];
while (($row = $result->fetch_assoc()) != null){
   $articles[] = $row;
}
return json_encode($articles);
   }
}
?>