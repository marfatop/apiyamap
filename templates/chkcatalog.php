<?php
$GLOBALS['scripts'][] = "scripts/chkkatalog.js";
require_once "models/chkkatalog.php";

$model = new chkkatalog();
//$model->getDomino();

$data_imshop = $model->getImshopCatalog($model->file_imshop_path);
$data_imshop_yestoday = $model->getImshopCatalog($model->file_imshop_yestoday_path);
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
            $articuls3 = [];
            foreach ($data_imshop->offer as $index => $item) {
                if ($item->attributes()['available']->__toString() == "true") {
                    // $article1 = $item->attributes()['uuid']->__toString();
                    $id = $item->attributes()['id']->__toString();
                    $name = $item->name->__toString();
                    $articuls[$id] = $name;
                }
            }
            foreach ($data_imshop_yestoday->offer as $index2 => $item2) {
                if ($item2->attributes()['available']->__toString() == "true") {
                    // $article2 = $item2->attributes()['uuid']->__toString();
                    $id = $item2->attributes()['id']->__toString();
                    $name = $item2->name->__toString();
                    $articuls2[$id] = $name;
                }
            }
            foreach ($data_imshop_today->offer as $index3 => $item3) {
                if ($item3->attributes()['available']->__toString() == "true") {
                    //  $article3 = $item3->attributes()['uuid']->__toString();
                    $id = $item3->attributes()['id']->__toString();
                    $name = $item3->name->__toString();
                    $articuls3[$id] = $name;
                }
            }
            $data_articuls_clear = array_unique($articuls);
            ksort($data_articuls_clear, SORT_NUMERIC);

            $data_articuls_clear2 = array_unique($articuls2);
            ksort($data_articuls_clear2, SORT_NUMERIC);

            $data_articuls_clear3 = array_unique($articuls3);
            ksort($data_articuls_clear3, SORT_NUMERIC);

            $arr_dif1 = array_diff_key($data_articuls_clear, $data_articuls_clear2);
            $arr_dif2 = array_diff_key($data_articuls_clear2, $data_articuls_clear3);
            $arr_dif3 = array_diff_key($data_articuls_clear, $data_articuls_clear3,);
            $arr_dif4 = array_diff_key($data_articuls_clear3, $data_articuls_clear);

            //  print_r($data_articuls_clear);
            ?>
            <? //var_dump($data_imshop->offer)?>

        </pre>
        <div>
            <ul>
                <li>Кол-во уникальных элементов из выгрузки 04 мая Имшоп: <?=count($data_articuls_clear)?></li>
                <li>Кол-во уникальных элементов из выгрузки 05 мая Имшоп: <?=count($data_articuls_clear2)?></li>
                <li>Кол-во уникальных элементов из выгрузки 06 мая Имшоп: <?=count($data_articuls_clear3)?></li>
            </ul>
            <div>
                <h2>Товары которые есть 04 и нет 06: <?=count($arr_dif3)?></h2>
                <table>
                    <? foreach ($arr_dif3 as $index_dif3 => $item_dif3) : ?>
                        <tr>
                            <td><?=$index_dif3?></td>
                            <td><?=$item_dif3?></td>
                        </tr>
                    <? endforeach; ?>
                </table>
                <h2>Товары которые есть 06 и нет 04: <?=count($arr_dif4)?></h2>
                <table>
                    <? foreach ($arr_dif4 as $index_dif4 => $item_dif4) : ?>
                        <tr>
                            <td><?=$index_dif4?></td>
                            <td><?=$item_dif4?></td>
                        </tr>
                    <? endforeach; ?>
                </table>
                <pre>
                <? //=json_encode($arr_dif3, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)?>
            </pre>
            </div>
            <!--            -->
            <!--            <h2>05-06 разница элементов: --><? //=count($arr_dif2)?><!--</h2>-->
            <!---->
            <!--            <table>-->
            <!--                --><? // foreach ($arr_dif2 as $index_dif2 => $item_dif2) :?>
            <!--                    <tr><td>--><? //=$index_dif2?><!--</td><td>--><? //=$item_dif2?><!--</td></tr>-->
            <!--                --><? // endforeach;?>
            <!--            </table>-->
            <!---->
            <!--            <pre>-->
            <!--                --><? ////=json_encode($arr_dif2, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)?>
            <!--            </pre>-->
            <!--            <h2>04-05 разница элементов: --><? //=count($arr_dif1)?><!--</h2>-->
            <!--            <table>-->
            <!--                --><? // foreach ($arr_dif1 as $index_dif1 => $item_dif1) :?>
            <!--                    <tr><td>--><? //=$index_dif1?><!--</td><td>--><? //=$item_dif1?><!--</td></tr>-->
            <!--                --><? // endforeach;?>
            <!--            </table>-->
            <!--            <pre>-->
            <!--                --><? ////=json_encode($arr_dif1, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)?>
            <!--            </pre>-->
            <!---->
            <!--        </div>-->
            <pre>
<!--            Кол-во уникальных элементов из выгрузки Домино: --><? ////=count($data_domino_clear)?>
                <? //= print_r($data_domino_clear);?>
        </pre>
        </div>
</section>


