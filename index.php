<?php
include_once "config.php";
include_once "controllers/controller.php";
$controller= new controller();
$template=$controller->getTemplate();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="/styles/style.css">

    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&coordorder=longlat&apikey=<?=YAMAPAPIKEY?>"></script>
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
                <li>карта3</li>
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
