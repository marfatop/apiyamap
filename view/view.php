<?php

class view
{
    function display($layout, $template = null)
    {
//        $data['lastdata']=$this->getLastData();
//        $data['error']=$this->getDataError();
//        $data['reports']=$this->getReports();
//        $data['config']=$this->getTemplateConfig();
        $data = $this->getTemplate($layout, $template);
        return $data;
    }

    function getTemplate($template, $arrResult=null)
    {

        $path = $_SERVER['DOCUMENT_ROOT'] . "/". $template; // . '/' . $file . '.php';

        ob_start();
            require $path;
        $data = ob_get_clean();

        return $data;
    }
}