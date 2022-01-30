<?php
$GLOBALS['scripts'][]= "scripts/yamaps_rote.js";
?>
<section>
    <h1>Расчет маршрута по клику</h1>
</section>
<section>
    <div>
        <lable for="suggest">Поиск</lable>
        <input type="text" id="suggest">
    </div>
    <div>
        <div id="summ">Сумма</div>
        <div id="km">Расстояние</div>
    </div>
</section>
<section >
    <div class="container_map">
        <div id="map" style="width: 100%; height: 300px;margin-bottom:30px;"></div>
    </div>
</section>

