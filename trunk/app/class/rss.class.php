<?php
if(basename(__FILE__) == basename($_SERVER['PHP_SELF'])){exit();}

/* ****************************************************
*
*  Samstyle PHP Framework
*  RSS reading helper class
*  Created by: Sam Yong | Date/Time: 10:20pm 9th November 2009 GMT+8
*
**************************************************** */

/*
 * Sample usage:
 *       $rss = new rss('http://example.com/feed.rss');
 *       $rss->parse();
 *       foreach($rss->get() as $entry){
 *         // entry
 *       }
 */

class rss{

  private $file = '';
  private $currentElements = array();
  private $itemCount = 0;
  private $newsArray = array();
  private $metaArray = array();

  public function __construct($file){
    $this->file = $file;
  }

  public function parse(){
	$this->currentElements = array();
	$this->itemCount=0;
     $xmlParser = xml_parser_create();

     xml_parser_set_option($xmlParser, XML_OPTION_CASE_FOLDING, false); 
     xml_set_element_handler($xmlParser, array($this, 'startElementRSS'), array($this, 'endElementRSS'));
     xml_set_character_data_handler($xmlParser, array($this,'characterDataRSS'));
   
     $fp = file_get_contents($this->file);
if($fp != false){
  if(!xml_parse($xmlParser,$fp, true)){ return false;}
}
     xml_parser_free($xmlParser);
return true;
   }

public function get(){
return $this->newsArray;
}

public function getmeta(){
return $this->metaArray;
}

  private function startElementRSS($parser, $name, $attrs){
     array_push($this->currentElements, $name);
     if($name == 'item' || $name == 'channel'){$this->itemCount += 1;}
   } 

  private function characterDataRSS($parser, $data){
     $currentCount = count($this->currentElements);
     $parentElement = $this->currentElements[$currentCount-2];
     $thisElement = $this->currentElements[$currentCount-1];
     if($parentElement == 'item'){$this->newsArray[$this->itemCount-1][$thisElement] .= $data;}
     if($parentElement == 'channel' && $thisElement != 'item' && $thisElement != 'images'){$this->metaArray[$thisElement] .= $data;}
}

  private function endElementRSS($parser, $name) {
     $currentCount = count($this->currentElements);
     if($this->currentElements[$currentCount-1] == $name){ array_pop($this->currentElements);}
   }

}
