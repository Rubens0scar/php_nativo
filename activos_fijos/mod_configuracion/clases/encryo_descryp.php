<?php
    class Encrypter {
 
	    private static $Key = "INE";
 
	public static function encrypt($string) {
	   $result = '';
	   $Llave = "INE";
	   for($i=0; $i<strlen($string); $i++) {
	      $char = substr($string, $i, 1);
	      $keychar = substr($Llave, ($i % strlen($Llave))-1, 1);
	      $char = chr(ord($char)+ord($keychar));
	      $result.=$char;
	   }
	   return base64_encode($result);
	}
	    
	public static function decrypt($string) {
	   $result = '';
	   $key= "INE";
	   $string = base64_decode($string);
	   for($i=0; $i<strlen($string); $i++) {
	      $char = substr($string, $i, 1);
	      $keychar = substr($key, ($i % strlen($key))-1, 1);
	      $char = chr(ord($char)-ord($keychar));
	      $result.=$char;
	   }
	   return $result;
	}
 	
    }
?>
