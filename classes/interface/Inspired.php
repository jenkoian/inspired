<?php
/**
 * Interface that all inspired classes should implement
 */
abstract class Inspired {
    
    /**
     * Our config object containing our api key, username etc.
     * @var InspiredConfig
     */
    protected $config;
    
    /**
     * Set auth, will take an InspiredConfig config obj
     */
    public function __construct(InspiredConfig $config) { 
        $this->config = $config;
    }
    
    /*
     * Get items, e.g. shots, tracks, posts etc.
     */
    abstract public function getItems();    
    
}