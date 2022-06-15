<?php 
    class Controller{
        public $model;
        public $urlView;
        public function __construct()
        {
            $this -> Model = new Model();
        }
        public function load($urlView, $data)
        {
            extract($data);
            if (file_exists($urlView)) {
                include $urlView;
            }
        }
    }
?>