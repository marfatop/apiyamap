<?php
$GLOBALS['scripts'][]= "scripts/yamaps_deliverizone.js";
//var_dump($arrResult['GEOJSON']['features'][0]);
//echo json_encode($arrResult['GEOJSON']['features']);
?>
<section>
    <h1>Зоны доставки</h1>
</section>
<section>
    <div>
        <lable for="suggest">Поиск</lable>
        <input type="text" id="suggest">
    </div>
</section>
<section >

    <div class="container_map delivery">
        <div class="aside" >
            <div>Зоны доставки</div>
            <ul>
                <? foreach ($arrResult['GEOJSON']['features'] as $index => $item) : ?>
                <? $price_min=350;?>
                    <li data-itemid="<?=$item['id']?>">
                        <span class="deliveryzone_name"><?=$item['properties']['description']?></span>
                        <input class="deliveryzone_price" type="number" placeholder="стоимость" min="<?=$price_min?>" max="1500" step="50" value="<?=isset($item['properties']['price']) ? $item['properties']['price'] : null; ?>">
                        <span class="deliveryzone_color" style="background-color: <?=$item['properties']['fill']?>">&nbsp;</span></li>
                <? endforeach;?>

            </ul>
        </div>
        <div id="delivery" style="width: 100%; height: 900px;margin-bottom:30px;"></div>
    </div>
</section>
<?php if(!empty($arrResult['GEOJSON'])) :?>

    <script>
        window.addEventListener('load',function (e){
            var geoDataObj,mapDomId,centallat,centerlon
            geoDataObj=<?=json_encode($arrResult['GEOJSON'], JSON_PRETTY_PRINT)?>
           // geoDataObj=JSON.parse(<?//=json_encode($arrResult['GEOJSON'], JSON_PRETTY_PRINT)?>)
            console.log(geoDataObj)
        })
    </script>

<?php endif;?>

