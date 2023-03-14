<?php
App::uses('Component', 'Controller');
class FunctionComponent extends Component{
	public function rKanan($text, $lebar)
	{
		$spasi = "";
		$panjangDicetak=0;
		$jmlSpasi=0;
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
	public function rKananCSV($text, $lebar)
	{
		$spasi = "";
		$panjangDicetak=0;
		$jmlSpasi=0;
		$panjangDicetak = strlen($text);
		if( $panjangDicetak < $lebar){
			$jmlSpasi = $lebar - $panjangDicetak;
		}
		if($panjangDicetak>$lebar){
			$text=substr($text,0,$lebar);
			$jmlSpasi=0;
		}
		for($x=0;$x<$jmlSpasi;$x++){
			$spasi=$spasi." ";
		}
		return $spasi.$text;
	}
	
	public function rKiriCSV($text, $lebar)
	{
		$spasi = "";
		$jmlSpasi=0;
		$panjangDicetak=0;
		$panjangDicetak = strlen($text);
		//echo $panjangDicetak."***";
		if( $panjangDicetak < $lebar){
			$jmlSpasi = $lebar - $panjangDicetak;
		}
		if($panjangDicetak>$lebar){
			$text=substr($text,0,$lebar);
			$jmlSpasi=0;
		}
		for($x=0;$x<$jmlSpasi;$x++){
			$spasi=$spasi." ";
		}
		//echo $text.$spasi."|".strlen($text.$spasi)."|".$jmlSpasi."^";
		return $text.$spasi;
	}
	
	public function rTengah($text, $lebar)
	{
		$spasi = "";
		$panjangDicetak=0;
		$jmlSpasi=0;
		$panjangDicetak = strlen($text);
		if( $panjangDicetak < $lebar){
			$jmlSpasi = $lebar - $panjangDicetak;
		}
		for($x=1;$x<$jmlSpasi/2;$x++){
			$spasi=$spasi." ";
		}
		return $spasi.$text.$spasi;
	}
	public function replacemeta($strInp){
		$str=preg_replace('/[^a-zA-Z0-9.-]/','',$strInp);
		return $str;
	}
	public function replacequote($strInp){
		//$str=str_replace("'","''",$strInp);
		$str=addslashes($strInp);
		
		return $str;
	}
	// ambil nama bulan berdasarkan angka bulan
	public function monthName($nomorbulan){
		$nama_bulan = array(1=>"Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agt", "Sep", "Okt", "Nov", "Des");
		$hasilbulan=$nama_bulan[$nomorbulan];
		return $hasilbulan;
	}
	public function monthAngka($nomorbulan){
		$nama_bulan = array("Jan"=>1, "Feb"=>2, "Mar"=>3, "Apr"=>4, "Mei"=>5, "Jun"=>6, "Jul"=>7, "Agt"=>8, "Sep"=>9, "Okt"=>10, "Nov"=>11, "Des"=>12);
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
	public function maxId($tabel,$field,$dbCon){
		$res=$dbCon->getRow($dbCon->execute("select max($field) from $tabel"));
		if (strlen($res[0])==0){ $maxId=1; }
		else{ $maxId=($res[0])+1; }
		return $maxId;
	}
	public function maxIdGenerator($tabel,$field,$pref,$dbCon){
		$kueri=$dbCon->execute("select lastId as maxId from lkh_idGenerator where beanName='".$tabel.$pref."'");
		$res=$dbCon->getRow($kueri);
		$jml=$dbCon->getNumRows($kueri);
		if($jml==0){
			$dbCon->execute("insert into lkh_idGenerator values('".$tabel.$pref."','1')");
			$maxId=$pref."1";
		}
		else{
			$maxId=($res[0])+1;
			
			$dbCon->execute("update lkh_idGenerator set lastId='$maxId' where beanName='".$tabel.$pref."'");
			$maxId=$pref.$maxId;
		}
		
		return $maxId;
	}
	
	public function maxNoTransGenerator($tabel,$field,$pref,$kodeArco,$thn,$bln,$dbCon){
		/* $kueri=$dbCon->execute("select lastId as maxId from lkh_notaGenerator where tableName='$tabel' and
		 prefix='".$pref."' and kodeArco='$kodeArco'
		 and tahun='$thn' and bulan='$bln'");*/
		$prefId=$pref.$kodeArco.$thn.$bln;
		$kueri=$dbCon->execute("select max($field) from $tabel where substring($field,1,".strlen($prefId).")='$prefId'");
		$res=$dbCon->getRow($kueri);
		$jml=$dbCon->getNumRows($kueri);
		if($jml==0){
			//$dbCon->execute("insert into lkh_notaGenerator values('$tabel','".$pref."','$kodeArco','$thn','$bln','1')");
			$maxId=$prefId."00001";
		}
		else{
			$maxId=$res[0];
			//	$dbCon->execute("update lkh_notaGenerator set lastId=lastId+1 where tableName='$tabel' and prefix='".$pref."'
			//				and kodeArco='$kodeArco' and tahun='$thn' and bulan='$bln'");
			$maxId=substr($maxId,strlen($prefId)+1,strlen($maxId));
			$maxId=$maxId+100001;
			$maxId=substr($maxId,1,5);
			$maxId=$prefId.$maxId;
		}
		
		return $maxId;
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
		$hnf=number_format(round($s,2),0,".",",");
		if ($s==0 || $s=="") return "0";
		else return $hnf;
	}
	public function nf2($s){
		$hnf=number_format(round($s,2),0,",",".");
		if ($s==0 || $s=="") return "0";
		else return $hnf;
	}
	
	public function monthCode($nomorbulan){
		$nama_bulan = array(1=>"A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L");
		$alphabet = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
		$hasilbulan=$nama_bulan[$nomorbulan];
		return $hasilbulan;
	}
	public function num_dua($name){
		$num_dua=number_format($name,2,',','.');
		return $num_dua;
	}
	
	public function num2alpha($number){
		$alphabet = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
		$hasilAlphabet=$alphabet[$number];
		return $hasilAlphabet;
	}
	public function cekJScript(){
		echo"<noscript><meta http-equiv='REFRESH' content='0;url=noscript'></noscript>";
	}
	public function cekSession($page){
		//var_dump($page->Session->check('dpfdpl_namaUser'));exit();
		if($page->Session->check('dpfdpl_userId')==false && $page->Session->check('dpfdpl_namaUser')==false)
		{
			header('location:nologin');exit();
		}
	}
	
	public function msgBox($pesan){
		echo "<script>alert('".$pesan."');</script>";
	}
	public function jscript($script){
		echo "<script>".$script."</script>";
	}
	public function pageNav($curHal,$maxHal,$jmlTampil){
		$linkHal='';
		$angka='';
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

	public function pageNavMulti($curHal,$maxHal,$jmlTampil,$fungsi){
        $linkHal='';
        $angka='';
        $halTengah=round($jmlTampil/2);
        if($maxHal>1){
            if($curHal > 1){
                $previous=$curHal-1;
                $linkHal=$linkHal."<a class='nextprev' onclick='".$fungsi."(1)'> First</a> &nbsp";
                $linkHal=$linkHal." <a class='nextprev' onclick='".$fungsi."($previous)'> Prev</a> &nbsp";
            }elseif(empty($curHal)||$curHal==1){
                $linkHal=$linkHal."<a class='nextprev'>First</a><a class='nextprev'> Prev </a> ";
            }
            
            for($i=$curHal-($halTengah-1);$i<$curHal;$i++) {
                if ($i < 1)
                continue;
                $angka .= "<a class='num' onclick='".$fungsi."($i)'>$i</a> ";
            }
            
            $angka .= "<span class='current'><b >$curHal</b> </span>";
            for($i=$curHal+1;$i<($curHal +$halTengah);$i++) {
                if ($i > $maxHal)
                break;
                $angka .= "<a class='num' onclick='".$fungsi."($i)'>$i</a> ";
            }
            
            $linkHal=$linkHal.$angka;
            
            if($curHal < $maxHal){
                $next=$curHal+1;
                $linkHal=$linkHal." <a class='nextprev'onclick='".$fungsi."($next)'>Next </a>&nbsp;&nbsp;<a class='nextprev' onclick='".$fungsi."($maxHal)'>Last</a> ";
            } else {
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
	public function getColumnValue($row,$kolomIndex){
		$srow=$row."|";
		$nilai="";
		for ($i=0;$i<$kolomIndex;$i++){
			$nilai = substr($srow,0,strpos($srow,"|"));
			$srow=substr($srow,strpos($srow,"|") + 1,strlen($srow));
		};
		return $nilai;
	}
	function statusDana(){
		$statusDana=array("Diajukan","Ditolak","DisetujuiAsmen","DisetujuiCoordAsmen","DisetujuiAsdir",
				"BolehDikirim","TelahDitransfer");
		return $statusDana;
	}
	function getNextStatusDana($verificatorGroup,$dbCon){
		$nextStatus="";
		$rsStatus=$dbCon->execute("select * from lkh_nextstatusdana where verificatorGroup='$verificatorGroup' and
				jenisStatus='setuju'");
		while($dataStatus=$dbCon->getArray($rsStatus)){
			$nextStatus=$nextStatus.$dataStatus[nextStatus]."|";
		}
		return $nextStatus;
	}
	function getStatusDanaTolakan($verificatorGroup,$statusDana,$dbCon){
		$nextStatus="";
		$rsStatus=$dbCon->execute("select * from lkh_nextstatusdana where verificatorGroup='$verificatorGroup' and
				jenisStatus='tolakan' and statusDana='$statusDana'");
		while($dataStatus=$dbCon->getArray($rsStatus)){
			$nextStatus=$nextStatus.$dataStatus[nextStatus]."|";
		}
		return $nextStatus;
	}
	function getIsBolehDikirim($kategoriDana,$statusDana,$nilaiPengajuan,$dbCon){
		$return=false;
		$rsBolehDikirim=$dbCon->execute("select * from lkh_statusBolehDikirim where kategori='$kategoriDana' and statusDana='$statusDana'");
		$jml=$dbCon->getNumRows($rsBolehDikirim);
		if($jml>0){
			
			while($dataBolehDikirim=$dbCon->getArray($rsBolehDikirim)){
				$limitBawah=$dataBolehDikirim[limitBawah];
				$limitAtas=$dataBolehDikirim[limitAtas];
				if($limitBawah==0 && $limitAtas==0){
					$return=true;
					break;
				}
				elseif($limitBawah==0 && $limitAtas !=0){
					if ($nilaiPengajuan <= $limitAtas) {
						$return=true;
						break;
					}
				}
				elseif($limitBawah!=0 && $limitAtas !=0){
					if ($nilaiPengajuan >= $limitBawah && $nilaiPengajuan <= $limitAtas) {
						$return= true;
						break;
					}
				}
				elseif($limitBawah!=0 && $limitAtas ==0){
					if ($nilaiPengajuan >= $limitBawah ) {
						$return=true;
						break;
					}
				}
				
			}
		}
		return $return;
	}
	public function selisihHari($date1,$date2){
		//date2 harus yg lebih besar
		$datetime1=explode("-",$date1);
		$datetime2=explode("-",$date2);
		return GregorianToJD($datetime2[1], $datetime2[2], $datetime2[0])-GregorianToJD($datetime1[1], $datetime1[2], $datetime1[0]);
	}
	
	public function isPeriodeDPLExist($periode,$tahun){
		$isExist='false';
		$model = ClassRegistry::init('Lockdpl');
		$rs=$model->cekData($periode,$tahun);
		if(count($rs)>0){
			$isExist='true';
		}
		return $isExist;
	}
	public function isPeriodeDPFExist($periode,$tahun){
		$isExist='false';
		$model = ClassRegistry::init('Lockdpf');
		$rs=$model->cekData($periode,$tahun);
		if(count($rs)>0){
			$isExist='true';
		}
		return $isExist;
	}
	public function isFileIsRight($kolomK3,$curController){
		$rightFile='true';
		$tempFile="UNKNOWN";
		$namaController="";
		switch ($kolomK3) {
			case "a":
				$tempFile='DPF BERNO ETH';
				$namaController='Bacadatadpfbrneths';
				break;
			case "b":
				$tempFile='DPL BERNO ETH';
				$namaController='Bacadatadplbrneths';
				break;
			case "c":
				$tempFile='DPF BERNO GEN';
				$namaController='Bacadatadpfbrngens';
				break;
			case "d":
				$tempFile='DPL BERNO GEN';
				$namaController='Bacadatadplbrngens';
				break;
			case "e":
				$tempFile='DPF QUANTUM ETH';
				$namaController='Bacadatadpfqtmeths';
				break;
			case "f":
				$tempFile='DPL QUANTUM ETH';
				$namaController='Bacadatadplqtmeths';
				break;
			case "g":
				$tempFile='DPF QUANTUM GEN';
				$namaController='Bacadatadpfqtmgens';
				break;
			case "h":
				$tempFile='DPL QUANTUM GEN';
				$namaController='Bacadatadplqtmgens';
				break;
		}
		
		if(trim(strtoupper($curController))<>trim(strtoupper($namaController))){
			$rightFile='false';
		}
		return $rightFile."!".$tempFile."!".$curController;
	}
	public function cekTemplateAktif(){
		$model = ClassRegistry::init('Templateaktif');
		$templateAktif="";
		$rsTemplate=$model->find('all');
		$jml=count($rsTemplate);
		if($jml>0){
			foreach($rsTemplate as $hsl){
				$templateAktif=$hsl['Templateaktif']['templateAktif'];
			}}
			return $templateAktif;
	}
	public function fotoUpload($imageName,$imageSize=10000000,$uploadType,$dest='foto'){
		
		
		
		if($uploadType=='attachment'){
			$imageType=array("application/x-rar","application/download","application/vnd.openxmlformats-officedocument.spreadsheetml.sheet","application/x-msexcel","application/vnd.ms-excel","application/vnd.openxmlformats-officedocument.wordprocessingml.document","application/msword","application/vnd.ms-powerpoint","\"application/pdf\"","application/pdf","text/plain");
		}
		else{
			$imageType=array("image/gif","image/jpg","image/jpeg","image/png");
		}
		$this->doUpload($imageName,$imageSize,$imageType,$dest);
	}
	
	function getError($errorCode){
		switch($errorCode)
		{
			case '1':
				$error = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
				break;
			case '2':
				$error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
				break;
			case '3':
				$error = 'The uploaded file was only partially uploaded';
				break;
			case '4':
				$error = 'No file was uploaded.';
				break;
				
			case '6':
				$error = 'Missing a temporary folder';
				break;
			case '7':
				$error = 'Failed to write file to disk';
				break;
			case '8':
				$error = 'File upload stopped by extension';
				break;
			case '999':
			default:
				$error = 'No error code avaiable';
		}
		return $error;
	}
	
	function doUpload($imageName,$imageSize,$imageType,$dest){
		$n=0;
		foreach ($_FILES[$imageName]["name"] as $file) {
			
			if ((in_array($_FILES[$imageName]["type"][$n],$imageType)) && ($_FILES[$imageName]["size"][$n] < $imageSize))
			{
				if ($_FILES[$imageName]["error"][$n] > 0)
				{
					echo getError($_FILES[$imageName]['error'][$n]);
					exit();
				}
				else
				{
					
					if(move_uploaded_file($_FILES[$imageName]["tmp_name"][$n],
							$this->webroot.$dest.'/'.$_FILES[$imageName]["name"][$n])){}
							else{echo "Proses upload gagal..";
							exit();}
				}
			}
			else
			{
				echo "Tipe file tidak didukung - ".$_FILES[$imageName]['type'][$n]."size:".$_FILES[$imageName]["size"][$n];
				exit();
			}
			
			$n=$n+1;
		}
		
		
	}

function uncamelize($camel,$splitter="_") {
    $camel=preg_replace('/(?!^)[[:upper:]][[:lower:]]/', '$0', preg_replace('/(?!^)[[:upper:]]+/', $splitter.'$0', $camel));
    return ucwords(strtolower($camel));

}
}



?>
