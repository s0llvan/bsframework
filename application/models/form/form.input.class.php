<?php
/*
 * Input class for BSFramework
 *
 * @package BSFramework
 * @version 1.0
 */
class Input
{
    public $label;
        
    private $html,
            $name,
            $id,
            $class;
    
    /*
     * Create a input form
     *
     * @params {string} : Type
     * @params {string} : Name
     * @params {string} : Placeholder
     * @params {array}  : Values
     * @params {string} : Class
     * @params {string} : ID
     * @params {bool}   : Required
     */
    public function __construct($type, $name=null, $placeholder=null, $values=null, $class=null, $id=null, $args=null) {
        $this->name = $name;
        $this->id = $id;
        $this->class = $class;
                
        switch($type) {
            case 'textarea':
                $this->createTextArea($name, $placeholder, $values[0], $class, $id, $args);
                break;
                
            case 'select':
                $this->createInputSelect($name, $values, $class, $id, $args);
                break;
            
            case 'button':
            case 'reset':
            case 'submit':
                $this->createInputButton($type, $name, $values[0], $class, $id, $args);
                break;
                
            default:
                $this->createInputText($type, $name, $placeholder, $values[0], $class, $id, $args);
                break;
        } 
    }
    
    /*
     * Create an input
     *
     * @params {string} : Type
     * @params {string} : Name
     * @params {string} : Placeholder
     * @params {string} : Value
     * @params {string} : Class
     * @params {string} : ID
     * @params {bool}   : Required
     */
    private function createInputText($type, $name, $placeholder=null, $value=null, $class=null, $id=null, $args=null) {
        $this->html = "<input";
        $this->html .= ($type) ? " type='$type'" : "";
        $this->html .= ($name) ? " name='$name'" : "";
        $this->html .= ($id) ? " id='$id'" : "";
        $this->html .= ($placeholder) ? " placeholder='$placeholder'" : "";
        $this->html .= ($class) ? " class='$class'" : "";
        $this->html .= ($value) ? " value='$value'" : "";
        for($i = 0;$i < count($args);$i++) {
            $this->html .= " " . $args[$i];
        }
        $this->html .= "/>";
    }
    
    /*
     * Create a textarea
     *
     * @params {string} : Name
     * @params {string} : Placeholder
     * @params {string} : Value
     * @params {string} : Class
     * @params {string} : ID
     */
    private function createTextArea($name, $placeholder, $value=null, $class=null, $id=null, $args=null) {        
        $this->html = "<textarea";
        $this->html .= ($name) ? " name='$name'" : "";
        $this->html .= ($placeholder) ? " placeholder='$placeholder'" : "";
        $this->html .= ($class) ? " class='$class'" : "";
        $this->html .= ($id) ? " id='$id'" : "";
        for($i = 0;$i < count($args);$i++) {
            $this->html .= " " . $args[$i];
        }
        $this->html .= ">";
        $this->html .= ($value) ? $value : "";
        $this->html .= "</textarea>";
    }
    
    /*
     * Create a select input
     *
     * @params {string} : Name
     * @params {array}  : Values
     * @params {string} : Class
     * @params {string} : ID
     */
    private function createInputSelect($name, $values, $class=null, $id=null, $args=null) {
        $this->html = "<select";
        $this->html .= ($name) ? " name='$name'" : "";
        $this->html .= ($class) ? " class='$class'" : "";
        $this->html .= ($id) ? " id='$id'" : "";
        for($i = 0;$i < count($args);$i++) {
            $this->html .= " " . $args[$i];
        }
        $this->html .= ">";
        foreach ($values as $value => $option) {
            $this->html .= "<option value='$value'>$option</option>";
        }
        $this->html .= "</select>";
    }
    
    /*
     * Create an input button
     *
     * @params {string} : Type
     * @params {string} : Name
     * @params {string} : Value
     * @params {string} : Class
     * @params {string} : ID
     */
    private function createInputButton($type, $name, $value=null, $class=null, $id=null, $args=null) {
        $this->html = "<input";
        $this->html .= ($type) ? " type='$type'" : "";
        $this->html .= ($name) ? " name='$name'" : "";
        $this->html .= ($id) ? " id='$id'" : "";
        $this->html .= ($class) ? " class='$class'" : "";
        $this->html .= ($value) ? " value='$value'" : "";
        for($i = 0;$i < count($args);$i++) {
            $this->html .= " " . $args[$i];
        }
        $this->html .= "/>";
    }
    
    /*
     * Create a label for an input form
     *
     * @params {string} : Text
     * @params {string} : Class
     * @params {string} : ID
     */
    public function label($text, $class=null, $id=null) {
        $this->label = new Label($text, $this->id, $class, $id);
        return $this->label;
    }
    
    /*
     * Get name of input
     *
     * @return {string} : Return input name
     */
    public function getName() {
        return $this->name;
    }
    
    /*
     * HTML Input form
     *
     * @returns {string} : Return a html format of input form
     */
    public function ToString() {
        return utf8_encode($this->html);
    }
}