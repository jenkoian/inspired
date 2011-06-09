<?php

class TumblrAPI extends Inspired {        
    
    public $perPage = 15;
    
    public $items = array();
    
    public function __construct(TumblrConfig $config) {
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
        return $this->getPosts();
    }
    
    /**
     *
     * @return array
     */
    private function getPosts() {
        
        $posts = array();

        $xml = wp_remote_get($this->config->url.'?num=' . $this->perPage);
        
        $simpleXml = new SimpleXMLElement($xml['body']);
        
        $i = 0;
        foreach ($simpleXml->posts->post as $post) {
            $posts[$i]['url'] = (string)$post->attributes()->url;
            $posts[$i]['image_url'] = (string)$post->{'photo-url'}[1];  
            $posts[$i]['date'] = (string)$post['unix-timestamp'];            
            
            ++$i;
        }

        return $posts;        
    }
}