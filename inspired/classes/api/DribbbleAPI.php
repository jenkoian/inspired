<?php

class DribbbleAPI extends Inspired {        
    
    public $perPage = 15;
    
    public $items = array();
    
    public function __construct(DribbbleConfig $config) {
        parent::__construct($config);        
    }
    
    /**
     * @todo Items should always return an array of the following...
     *          url
     *          image_url
     *          date
     * 
     * @return array
     */
    public function getItems() {
        foreach ($this->getShots() as $k=>$shot) {
            $this->items[$k]['url'] = $shot->url;
            $this->items[$k]['image_url'] = $shot->image_url;
            $this->items[$k]['date'] = strtotime($shot->created_at);
        }
        
        return $this->items;
    }
    
    /**
     *
     * @return array
     */
    private function getShots() {

        $json = wp_remote_get($this->config->url . 'players/' . $this->config->username . '/shots/likes?per_page=' . $this->perPage);
        
        $results = json_decode($json['body']);
        
        $shots = $results->shots;

        return $shots;        
    }
}