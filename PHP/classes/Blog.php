<?php

class Blog
{
    public static function handlerAddArticle()
    {
        global $mysqli;
        $title = $_POST['title'];
        $content = $_POST['content'];
        $autor = $_POST['autor'];
        $html = new simple_html_dom();
        $html->load($content);
        $img = $html->getElementByTagName('img');
        $meta = explode(',', $img->src)[0];
        $base64 = explode(',', $img->src)[1];
        $extation = explode(';', explode('/', $meta)[1])[0];
        $filename = "sourse/img/blogimg/".microtime().".".$extation;
        $ifp = fopen($filename, 'wb');
        fwrite($ifp, base64_decode($base64));
        fclose($ifp);
        $img->src = "/".$filename;
        $content = $html->save();
        $mysqli->query("INSERT INTO articles (title, content, autor) VALUES ('$title','$content','$autor')");
        return json_encode(['result'=>'success']);
        
    }
    public static function getArticleById($articleid)
    {
        global $mysqli;
        $result = $mysqli->query("SELECT * FROM articles WHERE id = '$articleid'");
        return json_encode($result->fetch_assoc());
    }

    public static function getArticles()
    {
        global $mysqli;
        $result = $mysqli->query("SELECT * FROM articles");
        $articles = [];
        while (($row = $result->fetch_assoc()) != null) {
            $articles[] = $row;
        }
        return json_encode($articles);
    }
}

?>