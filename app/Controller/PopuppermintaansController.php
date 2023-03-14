<?php
App::uses('AppController', 'Controller');
/**
 * Popupoutlets Controller
 *
 */
class PopuppermintaansController extends AppController {
	public $components = array('Function','Paginator');	
	public function index(){
	echo $this->Function->cekSession($this);
	}

	public function getData(){
	$this->autoRender = false;
	//echo "test";
	//$txtOutlet=$_POST['txtOutlet'];
	$hm=$_POST['hal'];

	$limit=20;
	$txtHead="";
	$txtData="";
	$this->loadModel('Penawaranfpb');
		if(empty($hm)||$hm==1){$start=0; }
		else{ $start=($hm-1)*$limit; }

	$permintaan="SELECT * FROM permintaanfpbfinals fpb LEFT OUTER JOIN (SELECT DISTINCT permintaanId FROM penawaranfpbs) AS penawaran ON fpb.`permintaanId` = penawaran.permintaanId  WHERE penawaran.`permintaanId` IS NULL ORDER BY id";
	$resPermintaan=$this->Penawaranfpb->query($permintaan);
	$jumPermintaan=count($resPermintaan);
	//var_dump($jumPermintaan);
	$sum=ceil($jumPermintaan/$limit);
	/* -----------------------------Navigasi Record ala google style ----------------------------- */
	$linkHal=$this->Function->pageNav($hm,$sum,$limit);
	/* -----------------------------End Navigasi Record ala google style ----------------------------- */
	$rsTampil=$this->Penawaranfpb->query($permintaan." limit $start, $limit");
	

	if($jumPermintaan==0 || $jumPermintaan==Null){
		$txtHead="<tr>
			<td align=\"center\">No</td>
			<td align=\"center\" style='display:none'>ID</td>
			<td align=\"center\">Nama Permintaan</td>
			<td align=\"center\">User request</td>
			<td align=\"center\">Kode Item</td>
			<td align=\"center\">Nama Item</td>
			<td align=\"center\" style=\"display:none\">NoTransPermintaan</td>
			<td align=\"center\" style=\"display:none\">Harga</td>
			<td align=\"center\" style=\"display:none\">Jumlah</td>
			<td align=\"center\" style=\"display:none\">Total</td>
			<td align=\"center\" style=\"display:none\">Total Disetujui</td>
			<td align=\"center\" style=\"display:none\">Qty Diproses</td>
			<td></td>
			</tr>";
			$txtData.="
			<tr>
				<td colspan=6 align=\"center\">Belum ada permintaan</td>
			</tr>";

	}else{
		$n=$start+1;
		foreach($rsTampil as $dataPermintaan){
			$userRequest=$dataPermintaan['fpb']['namaKaryawan']."#".$dataPermintaan['fpb']['nik']."/".$dataPermintaan['fpb']['namaDivisi'];
			$txtHead="<tr>
				<td align=\"center\">No</td>
				<td align=\"center\" style='display:none'>ID</td>
				<td align=\"center\">Nama Permintaan</td>
				<td align=\"center\">User request</td>
				<td align=\"center\">Kode Item</td>
				<td align=\"center\">Nama Item</td>
				<td align=\"center\" style=\"display:none\">NoTransPermintaan</td>
				<td align=\"center\" style=\"display:none\">Harga</td>
				<td align=\"center\" style=\"display:none\">Jumlah</td>
				<td align=\"center\" style=\"display:none\">Total</td>
				<td align=\"center\" style=\"display:none\">Total Disetujui</td>
				<td align=\"center\" style=\"display:none\">Qty Diproses</td>
				<td></td>
				</tr>";
			$txtData.="
			<tr>
				<td align=\"center\">$n</td>
				<td id='id".$dataPermintaan['fpb']['permintaanId']."' align=\"center\" style=\"display:none\">".$dataPermintaan['fpb']['permintaanId']."</td>
				<td id='txtJenPer".$dataPermintaan['fpb']['permintaanId']."' align=\"left\">".$dataPermintaan['fpb']['jenisPermintaan']."</td>
				<td id='txtUser".$dataPermintaan['fpb']['permintaanId']."' align=\"left\">$userRequest</td>
				<td id='txtMasterBarang".$dataPermintaan['fpb']['permintaanId']."' align=\"left\">".$dataPermintaan['fpb']['masterBarangId']."</td>
				<td id='txtNmBarang".$dataPermintaan['fpb']['permintaanId']."' align=\"left\">".$dataPermintaan['fpb']['namaBarang']."</td>
				<td id='txtNoTrans".$dataPermintaan['fpb']['permintaanId']."' align=\"center\" style=\"display:none\" >".$dataPermintaan['fpb']['noTransPermintaan']."</td>
				<td id='txtHarga".$dataPermintaan['fpb']['permintaanId']."' align=\"center\" style=\"display:none\">".$dataPermintaan['fpb']['harga']."</td>
				<td id='txtJumlah".$dataPermintaan['fpb']['permintaanId']."' align=\"center\" style=\"display:none\">".$dataPermintaan['fpb']['jumlah']."</td>
				<td id='txtTotal".$dataPermintaan['fpb']['permintaanId']."' align=\"center\" style=\"display:none\">".$dataPermintaan['fpb']['total']."</td>
				<td id='txtTotalAcc".$dataPermintaan['fpb']['permintaanId']."' align=\"center\" style=\"display:none\">".$dataPermintaan['fpb']['totalDisetujui']."</td>
				<td id='txtQtyProses".$dataPermintaan['fpb']['permintaanId']."' align=\"center\" style=\"display:none\">".$dataPermintaan['fpb']['qtyDiproses']."</td>
				<td align=\"center\">
				<a href='#' onClick='addToData(\"".$dataPermintaan['fpb']['permintaanId']."\")'>pilih</a>&nbsp&nbsp</a></td><br />
				</tr>";

			$n++;
		}
	}
	echo $txtHead."!".$txtData."!".$linkHal;
	}
}


