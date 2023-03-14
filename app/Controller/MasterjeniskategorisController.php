<?php
App::uses('AppController', 'Controller');
/**
 * Inpumasterjeniskategori Controller
 *
 */
class MasterjeniskategorisController extends AppController {
	public $components = array('Function','Paginator');
	public function index(){
		echo $this->Function->cekSession($this);
	}
	public function getKategori(){
		$this->autoRender = false;
		$this->loadModel('User');

			
		$query="SELECT id,nama FROM definance.kategoribarangs order by nama";
		$rskategori=$this->User->query($query);
		
		$dataArray=[];
		foreach($rskategori as $dataKategori){
			array_push($dataArray,$dataKategori);
			}
			print_r(json_encode($dataArray));

	}
	public function delData(){
		$this->autoRender = false;
		$this->loadModel('User');
		$id=$_POST["id"];
			$hasil= $this->User->query("DELETE FROM definance.`jenisbarangs` WHERE id =$id");
			if($hasil){
				echo "Error";
				}else{
				echo "Success";
		}
	}
	public function getData(){
		$this->autoRender = false;

		$txtJenis=$_POST['txtJenis'];
		$hm=$_POST['hal'];
		$txtData='';
		$limit=100;
		$this->loadModel('User');
		if(empty($hm)||$hm==1){
		$start=0; 
		}else{ 
			$start=($hm-1)*$limit; 
		}
		//$cItems="SELECT * FROM  definance.masterbarangs mbr WHERE mbr.`namaBarang` like '%$txtItemBarang%' ORDER BY id";
		$query="SELECT * FROM  definance.jenisbarangs jnbr 
		LEFT JOIN definance.kategoribarangs ktbr ON ktbr.id=jnbr.kategoriId
		 WHERE jnbr.`nama` LIKE '%$txtJenis%' ORDER BY jnbr.`nama`";
	
		$jenisBrgs=$this->User->query($query);
		$jumBrgs=count($jenisBrgs);
		$sum=ceil($jumBrgs/$limit);
		/* -----------------------------Navigasi Record ala google style ----------------------------- */
		$linkHal=$this->Function->pageNav($hm,$sum,$limit);
		/* -----------------------------End Navigasi Record ala google style ----------------------------- */
		$rsTampil=$this->User->query($query." limit $start, $limit");

		$n=$start+1;

		if($jumBrgs==0 || $jumBrgs==Null){
			$txtHead="<tr>
						<th style=\"text-align:center;\" width='10px'>No</th>
						<th style=\"text-align:center;display:none;\" >id</th>
						<th style=\"text-align:center;\">Jenis</th>
						<th style=\"text-align:center;\">Kategori</th>
						<th style=\"text-align:center;\">Groups</th>
						<th style=\"text-align:center;\">Groups FPB</th>
						<th style=\"text-align:center;\">idAsli</th>
						<th style=\"text-align:center;\">Aksi</th>
					</tr>";
			$txtData.="
			<tr>
				<td colspan=8 style=\"text-align:center;\">Kosong</td>
			</tr>";

		}else{
			$txtHead="<tr>
						<th style=\"text-align:center;border-right: 1px solid black;\" width='25px' >No</th>
						<th style=\"text-align:center;display:none;\" >id</th>
						<th style=\"text-align:center;\" width='150px' >Jenis</th>
						<th style=\"text-align:center;\">Kategori</th>
						<th style=\"text-align:center;\">Groups</th>
						<th style=\"text-align:center;\">Groups FPB</th>
						<th style=\"text-align:center;\">idAsli</th>
						<th class='editJenis' style='display:none;text-align:center'>Aksi</th>
						<th class='delJenis' style='display:none;text-align:center'>Aksi</th>
					</tr>";
			foreach($jenisBrgs as $dataItem){
						$id=$dataItem['jnbr']['id'];
						$nama=$dataItem['jnbr']['nama'];
						$groupsId=$dataItem['jnbr']['groupsId'];
						$ktbrBrngId=$dataItem['jnbr']['kategoriId'];
						$ktbrBrngNama=$dataItem['ktbr']['nama'];
						$groupFPB=$dataItem['jnbr']['groupFPB'];
						$idAsli=$dataItem['jnbr']['idAsli'];
			// if ($n==1){
			// 	$style="style='background-color:rgb(255, 111, 97); color: rgb(255, 255, 255);'";
			// }else{
			// 	$style='';
			// }
			$txtData.="<tr id='tr".$id."' class='choose' >
					<td id='id".$n."' align=\"center\" width='25px'>".$n."</td>
					<td id='id".$id."' align=\"center\" style=\"display:none;\">".$id."<input type='hidden' name='itemId' id='itemid".$id."' value='$id'></td>
					<td id='txtNama".$id."' align=\"left\" width='150px'>$nama</td>
					<td id='txtkategoriId".$id."' align=\"left\" style=\"display:none\">$ktbrBrngId</td>
					<td id='txtkategoriNama".$id."' align=\"left\">$ktbrBrngNama</td>
					<td id='txtgroupsId".$id."' align=\"left\">$groupsId</td>
					<td id='txtgroupFPB".$id."' align=\"left\">$groupFPB</td>
					<td id='txtidAsli".$id."' align=\"left\">$idAsli</td>
					<td class='editJenis' align=\"center\" style='display:none'><a href='javascript:void(0)' onClick='editLink(\"".$id."\")'>Edit</a></td>
					<td class='delJenis' align=\"center\" style='display:none'><a href='javascript:void(0)' onClick='delLink(\"".$id."\")'>Delete</a></td>
					</tr>";
					$n++;
				}
		}
		echo $txtHead."!".$txtData."!".$linkHal;
	}
	public function getData2(){
		$this->autoRender = false;
		$txtKategori=$_POST['txtKategori'];
		$hm=$_POST['hal'];
		
		$txtData='';
		$limit=100;
		$this->loadModel('User');
		if(empty($hm)||$hm==1){$start=0; }else{ $start=($hm-1)*$limit; }
		$query="SELECT * FROM  definance.kategoribarangs ktbr WHERE ktbr.`nama` like '%$txtKategori%' ORDER BY nama";
		
		$ktbrs=$this->User->query($query);
		
		$jumKtbrs=count($ktbrs);
		$sum=ceil($jumKtbrs/$limit);
		
		/* -----------------------------Navigasi Record ala google style ----------------------------- */
		$linkHal=$this->Function->pageNav($hm,$sum,$limit);
		/* -----------------------------End Navigasi Record ala google style ----------------------------- */
		$rsTampil=$this->User->query($query." limit $start, $limit");
		$n=$start+1;
		
		if($jumKtbrs==0 || $jumKtbrs==Null){
			$txtHead="<tr>
						<th style=\"text-align:center;\">No</th>
						<th style=\"text-align:center;display:none;\" >id</th>
						<th style=\"text-align:center;\">Kategori</th>
						<th style=\"text-align:center;\">Groups FPB</th>
						<th style=\"text-align:center;\">idAsli</th>
						<th style=\"text-align:center;\">Aksi</th>
					</tr>";
			$txtData.="
			<tr>
				<td colspan=6 style=\"text-align:center;\">Kosong</td>
			</tr>";

		}else{
			$txtHead="<tr>
						<th style=\"text-align:center;\">No</th>
						<th style=\"text-align:center;display:none;\" >id</th>
						<th style=\"text-align:center;\">Kategori</th>
						<th style=\"text-align:center;\">Groups FPB</th>
						<th style=\"text-align:center;\">idAsli</th>
						<th style=\"text-align:center;\">Aksi</th>
						<th class='editJenisKat' style='display:none;text-align:center'>Aksi</th>
						<th class='delJenisKat' style='display:none;text-align:center'>Aksi</th>
					</tr>";
					foreach($ktbrs as $dataktbrs){
						$id=$dataktbrs['ktbr']['id'];
						$nama=$dataktbrs['ktbr']['nama'];
						$groupFPB=$dataktbrs['ktbr']['groupFPB'];
						$idAsli=$dataktbrs['ktbr']['idAsal'];

			$txtData.="<tr id='tr".$id."' class='choose' >
					<td id='idKat".$n."' align=\"center\" >".$n."</td>
					<td id='txtidKat".$id."' align=\"center\" style=\"display:none;\">".$id."</td>
					<td id='txtNamaKat".$id."' align=\"left\" >$nama</td>
					<td id='txtgroupFPBKat".$id."' align=\"left\">$groupFPB</td>
					<td id='txtidAsalKat".$id."' align=\"left\">$idAsli</td>
					<td class='editJenisKat' align=\"center\" style='display:none'><a href='javascript:void(0)' onClick='editLinkKat(\"".$id."\")'>Edit</a></td>
					<td class='delJenisKat' align=\"center\" style='display:none'><a href='javascript:void(0)' onClick='delLinkKat(\"".$id."\")'>Delete</a></td>
					</tr>";
					$n++;
				}
		}

		echo $txtHead."!".$txtData."!".$linkHal;

	}
	public function saveData(){
		$this->autoRender = false;
		$this->loadModel('User');
		
		$mode=$_POST['mode'];
		if ($mode=='saveJenisInput'){
			$txtJenisInput=$_POST['txtJenisInput'];
			$txtKategoriInput=$_POST['txtKategoriInput'];
			$hasil= $this->User->query("INSERT INTO definance.`jenisbarangs` (nama,kategoriId) VALUES ('$txtJenisInput','$txtKategoriInput')");
			if($hasil){
				echo "save!Error";
				}else{
				echo "save!Success";
			}
			
		}
		if ($mode=='updateJenisInput'){
			$txtId=$_POST['txtId'];
			$txtJenisInput=$_POST['txtJenisInput'];
			$txtKategoriInput=$_POST['txtKategoriInput'];
			//var_dump($txtId.$txtNmReportInput.$txtLinkReportInput);
			//exit();
			$hasil= $this->User->query("UPDATE definance.`jenisbarangs` set nama='$txtJenisInput',kategoriId='$txtKategoriInput' WHERE id=$txtId");
			if($hasil){
				echo "update!Error";
				}else{
				echo "update!Success";
			}
		}	
	}
}