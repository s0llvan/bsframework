<?php
/*
 * Form class for BSFramework
 *
 * @package BSFramework
 * @version 1.0
 */
class Form
{
    protected   $action,
                $method,
                $class,
                $id;
    
    public $inputs;
    
    private $html, $token;
    
    /*
     * Create a form
     *
     * @params {string} : Action
     * @params {string} : Method
     * @params {string} : Class
     * @params {string} : ID
     */
    public function __construct($action='#', $method='post', $class=null, $id=null) {
        $this->action = $action;
        $this->method = ($method != 'post' && $method != 'get') ? 'post' : $method;
        $this->class = $class;
        $this->id = $id;
		
		$token = uniqid(rand(), true);
		$token_time = time();
		
		$this->token = $token;
		$this->token_time = $token_time;
		
		Session::set('sys_token', $token);
		Session::set('sys_token_time', $token_time);
        
        $this->inputs = array();
    }
    
    /*
     * Add an input form
     *
     * @params {string} : Type
     * @params {string} : Name
     * @params {string} : Placeholder
     * @params {array}  : Values
     * @params {string} : Class
     * @params {string} : ID
     * @params {bool}   : Required
     */
    public function add($type, $name=null, $placeholder=null, $values=null, $class=null, $id=null, $required=false) {        
        $this->inputs[] = new Input($type, $name, $placeholder, $values, $class, $id, $required);
        return $this->inputs[count($this->inputs) - 1];
    }
    
    /*
     * Get Form Header
     *
     * @returns {string} : Return a html format of form header
     */
    public function GetHead() {
        $this->html = "<form";
        $this->html .= ($this->action) ? " action='$this->action'":'';
        $this->html .= ($this->method) ? " method='$this->method'":'';
        $this->html .= ($this->class) ? " class='$this->class'":'';
        $this->html .= ($this->id) ? " id='$this->id'":'';
        $this->html .= ">";        
        return $this->html;
    }
    
    /*
     * Get Form Footer
     *
     * @returns {string} : Return a html format of form footer
     */
    public function GetFoot() {
        return "</form>";
    }
    
    /*
     * Get Input
     *
     * @returns {string} : Return a html format of input
     */
    public function GetInput($name) {
        foreach($this->inputs as $input) {
            if($input->GetName() == $name)
                return utf8_encode($input->ToString());
        }
        return null;
    }
    
    /*
     * Get Input Label
     *
     * @returns {string} : Return a html format of input label
     */
    public function GetLabel($name) {
        foreach($this->inputs as $input) {
            if($input->GetName() == $name)
                return utf8_encode($input->label->ToString());
        }
        return null;
    }
    
    /*
     * HTML Form
     *
     * @returns {string} : Return a html format of form
     */
    public function ToString() {
        $this->html = "<form";
        $this->html .= ($this->action) ? " action='$this->action'":'';
        $this->html .= ($this->method) ? " method='$this->method'":'';
        $this->html .= ($this->class) ? " class='$this->class'":'';
        $this->html .= ($this->id) ? " id='$this->id'":'';
        $this->html .= ">";        
        
        foreach($this->inputs as $input)
        {
            $this->html .= "<div class='form-group'>";
            $this->html .= (($input->label) ? $input->label->ToString() : '')
                        . $input->ToString();
            $this->html .= "</div>";
        }
        
		$this->html .= "<input type='hidden' name='token' value='" . $this->token . "'/>";
        $this->html .= "</form>";
        
        return utf8_decode($this->html);
    }
}