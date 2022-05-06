<?php

class chkkatalog
{
    public $file_domino_path, $file_imshop_path;

    public function __construct()
    {
        $this->file_domino_path = "templates/assets/stores-data.csv";
        //    $this->file_imshop_path = "templates/assets/catalog.xml";
        //   $this->file_imshop_today_path = "templates/assets/catalog_3003.xml";
        $this->file_imshop_path = "templates/assets/catalog_0405.xml";
        $this->file_imshop_yestoday_path = "templates/assets/catalog_0505.xml";
        $this->file_imshop_today_path = "templates/assets/catalog_0605.xml";
    }

    function getImshopCatalog($url){

        $data = new stdClass();

        $data->contents=$this->getContentsXML($url);
        $result = $this->getXMLnode($data->contents, 'offers');
     //   $counter=$this->data->contents->count();
      //  $counter=$this->data->contents->count();
        return $result;
        //var_dump((string)$data->contents);
    }

    function &getXMLnode($object, $param) {
        foreach($object as $key => $value) {
            if(isset($object->$key->$param)) {
                return $object->$key->$param;
            }
            if(is_object($object->$key)&&!empty($object->$key)) {
                $new_obj = $object->$key;
                $ret = getCfgParam($new_obj, $param);
            }
        }
        if($ret) return (string) $ret;
        return false;
    }

    public function getContentsXML(string $url) : object
    {
        return simplexml_load_file($url);
    }

    function getDomino($url)
    {


        $row = 1;
        $html = "";
        $handle = fopen($this->file_domino_path, "r");
        $row = fgetcsv($handle, 0, ';');
        while (($row = fgetcsv($handle, 0, ';')) !== false) {
            //$id = $row[0];
            //$login = $row[1];
           $articles[] = $row[2];

            // или же, короче
            //list($id, $login, $age) = $row;
        }
        fclose($handle);

     //   var_dump($articles);

        return $articles;
    }
}