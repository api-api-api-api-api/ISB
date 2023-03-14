<?php
App::uses('AppController', 'Controller');
/**
 * Inputmasterbarang Controller
 *
 */
class MasterformsController extends AppController {
public $components = array('Function','Paginator');
	function index(){
		echo $this->Function->cekSession($this);
	}
    public function getData(){
		$this->autoRender = false;
		//$selectFilter=$_POST['selectFilter'];
		$selectGroup=$_POST['selectGroup'];
		//$txtItemBarang=$_POST['txtItemBarang'];
		$hm=$_POST['hal'];
		$txtData='';
		$limit=10;
		$this->loadModel('Masterbarang');
		$this->loadModel('User');
		if(empty($hm)||$hm==1){
		$start=0; 
		}else{ 
			$start=($hm-1)*$limit; 
		}
		
		//filter
		// if($selectFilter=='item'){
		// 	$cari="mbr.namaBarang like '%$txtItemBarang%'";
		// }else if($selectFilter=='kategori'){
		// 	$cari="ktgr.nama like '%$txtItemBarang%'";
		// }else{
		// 	$cari="jnsBr.nama like '%$txtItemBarang%'";
		// }
		$namaBarang=$_POST['txtNmBrg'];
		$ktgrnama=$_POST['txtKategoriBrg'];
		$jnsBrnama=$_POST['txtJenisBrg'];
		//$cItems="SELECT * FROM  definance.masterbarangs mbr WHERE mbr.`namaBarang` like '%$txtItemBarang%' ORDER BY id";
		$cItems="SELECT mbr.id,mbr.namaBarang,mbr.`group`, jnsBr.id AS idJnsBr,jnsBr.nama AS nmJnsBr,ktgr.id AS ktgrId,ktgr.nama AS ktgrNama, 
			mbr.`group` ,mbr.idAsal ,mbr.editableVal,mbr.isAktif ,mbr.isUsed,mbr.postId,post.namaPost 
			FROM  definance.masterbarangs mbr 
			LEFT JOIN definance.jenisbarangs jnsBr ON jnsBr.id = mbr.jenisId 
			LEFT JOIN definance.kategoribarangs ktgr ON ktgr.id = mbr.kategoriId 
			LEFT JOIN definance.postids post ON post.postId = mbr.postId 
			WHERE mbr.namaBarang like '%$namaBarang%' AND ktgr.nama like '%$ktgrnama%' AND jnsBr.nama like '%$jnsBrnama%' 
			AND mbr.group='".$selectGroup."'  ORDER BY mbr.id";
		//echo $cItems;exit();
		//model master barang
		$resitems=$this->Masterbarang->query($cItems);
		//$resitems=$this->User->query($cItems);
		$jumItems=count($resitems);

	
		$sum=ceil($jumItems/$limit);
		
		/* -----------------------------Navigasi Record ala google style ----------------------------- */
		$linkHal=$this->pageNavMulti($hm,$sum,$limit,'getData');
		/* -----------------------------End Navigasi Record ala google style ----------------------------- */
		$rsTampil=$this->Masterbarang->query($cItems." limit $start, $limit");

		$n=$start+1;

		if($jumItems==0 || $jumItems==Null){
			
			$txtData.="
			<tr>
				<td colspan=11 style=\"text-align:center;\">Kosong</td>
			</tr>";

		}else{
			
			foreach($rsTampil as $dataItem){
				$itemId=$dataItem['mbr']['id'];
				$nama=$dataItem['mbr']['namaBarang'];
				$kategori=$dataItem['ktgr']['ktgrNama'];
				$jenis=$dataItem['jnsBr']['nmJnsBr'];
				$groupId=$dataItem['mbr']['group'];
				$idAsal=$dataItem['mbr']['idAsal'];
				$editableval=$dataItem['mbr']['editableVal'];
				$isaktif=$dataItem['mbr']['isAktif'];
				$isused=$dataItem['mbr']['isUsed'];
				$postid=$dataItem['mbr']['postId'];
				
				if($postid==0||$postid==Null){
					$postid='Null';
					$namapost='postid belum ditentukan';
				}else{
					$namapost=$dataItem['post']['namaPost'];
					$postid=$dataItem['mbr']['postId'];
				}
				
				// var_dump($rpostid['pid']['namaPost']);
				// exit();
				$txtData.="<tr>
					<td id='id".$n."' align=\"center\" style=\"border-right:1px solid #ccc &#33;important;\" >".$n."</td>
					<td id='id".$itemId."' align=\"center\" style=\"display:none;\">".$itemId."<input type='hidden' name='itemId' id='itemid".$itemId."' value='$itemId'></td>
					<td id='txtNama".$itemId."' align=\"left\" style=\"border-right:1px solid #ccc &#33;important;\"><a href='javascript:void(0)' onClick='updateToData(\"".$itemId."\")'>$nama</a> </td>
					<td id='txtkategori".$itemId."' align=\"left\" style=\"border-right:1px solid #ccc &#33;important;\">$kategori</td>
					<td id='txtJenis".$itemId."' align=\"left\" style=\"border-right:1px solid #ccc &#33;important;\">$jenis</td>
					<td id='txtGroup".$itemId."' align=\"center\" style=\"border-right:1px solid #ccc &#33;important;\">$groupId</td>
					<td id='txtidAsal".$itemId."' align=\"left\" style=\"display:none;\">$idAsal</td>
					<td id='txtEditableVal".$itemId."' align=\"left\" style=\"display:none;\">$editableval</td>
					<td id='txtIsAktif".$itemId."' align=\"left\" style=\"display:none;\"><label class='lbl".$itemId."'>$isaktif</label></td>
					<td id='txtIsUsed".$itemId."' align=\"left\" style=\"display:none;\"><label class='lbl".$itemId."'>$isused</label></td>
					<td id='txtpostId".$itemId."' align=\"left\" style='display:none;'>$postid</td>
					<td id='txtNmpostId".$itemId."' align=\"center\" style=\"border-right:1px solid #ccc &#33;important; display:none;\">$namapost</td>
					</tr>";
					$n++;
			}
		}
		echo $txtData."!".$linkHal;
	}

	public function pageNavMulti($curHal,$maxHal,$jmlTampil,$fungsi){
		$linkHal='';
		$angka='';
		$halTengah=round($jmlTampil/2);
		if($maxHal>1){
			if($curHal > 1){
				$previous=$curHal-1;
				$linkHal=$linkHal."<ul class='pagination'><li class='page-item'><a class='page-link' onclick='".$fungsi."(1)'> First</a></li>";
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
			} else {
				$linkHal=$linkHal." <li class='page-item'><a class='page-link'>Next</a></li><li class='page-item'><a class='page-link'>Last</a></li></ul>";
			  }
			}
		return $linkHal;
    }
}