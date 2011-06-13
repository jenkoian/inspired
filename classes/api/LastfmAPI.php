<?php

class LastfmAPI extends Inspired {        
    
    public $perPage = 15;
    
    public $items = array();
    
    public function __construct(LastfmConfig $config) {
        parent::__construct($config);        
    }
    
    /**
     * 
     * @return array
     */
    public function getItems() {
        return $this->getTracks();
    }
    
    /**
     *
     * @return array
     */
    private function getTracks() {
        
        $tracks = array();

        $xml = wp_remote_get($this->config->url.'&user='.$this->config->username.'&api_key='.$this->config->key.'&limit='.$this->perPage);
        
        try {
            $simpleXml = new SimpleXMLElement($xml['body']);

            $i = 0;
            foreach ($simpleXml->lovedtracks->track as $track) {

                $tracks[$i]['url'] = (string)$track->{'url'};
                $tracks[$i]['image_url'] = (string)$track->{'image'}[3];  
                $tracks[$i]['date'] = (string)$track->{'date'}->attributes()->uts;            

                ++$i;
            }
        } catch (Exception $e) {
            // If we get an exception just return empty array for now
            return array();
        }

        return $tracks;        
    }
}