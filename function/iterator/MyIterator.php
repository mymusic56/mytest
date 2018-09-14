<?php

class MyIterator implements Iterator {
    private $position = 0;
    private $arr = [
        'first', 'second', 'third',
    ];
    
    public function __construct() {
        $this->position = 0;
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see Iterator::rewind()
     */
    public function rewind() {
        var_dump(__METHOD__);
        $this->position = 0;
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see Iterator::current()
     */
    public function current() {
        var_dump(__METHOD__);
        return $this->arr[$this->position];
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see Iterator::key()
     */
    public function key() {
        var_dump(__METHOD__,$this->position);
        return $this->position;
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see Iterator::next()
     */
    public function next() {
        ++$this->position;
        var_dump(__METHOD__, $this->position);
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see Iterator::valid()
     */
    public function valid() {
        var_dump(__METHOD__);
        return isset($this->arr[$this->position]);
    }
    
}