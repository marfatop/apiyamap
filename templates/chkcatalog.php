<?php
$GLOBALS['scripts'][] = "scripts/chkkatalog.js";
require_once "models/chkkatalog.php";

$model = new chkkatalog();
//$model->getDomino();

$data_imshop = $model->getImshopCatalog($model->file_imshop_path);
$data_imshop_today = $model->getImshopCatalog($model->file_imshop_today_path);

//$data_domino=$model->getDomino();

//$data_domino_clear=array_unique($data_domino);
?>
<section>
    <h1>Сравнить выгрузки</h1>
    <div>
        <pre>
            <?
            $articuls = [];
            $articuls2 = [];
            foreach ($data_imshop->offer as $index => $item) {
                if ($item->attributes()['available']->__toString() == "true") {
                    $id = $item->attributes()['uuid']->__toString();
                    $name = $item->name->__toString();
                    $articuls[$id] = $name;
                }
            }
            foreach ($data_imshop_today->offer as $index2 => $item2) {
                if ($item2->attributes()['available']->__toString() == "true") {
                    $id = $item2->attributes()['uuid']->__toString();
                    $name = $item2->name->__toString();
                    $articuls2[$id] = $name;
                }
            }
            $data_articuls_clear = array_unique($articuls);
            ksort($data_articuls_clear, SORT_NUMERIC);

            $data_articuls_clear2 = array_unique($articuls2);
            ksort($data_articuls_clear2, SORT_NUMERIC);

            $arr_dif = array_diff_key($data_articuls_clear, $data_articuls_clear2);

            //  print_r($data_articuls_clear);
            ?>
            <? //var_dump($data_imshop->offer)?>

        </pre>
        <div>
            <ul>
                <li>Кол-во уникальных элементов из выгрузки 04 мая Имшоп: <?=count($data_articuls_clear)?></li>
                <li>Кол-во уникальных элементов из выгрузки 05 мая Имшоп: <?=count($data_articuls_clear2)?></li>
            </ul>
            <pre>
                <?=json_encode($arr_dif, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)?>
            </pre>
        </div>
        <pre>
<!--            Кол-во уникальных элементов из выгрузки Домино: --><? ////=count($data_domino_clear)?>
            <? //= print_r($data_domino_clear);?>
        </pre>
    </div>
</section>


