<?php
    class Tag extends AppModel {
		var $name = 'Tag';
       
        public $hasAndBelongsToMany = array('Upload');
    }
?>