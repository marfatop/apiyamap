<?php

include_once "view/view.php";

class controller
{
    protected $template_name, $layout, $querystring;
    private $_vars=array();

    public function __construct()
    {
       // $this->getRequest();
        $this->getData();
        return true;
    }
    function getData() : void{
        $method=$_SERVER['REQUEST_METHOD'];
        switch ($method){
            case 'GET':
                $this->_vars=$this->requestGet();
                break;
            case 'POST':
                $this->_vars=$this->requestPost();
                break;
        }
    }

    function requestGet() : array{
        return $_GET;
    }
    function requestPost() : array{
        return $_POST;
    }

    function getRequest() :void{

        $this->template_name = basename($_SERVER['REQUEST_URI']);
    }
    function getQueryString() :void{
        $this->querystring = $_SERVER['QUERY_STRING'];
    }

    function getTemplate() : string {
       // var_dump($this->_vars);
        $arrResult=[];
       if(isset($this->_vars['app']))
        {
            require_once $_SERVER['DOCUMENT_ROOT']."/models/".$this->_vars['app'].".php";

            $model= new $this->_vars['app']();
            $method=$this->_vars['method'];
            $arrResult=$model->$method();
        }
        isset($this->_vars['page']) ? $this->template_name=$this->_vars['page'] :  $this->template_name='default.php';
     //   $tmplPath = $this->template_name==="index.php" ? "templates/default.php" : "templates/$this->template_name";
        $tmplPath ="templates/$this->template_name";

        if (file_exists($tmplPath)) {
            $view=new view();
            $data=$view->getTemplate($tmplPath, $arrResult);
        } else {
            throw new Exception("Шаблон {$this->template_name} не найден");
        }
        //$data=$tmplPath;

       return $data;
    }
}