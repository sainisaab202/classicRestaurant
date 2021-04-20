<?php

##DEVELOPER          DATE        COMMENTS
#Gurpreet(1911343)   18/04/2021  created class collection with methods add, remove, get, count


//we will use this class to inherit in other
//this one class we will use for all others plural classes
class collection{
    
    public $items = array();
    
    public function add($primary_key, $item){
        $this->items[$primary_key] = $item;
        #return $item; //we don't need to but in case
    }
    
    public function remove($primary_key){   ##means uuid
        if(isset($this->items[$primary_key])){
            unset($this->items[$primary_key]);  //to remove from our collection
        }
        #return $item; //we don't need to but in case
    }
    
    public function get($primary_key){   ##means uuid
        if(isset($this->items[$primary_key])){
            return $this->items[$primary_key];  //to remove from our collection
        }
        #return $item; //we don't need to but in case
    }
    
    public function count(){
        return count($this->items);
    }
}