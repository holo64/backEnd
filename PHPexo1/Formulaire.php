<?php

class Formulaire {
    private $html="";
     //public $action = '';
     //public $method = '';

    public function __construct($method,$action=""){
        $this->html .= "<form method='$method' action='$action'>";

    }

    // private function input ($type,$name,$value,$label='',$id=''){
    //     return "<label for='$id'>$label</label><input type='$type' name='$name' value='$value' id='$id' />";
    // }

    private function input ($type,$name,$value,$required,$label='',$id=''){
        if($label!='' && $id!=''){
                $rsp="<label for='$id'>$label</label> : <input type='$type' name='$name' value='$value' id='$id' $required /><br/><br/>";     
        }
        else {
                $rsp="<input type='$type' name='$name' value='$value' id='$id' $required /><br/><br/>";
        }
        return $rsp;
    }


    public function inputText($name,$value='',$required="",$label,$id){
       // $this->html .= "<input type='text' name='$name' value='$value' />";
       $this->html .= $this->input('text',$name,$value,$required,$label,$id);
    }

    public function inputNumber($name,$value='',$required="",$label,$id){
        // $this->html .= "<input type='text' name='$name' value='$value' />";
        $this->html .= $this->input('number',$name,$value,$required,$label,$id);
     }


    public function inputSubmit($name,$value,$required=false){
        //$this->html .= "<input type='submit' name='$name' value='$value' />";
        $this->html .= $this->input('submit',$name,$value,$required);
    }

    
    public function inputDate ($name,$value='',$required=false){
        $this->html .= $this->input('date',$name,$value,$required).'<br/>';
    }
      
    public function inputMail ($name,$value='',$label='',$id='',$required=false){
        $this->html .= $this->input('email',$name,$value,$required,$label,$id).'<br/>';
    }

    public function inputTel ($name,$value='',$label='',$id='',$required=""){
        $this->html .= $this->input('tel',$name,$value,$required,$label,$id).'<br/>';
    }


    public function select($name,$tableau,$selected=''){
        $this->html .= "<select name='$name'>";

        foreach ($tableau as $key =>$value){
            if ($selected == $key){
                $this->html .= "<option value='$key' selected>$value</option>";
            }
            else {
                $this->html .= "<option value='$key'>$value</option>";
            }         
        }
        $this->html .= "</select><br/><br/>";

    }

    // public function inputCheckbox($tableau){
    //     foreach ($tableau as $value){
            
    //         $this->html .= '<input type="checkbox" name="'.$value["nom"].'" id="'.$value["id"].'>
    //         <label for="'.$value["id"].'>'.$value["texte"].'</label><br/>';
    //     }
    //     $this->html ;

    // }

    public function checkBox($name,$value,$label='',$checked=''){              
            if($label!=''){
                $this->html .= "
                <input type='checkbox' name='$name' value='$value' $checked />
                <label>$label</label><br/>
                ";
            }
            else{
                $this->html .= "
                <input type='checkbox' name='$name' value='$value' $checked /><br/>
                ";
            }
    }
  
    public function radio($name,$tableau,$checked=''){     
        
        
            foreach($tableau as $key=> $value){
                if ($checked == $key){
                    $this->html .= "
                    <input type='radio' id='$key' name='$name' value='$value' checked>
                    <label for='$key'>$key</label><br/>
                    ";
                }
                else{
                    $this->html .= "
                    <input type='radio' id='$key' name='$name' value='$value'>
                    <label for='$key'>$key</label><br/>
                    ";
                }

        }
     
}

    
    public function  render(){
        echo $this->html .'</form>';
            
    }

}
