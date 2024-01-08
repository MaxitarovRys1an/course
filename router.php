<?php
session_start();
$patt = explode( "/", $_SERVER['REQUEST_URI']);
$mysqli = new mysqli("127.0.0.1", "root", "", "block 30/10", "3306",);
require_once('PHP/classes/User.php');
require_once('PHP/classes/Blog.php');
require_once('PHP/classes/Rout.php');

require_once ('PHP/classes/simple_html_dom.php');



Rout::view('/', 'views/mainpage.html');
Rout::view('/blog/{id}', 'views/article.html');

Rout::get('/getArticle/{id}', function($id){return Blog::getArticleById($id);});
Rout::get('/getArticles', function(){return Blog::getArticles();});
Rout::get('/getUserData', function(){return User::getUserData();});
Rout::get('/logout', function(){return User::logout();});

if (!empty($_SESSION['id'])){
   Rout::view('/profile', 'views/profile.html');
   Rout::view('/addArticle', 'views/addArticle.html');
   Rout::post('/handlerAddArticle',function(){return Blog::handlerAddArticle();});
   Rout::get('/reg', function(){return header('Location: /profile');});
   Rout::get('/login', function(){return header('Location: /profile');});
   Rout::post('/changeAvatar', function (){return User::changeUserAvatar();});
} else {
   Rout::view('/reg', 'views/reg.html');
   Rout::view('/login', 'views/login.html');
   Rout::post('/Reg',function(){return User::handlerReg();});
   Rout::post('/Login',function(){return User::login();});
   header('Location: /login');

}





// if ($patt[1] == ''){
//    $content = file_get_contents('views/mainpage.html');
//    $title = "NetWork-PC";
// }elseif ($patt[1] == 'login'){
//    $content = file_get_contents('views/login.html');
//    $title="LOGIN";
// }elseif ($patt[1] == 'reg'){
//    $content = file_get_contents('views/reg.html');
//    $title = "REGISTR";
// }elseif ($patt[1] == 'profile'){
//    $content = file_get_contents('views/profile.html');
//    $title="PROFILE";
// }elseif ($patt[1]=='blog'){
//    $content = file_get_contents('views/article.html');
//    $title ="Blog";
// }elseif ($patt[1]=='getArticle'){
//    exit(Blog::getArticleById($patt[2]));
// }elseif ($patt[1] == 'addArticle'){
//    $title = 'Addarticle';
//    $content = file_get_contents('views/addArticle.html');
// }elseif ($patt[1] == 'handlerReg'){
//    exit(User::handlerReg());
// }
// elseif ($patt[1] == 'handlerAddArticle'){
//    exit(Blog::handlerAddArticle());
// }elseif($patt[1] =='handlerLogin'){
//    exit(User::login());
// }elseif($patt[1]=="getArticles"){
//    exit(Blog::getArticles());
// }elseif($patt[1] == 'getUserData'){
//    exit(User::getUserData());
// }elseif($patt[1] == 'logout'){
//    exit(User::logout());
// }

// require_once('temmplate.php');
?>