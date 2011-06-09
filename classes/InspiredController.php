<?php

class InspiredController {
    
    // An array of site configs
    public $siteConfigs = array();
    
    public $items = array();
        
    public function __construct() {}
    
    public function addSiteConfig($siteConfig) {
        $this->siteConfigs[] = $siteConfig;
    }
    
    public function getItems() {
                
        foreach ($this->siteConfigs as $siteConfig) {
            $siteObj = $this->loadSiteApi($siteConfig);
            $this->items[get_class($siteConfig)] = $siteObj->getItems();
        }
        
        // @todo Epic sort of the items
        
        return $this->items;
    }
    
    public function loadSiteApi($siteConfig) {
        return InspiredFactory::getApi($siteConfig);
    }
}