<?php
if(! class_exists('wp_auto_spinner_Spintax')){
	class wp_auto_spinner_Spintax {
		
		public $editor_form;
	
	   function spin($string, $view=false)
	   {
	      $z=-1;
	      $input = $this->bracketArray($string);
	      
	     
	      
	      for($i=0; $i<count($input);$i++){
	         for($x=0; $x<count($input[$i]);$x++) {
	            if(!$input[$i][$x]==""||"/n"){
	               $z++;
	               if(strstr($input[$i][$x], "|")){
	                  $out = explode("|", $input[$i][$x]);
	                  $output[$z]=$out[rand(1, count($out)-2)];
	                  
	                  //invert synonyms
	                  $synonyms=$input[$i][$x];
	                  $synonyms=explode('|', $synonyms);
	                  
	                  
	                  //$synonyms=array_reverse($synonyms);
	                 
	                  $synonyms=implode( '|',$synonyms);
	                  
	                  $output2[$z] = '<span  synonyms="'.$synonyms.'" class="synonym">'.$out[rand(1, count($out)-1)].'</span>';
	               } else {
	                  $output[$z] = $input[$i][$x];
	                  $output2[$z] = $input[$i][$x];
	               }
	            }
	         }
	      }
	      $res='';
	      $res2='';
	      for($i=0;$i<count($output);$i++){
	        $res .=  $output[$i];
	        $res2 .= $output2[$i];
	      }
	      
	      $this->editor_form = $res2;
	      return $res;
	      
	   }
	   
	   
	   function bracketArray($str, $view=false)
	   {
	      @$string = explode( "{", $str);
 
	      for($i=0;$i<count($string);$i++){
	         @$_string[$i] = explode("}", $string[$i]);
	      }
	      if($view){
	         $this->printArray($_string);
	      }
	      return $_string;
	   }
	   
	   function cleanArray($array){
	      for($i=0;$i<count($array);$i++){
	         if($array[$i]!=""){
	            $cleanArray[$i] = $array[$i];
	         }
	      }
	      return $cleanArray;
	   }
	   
	   function printArray($array)
	   {
	      echo '<pre>';
	      print_r($array);
	      echo '</pre>';
	   }
	}
}

?>
