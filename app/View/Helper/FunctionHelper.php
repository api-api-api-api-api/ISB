<?php
App::uses('AppHelper','View/Helper');
class FunctionHelper extends AppHelper{
function inp_termin($termin){
	echo "<select name=\"".$termin."\" id=\"".$termin."\" class='roundIt'>\n";

			echo "<option value='I' selected='selected'>I</option>\n";
			echo "<option value='II' selected='selected'>II</option>\n";
			echo "<option value='III' selected='selected'>III</option>\n";
			echo "<option value='IV' selected='selected'>IV</option>\n";
			echo "<option value='S1' selected='selected'>S1</option>\n";
			echo "<option value='S2' selected='selected'>S2</option>\n";
			echo "<option value='F' selected='selected'>F</option>\n";
			
	echo "		</select>\n";
	}	
function inp_tahun($year){
	echo "<select name=\"".$year."\" id=\"".$year."\" class='form-control' style='font-size:12px !important'>\n";
	for ($t=date("Y")-5;$t<=date("Y")+10;$t++){
		if($t==date("Y")){
			echo "<option value=$t selected='selected'>$t</option>\n";
			}
		else{echo "<option value=$t>$t</option>\n";}
	}
	echo "		</select>\n";
	}
function inp_bulan($month){
	echo "<select name=\"".$month."\" id=\"".$month."\" class='form-control' style='font-size:12px !important'>";
			for($t=1;$t<=12;$t++){
				if($t==date("n")){
				echo "<option value=$t selected='selected'>".$this->monthName($t)."</option>\n";
				}
				else{echo "<option value=$t>".$this->monthName($t)."</option>\n";}
			}	
	echo "</select> ";
	}
	function inp_tahun2($year){
		echo "<select name=\"".$year."\" id=\"".$year."\" class='form-control' style='font-size:12px !important'
onchange='showRekapForecast();'>\n";
		for ($t=date("Y")-5;$t<=date("Y")+10;$t++){
			if($t==date("Y")){
				echo "<option value=$t selected='selected'>$t</option>\n";
			}
			else{echo "<option value=$t>$t</option>\n";}
		}
		echo "		</select>\n";
	}
	function inp_bulan2($month){
		echo "<select name=\"".$month."\" id=\"".$month."\" class='form-control' style='font-size:12px !important' onchange='showRekapForecast();'>";
		for($t=1;$t<=12;$t++){
			if($t==date("n")){
				echo "<option value=$t selected='selected'>".$this->monthName($t)."</option>\n";
			}
			else{echo "<option value=$t>".$this->monthName($t)."</option>\n";}
		}
		echo "</select> ";
	}
	
// input periode
function inp_per($month,$year){
	echo "Bln <select name=\"".$month."\" id=\"".$month."\" class='roundIt'>";
			for($t=1;$t<=12;$t++){
				if($t==date("n")){
				echo "<option value=$t selected='selected'>".$this->monthName($t)."</option>\n";
				}
				else{echo "<option value=$t>".$this->monthName($t)."</option>\n";}
			}	
	echo "</select> ";

	echo "Thn <select name=\"".$year."\" id=\"".$year."\" class='roundIt'>\n";
	for ($t=date("Y")-5;$t<=date("Y")+10;$t++){
		if($t==date("Y")){
			echo "<option value=$t selected='selected'>$t</option>\n";
			}
		else{echo "<option value=$t>$t</option>\n";}
	}
	echo "		</select>\n";
}	
public function cekSession($page){	
	if($page->Session->check('dpfdpl_userId')==false && $page->Session->check('dpfdpl_namaUser')==false)
	{		
	header('location:nologin');exit();
	}
	}
public function rKanan($text, $lebar) 
{
$spasi = "";
$jmlSpasi=0;
$panjangDicetak=0;
$panjangDicetak = strlen($text);
if( $panjangDicetak < $lebar){
    $jmlSpasi = $lebar - $panjangDicetak;
}
for($x=1;$x<$jmlSpasi;$x++){
	$spasi=$spasi."&nbsp;";
	}
return $spasi.$text;
}
public function rKiri($text, $lebar) 
{
$spasi = "";
$jmlSpasi=0;
$panjangDicetak=0;
$panjangDicetak = strlen($text);
if( $panjangDicetak < $lebar){
    $jmlSpasi = $lebar - $panjangDicetak;
}
for($x=1;$x<$jmlSpasi;$x++){
	$spasi=$spasi."&nbsp;";
	}
return $text.$spasi;
}
public function rTengah($text, $lebar) 
{
$spasi = "";
$panjangDicetak=0;
$panjangDicetak = strlen($text);
if( $panjangDicetak < $lebar){
    $jmlSpasi = $lebar - $panjangDicetak;
}
for($x=1;$x<$jmlSpasi/2;$x++){
	$spasi=$spasi." ";
	}
return $spasi.$text.$spasi;
}

// ambil nama bulan berdasarkan angka bulan
public function monthName($nomorbulan){
	$nama_bulan = array(1=>"Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agt", "Sep", "Okt", "Nov", "Des");
	$hasilbulan=$nama_bulan[$nomorbulan];
	return $hasilbulan;
}
public function monthRome($nomorbulan){
	$rome_bulan = array(1=>"I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
	$hasilbulan=$rome_bulan[$nomorbulan];
	return $hasilbulan;
}
public function monthAlpha($nomorbulan){
	$rome_bulan = array(1=>"A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L");
	$hasilbulan=$rome_bulan[$nomorbulan];
	return $hasilbulan;
}
// ambil tanggal akhir tiap bulan berdasarkan angka bulan
public function lastDate($i,$j){
	if( $i==1 || $i==3 || $i==5  || $i==7 || $i==8 || $i==10 || $i==12 ){ $k=31; }
	elseif( $i==4 || $i==6  || $i==9 || $i==11 ){ $k=30; }
	elseif( $i==2 ) {
		if   ( $j%4==0){ $k=29 ; }
		else { $k=28; }
	}
	return $k;
}

// for generate html
public function copyFolder( $source, $target ) {
	if ( is_dir( $source ) ) {
		@mkdir( $target );
		$d = dir( $source );
		while ( FALSE !== ( $entry = $d->read() ) ) {
			if ( $entry == '.' || $entry == '..' ) {
				continue;
			}
			$Entry = $source . '/' . $entry; 
			if ( is_dir( $Entry ) ) {
				full_copy( $Entry, $target . '/' . $entry );
				continue;
			}
			copy( $Entry, $target . '/' . $entry );
		}
 
		$d->close();
	}else {
		copy( $source, $target );
	}
}

public function deleteFolder($namaFolder) {
	if (is_dir($namaFolder)){
		$handleFolder = opendir($namaFolder);
	}
	if (!$handleFolder){
		return false;
	}
	while($file = readdir($handleFolder)) {
		if ($file != "." && $file != "..") {
			if (!is_dir($namaFolder."/".$file))
			unlink($namaFolder."/".$file);
			else
			deleteFolder($namaFolder.'/'.$file);
		}
	}
	closedir($handleFolder);
	rmdir($namaFolder);
	return true;
}





public function num($name){
	echo number_format($name,0,',','.');
}


// value lap
public function val($val){
	if ($val!=""){ echo $val; }
	else{ echo "---";	}
}

// vs lap
public function vsx($vsxa,$vsxb){
	if ($vsxa==$vsxb){ $vs="Y"; } else{	$vs="N"; }
	return $vs;
}

// format tanggal indonesia
public function dateindo($date){
	$newdate=substr($date,8,2)."-".substr($date,5,2)."-".substr($date,0,4);
	return $newdate;
}
public function dateindo2($date){
	$date=explode(' ',$date);
	$newdate=substr($date[0],8,2)."-".substr($date[0],5,2)."-".substr($date[0],0,4);
	if(isset($date[1])){
	return $newdate.' '.$date[1];}
	else{
	return $newdate;	
		}
}
public function dateluar($date){
	$newdate=substr($date,6,4)."-".substr($date,3,2)."-".substr($date,0,2);
	return $newdate;
}
public function dateluar2($date){
	$date=explode(' ',$date);
	$newdate=substr($date[0],6,4)."-".substr($date[0],3,2)."-".substr($date[0],0,2);
	if(isset($date[1])){
	return $newdate.' '.$date[1];}
	else{
	return $newdate;	
		}
}
//date dalam DD-MM-YYYY
public function dateToDouble($date){
	$tanggal=substr($date,0,2);
	$bulan=substr($date,3,2);
	$tahun=substr($date,6,4);
	$dateDouble=mktime(1,00,00,$bulan,$tanggal,$tahun);
	return number_format($dateDouble * 1000,0,"","");
	}
public function doubleToDate($dateDouble){
	//hasil dalam DD-MM-YYYY
	return $date=date("d-m-Y", $dateDouble/1000);
	}

public function monthNameShort($nomorbulan){
	$nama_bulan_short = array(1=>"Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des");
	$hasilbulan=$nama_bulan_short[$nomorbulan];
	return $hasilbulan;
}

public function num_bulat($name){
	echo number_format($name,2,',','.');
}
public function nf($s){
	$hnf=number_format($s,0,".",",");
	if ($s==0 || $s=="") return "-";
	else return $hnf;
}


public function monthCode($nomorbulan){
$nama_bulan = array(1=>"A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L");
$hasilbulan=$nama_bulan[$nomorbulan];
return $hasilbulan;
}
public function num_dua($name){
$num_dua=number_format($name,2,',','.');
return $num_dua;
}

public function cekJScript(){
	echo"<noscript><meta http-equiv='REFRESH' content='0;url=noscript'></noscript>";
	}

public function msgBox($pesan){
	echo "<script>alert('".$pesan."');</script>";
	}
public function jscript($script){
	echo "<script>".$script."</script>";
	}
public function pageNav($curHal,$maxHal,$jmlTampil){
	
$halTengah=round($jmlTampil/2);	
if($maxHal>1){
if($curHal > 1)
		{
		$previous=$curHal-1;
		$linkHal=$linkHal."<a class='nextprev' onclick='getData(1)'> First</a> &nbsp";
		$linkHal=$linkHal." <a class='nextprev' onclick='getData($previous)'> Prev</a> &nbsp";
		}
		elseif(empty($curHal)||$curHal==1)
		{
			$linkHal=$linkHal."<a class='nextprev'>First</a><a class='nextprev'> Prev </a> ";
		}
		
		for($i=$curHal-($halTengah-1);$i<$curHal;$i++)
		{
		  if ($i < 1)
			  continue;
		  $angka .= "<a class='num' onclick='getData($i)'>$i</a> ";
		}
		
		$angka .= "<span class='current'><b >$curHal</b> </span>";
		for($i=$curHal+1;$i<($curHal +$halTengah);$i++)
		{
		  if ($i > $maxHal)
			  break;
		  $angka .= "<a class='num' onclick='getData($i)'>$i</a> ";
		}
		
		$linkHal=$linkHal.$angka;

		if($curHal < $maxHal)
		{
		$next=$curHal+1;
	     $linkHal=$linkHal." <a class='nextprev'onclick='getData($next)'>Next </a>&nbsp;&nbsp;<a class='nextprev' onclick='getData($maxHal)'>Last</a> ";
		}
		else
		{
			$linkHal=$linkHal." <a class='nextprev'>Next</a><a class='nextprev'>Last</a> ";
		}	
	}
		return $linkHal;
	}

 	public function addTrailingBlank($value,$length){
     	$blankAdded = $length - strlen($value);
     	
       for ($i=0;$i<$blankAdded;$i++){
     		$value=$value."_";
     	}
     	return $value;
     }
     public function addHeadingBlank($value,$length){
     	$blankAdded = $length - strlen($value);
     	
     	for ($i=0;$i<$blankAdded;$i++){
     		$value="_".$value;
     	}
     	return $value;
     }
 public function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
public function selisihHari($date1,$date2){
//date2 harus yg lebih besar	
	$datetime1=explode("-",$date1);
	$datetime2=explode("-",$date2);
	return GregorianToJD($datetime2[1], $datetime2[2], $datetime2[0])-GregorianToJD($datetime1[1], $datetime1[2], $datetime1[0]);
	}

	public function num2alpha($number){
		$alphabet = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
		$hasilAlphabet=$alphabet[$number];
		return $hasilAlphabet;
	}

	public function inp_prod($value){
		App::import('Model','User');
		
		$user = new User();
		echo ' <span class="single-select" id="txtDivisi"></span>';
	
		$kueri=$user->query("SELECT DISTINCT divid,divisi FROM prod_divisis");
		$dataKueri=[];
			foreach($kueri as $hsl){	
				$dataKueri[]= array('label'=>$hsl["prod_divisis"]["divisi"],'value'=>$hsl["prod_divisis"]["divid"]);
			}		
		$hasil=	json_encode($dataKueri);
		?>
		
		<script type="text/JavaScript">
			var single = new SelectPure("#txtDivisi", {
			options:<?= $hasil; ?> ,
				  placeholder: "-Please select-",
				  onChange: value => {SetProduk(value); }
				});
		</script>
		<?php
			}
	public function inp_dist($value){
		App::import('Model','User');
		$user = new User();
		echo ' <span class="single-select" id="txtDistributor"></span>';
		$kueri=$user->query("SELECT id,nama FROM distributors ORDER BY nama");
		$dataKueri=[];
			foreach($kueri as $hsl){	
				$dataKueri[]= array('label'=>$hsl["distributors"]["nama"],'value'=>$hsl["distributors"]["id"]);
			}		
			$hasil=	json_encode($dataKueri);
			?>
			<script type="text/JavaScript">
			var single = new SelectPure("#txtDistributor", {
			options:<?= $hasil; ?> ,
				  placeholder: "-Please select-",
				  onChange: value => {SetCabang(value); }
				});
			</script>
	
		<?php
			}
	}

?>
