<?php
/*
 * Table class for BSFramework
 *
 * @package BSFramework
 * @version 1.0
 */
class Table
{
    protected $class,
              $id;
    
    private $head,
            $foot,
            $body,
            $content;
    
    public function __construct($head=null, $foot=null, $class=null, $id=null) {
        $this->createHead($head);
        $this->createFoot($foot);
        $this->class = $class;
        $this->id = $id;
    }
    
    private function createHead($head) {
        if($head != null) {
            $this->head .= "<tr>";
            foreach($head as $row) {
                $this->head .= "<td>";
                $this->head .= $row;
                $this->head .= "</td>";
            }
            $this->head .= "</tr>";
        }
    }
    
    private function createFoot($foot) {
        if($foot != null) {
            $this->foot .= "<tr>";
            foreach($foot as $row) {
                $this->foot .= "<td>";
                $this->foot .= $row;
                $this->foot .= "</td>";
            }
            $this->foot .= "</tr>";
        }
    }
    
    public function add($line) {
        $this->body .= "<tr>";
        foreach($line as $row) {
            $this->body .= "<td>";
            $this->body .= $row;
            $this->body .= "</td>";
        }
        $this->body .= "</tr>";
    }
    
    public function ToString() {                
        $this->content =
        "
            <table" . (($this->class != null) ? " class='$this->class'":'') . (($this->id != null) ? " id='$this->id'":'') . ">
            <thead>$this->head</thead>
            <tbody>$this->body</tbody>
            <tfoot>$this->foot</tfoot>
            </table>
        ";
        
        return utf8_decode($this->content);
    }
}