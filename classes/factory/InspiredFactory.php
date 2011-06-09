<?php

class InspiredFactory {
    
    public function __construct() { }
    
    public static function getApi(InspiredConfig $config) {
        
        // Convention is SitenameConfig
        $siteName = str_replace("Config","",get_class($config));
        
        $className = $siteName.'Api';
        
        if (class_exists($className)) {            
            return new $className($config);
        }
    }
}