<?php
$rss = "https://www.057.ua/rss";
$xmlstr = @file_get_contents($rss);
if($xmlstr===false) die ('Error connect to RSS: '.$rss);
$xml = new SimpleXMLElement($xmlstr);
if($xml===false)die('Error parse RSS: '.$rss);

function text_add($link){
    //откуда будем парсить информацию
    $content = file_get_contents("$link");//полный урл страницы с http:// с которого будем вырезать информацию

    // Определяем позицию строки, до которой нужно все отрезать
    $pos = strpos($content, '<div class="io-article-body">');//здесь кусок кода/текста который размещен перед нужным текстом

   //Отрезаем все, что идет до нужной нам позиции
    $content = substr($content, $pos);

    // Точно таким же образом находим позицию конечной строки
    $pos = strpos($content, '<div class="row io-article-footer">');//здесь кусок кода/текста который стоит в конце нужного нам текста

    // Отрезаем нужное количество символов от нулевого

    $content = substr($content, 0, $pos);

    echo preg_replace('#<div class="col-xs-12 col-sm-3">.*?<div class="col-xs-12 col-sm-9">#s', "", $content); // выризаем ненужный блок
}


$i=0; // объявляем переменную для подсчета
    foreach($xml->channel->item as $item) {
        if ($i < 5) {

            echo $item->pubDate;

            echo '<a href="'.$item->link.'">';
            echo '<h2>'.$item->title.'</h2>';  //выводим на печать заголовок статьи
            echo '</a>';

           /* echo $item->link."<br/>"; // ссылка на страницу
            echo $item->title;     //заголовок
            echo"<br/>".$item->description;
           */

            text_add($item->link );
            $i++; // считаем

        }
    }
