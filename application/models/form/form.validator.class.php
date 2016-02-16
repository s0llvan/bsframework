<?php
/*
 * FormValidator class for BSFramework
 *
 * @package BSFramework
 * @version 1.0
 */
class FormValidator
{
    private $errors;
    
    private $form;
    
    private $alpha,
            $numeric,
            $special,
            $email;

    private $url = array();
    
    public function __construct() {
        $this->errors = [];
        
        $this->special = ['-','*','/','.','#','$','^','%',':',';','!','?','+','=','_','|','[',']','{','}','(',')','@'];
        $this->email = ['@','-','.'];
    }
    
    public function Run($form, $url=array()) {
        $this->form = $form;
        for($i=0;$i<count($url);$i++) {
            array_push($this->url, WEBSITE_ADDRESS . $url[$i]);
        }
    }
    
    public function validation_rules($valid_rules) {
        $valid_rules_fields = array_keys($valid_rules);
        $form_fields = array_keys($this->form);

        for ($u = 0; $u < count($valid_rules_fields); $u++)
        {
            $rule_field = $valid_rules_fields[$u];
            $rules = $valid_rules[$valid_rules_fields[$u]];

            $form_field = (isset($this->form[$rule_field]) ? $rule_field : null);
            $form_value = (isset($this->form[$rule_field]) ? $this->form[$rule_field] : null);
            
            if(!is_array($rules)) {
                closeWithException(debug_backtrace(),"Validation rules need an array");
            }

            foreach($rules as $rule)
            {
                switch ($rule)
                {
                    case 'required':
                        if ($form_field == null) {
                            array_push($this->errors, [$rule_field => $rule]);
                        }
                        break;

                    case 'alpha_numeric':
                        if (preg_match('/[^A-Za-z0-9]/', $form_value)) {
                            array_push($this->errors, [$form_field => $rule]);
                        }
                        break;

                    case 'alpha_numeric_space':
                        if (preg_match('/[^A-Za-z0-9 ]/', $form_value)) {
                            array_push($this->errors, [$form_field => $rule]);
                        }
                        break;

                    case 'alpha_numeric_special':
                        for ($o = 0; $o < strlen($form_value); $o++) {
                            $char = $form_value[$o];

                            if (preg_match('/[^A-Za-z0-9]/', $form_value) && !in_array($char, $this-> special)) {
                                array_push($this->errors, [$form_field => $rule]);
                                $o = strlen($form_value);
                            }
                        }
                        break;

                    case 'alpha':
                        if (preg_match('/[^A-Za-z]/', $form_value)) {
                            array_push($this->errors, [$form_field => $rule]);
                        }
                        break;

                    case 'alpha_space':
                        if (preg_match('/[^A-Za-z ]/', $form_value)) {
                            array_push($this->errors, [$form_field => $rule]);
                        }
                        break;

                    case 'numeric':
                        if (preg_match('/[^0-9]/', $form_value)) {
                            array_push($this->errors, [$form_field => $rule]);
                        }
                        break;

                    case 'numeric_space':
                        if (preg_match('/[^0-9 ]/', $form_value)) {
                            array_push($this->errors, [$form_field => $rule]);
                        }
                        break;

                    case 'min_len':
                        $number = $rules[array_search($rule, $rules) + 1];

                        if (strlen($form_value) < $number) {
                            array_push($this->errors, [$form_field => $rule]);
                        }
                        break;

                    case 'max_len':
                        $number = $rules[array_search($rule, $rules) + 1];

                        if (strlen($form_value) > $number) {
                            array_push($this->errors, [$form_field => $rule]);
                        }
                        break;

                    case 'len':
                        $number = $rules[array_search($rule, $rules) + 1];

                        if (strlen($form_value) != $number) {
                            array_push($this->errors, [$form_field => $rule]);
                        }
                        break;

                    case 'equal':
                        $need_equal_value = $rules[array_search($rule, $rules) + 1];

                        if ($form_value != $need_equal_value) {
                            array_push($this->errors, [$form_field => $rule]);
                        }
                        break;

                    case 'email':
                        if (!preg_match('/^[a-z.-]+@[a-z.-]+\.[a-z]{2,6}$/', $form_value) || !filter_var($form_value, FILTER_VALIDATE_EMAIL)) {
                            array_push($this->errors, [$form_field => $rule]);
                        }
                        break;

                    case 'date':
                        if (!preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $form_value)) {
                            array_push($this->errors, [$form_field => $rule]);
                        }
                        break;
                        
                    case 'url':
                        if (!filter_var($form_value, FILTER_VALIDATE_URL)) {
                            array_push($this->errors, [$form_field => $rule]);
                        }
                        break;
                        
                    case 'ip':
                        if (!filter_var($form_value, FILTER_VALIDATE_IP)) {
                            array_push($this->errors, [$form_field => $rule]);
                        }
                        break;
                        
                    case 'mac':
                        if (!filter_var($form_value, FILTER_VALIDATE_MAC)) {
                            array_push($this->errors, [$form_field => $rule]);
                        }
                        break;
                }
            }
        }
    }
    
    public function filter_rules($filter_rules) {
        $filter_rules_fields = array_keys($filter_rules);
        $form_fields = array_keys($this->form);
                
        for($i = 0;$i < count($form_fields);$i++)
        {
            $form_field = $form_fields[$i];
            
            for($u = 0;$u < count($filter_rules_fields);$u++)
            {
                if($filter_rules_fields[$u] == $form_field)
                {
                    $value = $this->form[$form_field];
                    $rules = $filter_rules[$filter_rules_fields[$u]];
                    
                    if(!is_array($rules)) {
                        closeWithException(debug_backtrace(),"Filter rules need an array");
                    }

                    foreach($rules as $rule)
                    {                        
                        switch($rule)
                        {
                            case 'trim':
                                $this->form[$form_field] = trim($value);
                                break;
                                
                            case 'base64_encode':
                                $this->form[$form_field] = base64_encode($value);
                                break;
                                
                            case 'base64_decode':
                                $this->form[$form_field] = base64_decode($value);
                                break;
                                
                            case 'md5':
                                $this->form[$form_field] = md5($value);
                                break;
                                
                            case 'sha1':
                                $this->form[$form_field] = sha1($value);
                                break;
                                
                            case 'htmlencode':
                                $this->form[$form_field] = htmlentities($value);
                                break;
                        }
                    }
                }
            }
        }
    }
    
    public function get($field) {
        return (isset($this->form[$field]) ? $this->form[$field] : null);
    }
    
    public function getError($field) {
        for($i=0;$i<count($this->errors);$i++) {
            if(isset($this->errors[$i][$field])) {
                return $this->errors[$i][$field];
            }
        }
    }
    
    public function getErrors() {
        return $this->errors;
    }

    public function isValid() {
        // Form expired after 5 minutes
        $token_oldtime = time() - (5*60);
        $httReferer = $_SERVER['HTTP_REFERER'];
        if(!in_array($httReferer, $this->url)) {
            array_push($this->errors, ['HTTP_REFERER' => true]);
        }
        if(Session::get('sys_token') != $this->form['token']) {
            array_push($this->errors, ['TOKEN' => true]);
        }
        if(Session::get('sys_token_time') == $token_oldtime) {
            array_push($this->errors, ['TOKEN_TIME' => true]);
        }
        return count($this->errors) <= 0;
    }
}