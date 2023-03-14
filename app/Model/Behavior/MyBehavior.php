<?php
class MyBehavior extends ModelBehavior{
	
	 public function getColumnValue($row,$kolomIndex){
		 	$srow=$row."|";
			$nilai="";
			for ($i=0;$i<$kolomIndex;$i++){
				$nilai = substr($srow,0,strpos($srow,"|"));
				$srow=substr($srow,strpos($srow,"|") + 1,strlen($srow));
			};
			return $nilai;
		 }
	}
?>