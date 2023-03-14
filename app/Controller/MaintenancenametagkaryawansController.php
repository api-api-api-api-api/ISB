<?php
App::uses('AppController', 'Controller');
class MaintenancenametagkaryawansController extends AppController {
	public $components = array('Function','Paginator');
	function index(){
		//var_dump($_POST);exit();
		echo $this->Function->cekSession($this);
	}
	function getData(){
		$this->autoRender = false;
		$this->loadModel('User');
		$idUser=$this->Session->read('dpfdpl_userId');
		$userNama=$this->Session->read('dpfdpl_namaUser');
		//Variable tampung;
		$txtData="";
		//Variable Filter;
		$filterTahun=$_POST['filterTahun'];
		$filterNama=$_POST['filterNama'];
		$filterLimit=$_POST['filterLimit'];
		//var_dump($filterLimit);exit();
		//Variable Halaman paging
		

		$hm=$_POST['hal'];
		$fungsi="getData";
		// /$limit=10;
		
		$this->User->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'");


		$query="SELECT * FROM anumet.karyawans k 
		INNER JOIN anumet.anumets an ON an.nik=k.nik
		LEFT JOIN anumet.departemens de ON k.departemenId=de.id
		LEFT JOIN anumet.divisis di ON k.divisiId=di.id
		LEFT JOIN anumet.jabatans j ON k.jabatanId=j.id
		LEFT JOIN anumet.areas ar ON k.areaId=ar.id ORDER BY k.namaKaryawan";

		//var_dump($query);exit();
		//WHERE a.tahun='$filterTahun'";
		$qsql=$this->User->query($query);

		$jumQuery=count($qsql);


		
		if($filterLimit==''){$limit=10;}elseif($filterLimit=='ALL'){$limit=$jumQuery;}else{$limit=$filterLimit;}

		if(empty($hm)||$hm==1){$start=0;}else{$start=($hm-1)*$limit;}
		$sum=ceil($jumQuery/$limit);
//var_dump($query." limit $start, $limit");exit();
		/* -----------------------------Navigasi Record ala google style ----------------------------- */
		$linkHal=$this->pageNavMulti($hm,$sum,$limit,$fungsi);
		/* -----------------------------End Navigasi Record ala google style ----------------------------- */
		$Qtampil=$this->User->query($query." limit $start, $limit");


		$no=$start+1;
		if($jumQuery==0 || $jumQuery==Null){
			$txtData="<tr>
			<td colspan=\"9\" style=\"text-align:center;\">--Empty Data--</td>
			</tr>";
			return $txtData."^";
		}
		
		foreach($Qtampil as $dataRow){
			//var_dump($dataRow);exit();
			$id=$dataRow['k']['id'];
			$nik=$dataRow['k']['nik'];
			$nama=$dataRow['k']['namaKaryawan'];
			$departemen=$dataRow['de']['namaDepartemen'];
			$divisi=$dataRow['di']['namaDivisi'];
			$jabatan=$dataRow['j']['namaJabatan'];
			$area=$dataRow['ar']['namaArea'];

			$txtData.="<tr><td>$no</td>
			<td><input type=\"checkbox\" name=\"pilih\" class=\"pilih\" id=\"pilih".$id."\" value=\"".$id."~".$nik."~".$nama."~".$jabatan."~".$divisi."\"></td>
			<td>$nik</td>
			<td>$nama</td>
			<td>$departemen</td>
			<td>$divisi</td>
			<td>$jabatan</td>
			<td>$area</td>			
			</tr>";
			$no++;
		}

		return $txtData."^".$linkHal;
	}

	function qrcode(){
		$this->autoRender = false;
        $this->loadModel('User');       
        //var_dump($_POST);exit();

        $pilihHidden=$_POST['pilihHidden'];
        $idPilihHidden=$_POST['idpilihHidden'];

       	$this->set('isi',$pilihHidden);
       	$this->set('isiId',$idPilihHidden);

       	$this->render('qrcode');		
	}

	public function pageNavMulti($curHal,$maxHal,$jmlTampil,$fungsi){
		$linkHal='';
		$angka='';
		$halTengah=round($jmlTampil/2);
		if($maxHal>1){
			if($curHal > 1){
				$previous=$curHal-1;
				$linkHal=$linkHal."<ul class='pagination justify-content-center'><li class='page-item'><a class='page-link' onclick='".$fungsi."(1)'> First</a></li>";
				$linkHal=$linkHal."<li class='page-item'><a class='page-link' onclick='".$fungsi."($previous)'>Prev</a></li>";
			}elseif(empty($curHal)||$curHal==1){
				$linkHal=$linkHal."<ul class='pagination'><li class='page-item'><a class='page-link'>First</a></li><li class='page-item'><a class='page-link'>Prev</a></li> ";
			}
			for($i=$curHal-($halTengah-1);$i<$curHal;$i++) {
				if ($i < 1)
					continue;
				$angka .= "<li class='page-item'><a class='page-link' onclick='".$fungsi."($i)'>$i</a></li>";
			}
			$angka .= "<li class='page-item active'><span class='page-link'><b >$curHal</b> <span class='sr-only'>(current)</span></span></li>";
			for($i=$curHal+1;$i<($curHal +$halTengah);$i++) {
				if ($i > $maxHal)
					break;
				$angka .= "<li class='page-item'><a class='page-link' onclick='".$fungsi."($i)'>$i</a></li> ";
			}
			$linkHal=$linkHal.$angka;
			if($curHal < $maxHal){
				$next=$curHal+1;
				$linkHal=$linkHal."<li class='page-item'><a class='page-link'onclick='".$fungsi."($next)'>Next </a></li><li class='page-item'>
				<a class='page-link' onclick='".$fungsi."($maxHal)'>Last</a></li> </ul>";
			}else {
				$linkHal=$linkHal." <li class='page-item'><a class='page-link'>Next</a></li><li class='page-item'><a class='page-link'>Last</a></li></ul>";
			}
		}
		return $linkHal;
	}
}