<?php

namespace ext\xcommerce;

class Xcommerce{

    /**
	 * Constructor
	 */
	public function __construct(){
        add_filter('xcommerce_templates_dir',[$this, 'templates_dir']);
	}
	
	public function templates_dir($dir){
	    $dir = __DIR__ . '/templates';
	    return $dir;
	}
}