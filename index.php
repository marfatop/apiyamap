<?php
include_once "config.php";
include_once "controllers/controller.php";
$controller= new controller();
$template=$controller->getTemplate();

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&coordorder=longlat&apikey=<?=YAMAPAPIKEY?>"></script>
    <link rel="stylesheet" href="/styles/style.css">


<!--    <script src="/scripts/yamap_rote.js"></script>-->
<!--    <script src="/scripts/yamaps_deliverizone.js"></script>-->

    <? if(!empty($GLOBALS['scripts'])):?>
        <?foreach ($GLOBALS['scripts'] as $src):?>
            <script src="<?=$src?>"></script>
        <?endforeach;?>
    <?endif;?>

</head>
<body>
<div class="container main">
    <div class="aside">
        <div>Меню</div>
        <div>
            <ul>
                <li><a href="map1.php">Расчет маршрута по клику</a></li>
                <li><a href="map2.php?app=delivery&method=getGeoJSON">Зоны доставки</a></li>
                <li><a href="map3.php">Панорамы</a></li>
                <li><a href="test.php">Для тестов</a></li>
                <li><a href="chkcatalog.php">Сравнить каталог</a></li>
                <li><a href="kladr.php">API KLADR</a></li>
            </ul>
        </div>
    </div>
    <div class="container article">
        <pre>
            <?//=var_dump($_SERVER);?>
        </pre>
        <?=$template?>
</div>

</body>
</html>
