<?php
/*
 * Label class for BSFramework
 *
 * @package BSFramework
 * @version 1.0
 */
class Label
{
    private $html;
    
    /*
     * Create a label form
     *
     * @params {string} : Text
     * @params {string} : Target name
     * @params {string} : Class
     * @params {string} : ID
     */
    public function __construct($text, $for=null, $class=null, $id=null) {        
        $this->html = "<label";
        $this->html .= ($for != null) ? " for='$for'" : "";
        $this->html .= ($class != null) ? " class='$class'" : "";
        $this->html .= ($id != null) ? " id='$id'" : "";
        $this->html .= ">";
        $this->html .= ($text != null) ? $text : "";
        $this->html .= "</label>";
    }
    
    /*
     * HTML Label form
     *
     * @returns {string} : Return a html format of label form
     */
    public function ToString() {
        return utf8_encode($this->html);
    }
}