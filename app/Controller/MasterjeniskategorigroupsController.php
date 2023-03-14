<?php
App::uses('AppController', 'Controller');
/**
 * Masterjeniskategorigroups Controller
 *
 */
class MasterjeniskategorigroupsController extends AppController {
    public $components = array('Function','Paginator');
	public function index(){
		echo $this->Function->cekSession($this);
    }
    public function getKategori(){
        $this->autoRender = false;
        $txtKategori=$_POST['txtKategori'];
        $txtData='';
        $this->loadModel('User');
		
		$query="SELECT * FROM  definance.kategoribarangs ktbr WHERE ktbr.`nama` like '%$txtKategori%' ORDER BY nama";
        $ktbrs=$this->User->query($query);
        $jumKtbrs=count($ktbrs);
        $n=1;
        if($jumKtbrs==0 || $jumKtbrs==Null){
            $txtHead="<tr>
                        <th style=\"text-align:center;display:none;\" >id</th>
						<th style=\"text-align:center;\" width='15%'>No</th>
						<th style=\"text-align:center;\" width='70%'>Kategori</th>
						<th style=\"text-align:center;\" width='15%'>Aksi</th>
					</tr>";
			$txtData.="
			<tr>
				<td colspan=\"3\" style=\"text-align:center; border-bottom:1px solid red;\"  width='100%'>Kosong</td>
			</tr>";
		}else{
            $txtHead="<tr>
                        <th style=\"text-align:center;display:none;\" >id</th>
						<th style=\"text-align:center;\" width='15%'>No</th>
						<th style=\"text-align:center;\" width='70%'>Kategori</th>
                        <th class='editKat' style='text-align:center' width='15%'>Aksi</th>
                    </tr>";
                    foreach($ktbrs as $dataktbrs){
						$id=$dataktbrs['ktbr']['id'];
						$nama=$dataktbrs['ktbr']['nama'];
						$groupFPB=$dataktbrs['ktbr']['groupFPB'];
                        $idAsli=$dataktbrs['ktbr']['idAsal'];
            $txtData.="<tr id='tr".$id."' class='choose' >
                        <td id='txtidKat".$id."' align=\"center\" style=\"display:none;\">".$id."</td>
                        <td id='idKat".$id."' align=\"center\" width='15%' >".$n."</td>
                        <td id='txtNamaKat".$id."' align=\"left\" width='70%' >$nama</td>
                        <td class='editKategori' align=\"center\"  width='15%'><a href='javascript:void(0)' onClick='editLinkKat(\"".$id."\")'>Edit</a></td>
                        <td class='delKategori' align=\"center\"  width='15%'><a href='javascript:void(0)' onClick='delLinkKat(\"".$id."\")'>Delete</a></td>
                    </tr>";
                $n++;    
            }
        }
        echo $txtHead."!".$txtData;
    }
    public function getJenis(){
        $this->autoRender = false;
        $katId=$_POST['katId'];
        $txtData='';
        $this->loadModel('User');

        $query="SELECT * FROM  definance.jenisbarangs jnbr WHERE jnbr.kategoriId='$katId' ";
		// LEFT JOIN definance.kategoribarangs ktbr ON ktbr.id=jnbr.kategoriId
		//  WHERE jnbr.`kategoriId` LIKE '%$katId%' ORDER BY jnbr.`nama`";
        $jenisItem=$this->User->query($query);
        $jumJenisItem=count($jenisItem);

        $n=1;

		if($jumJenisItem==0 || $jumJenisItem==Null){
            $txtHead="<tr>
                        <th style=\"text-align:center;display:none;\">id</th>
						<th style=\"text-align:center;\" width='15%'>No</th>
						<th style=\"text-align:center;\" width='85%'>Jenis</th>
					</tr>";
                    $txtData.="
                    <tr>
                        <td colspan=\"2\" style=\"text-align:center;\" width='95%'>Kosong</td>
                    </tr>";

		}else{
            $txtHead="<tr>
                        <th style=\"text-align:center;display:none;\" >id</th>
                        <th style=\"text-align:center;\" width='15%'>No</th>
                        <th style=\"text-align:center;\" width='85%'>Jenis</th>
					</tr>";
			foreach($jenisItem as $dataItem){
						$id=$dataItem['jnbr']['id'];
                        $nama=$dataItem['jnbr']['nama'];
            $txtData.="<tr id='trJns".$id."' class='choose' >
                `       <td id='idJns".$n."' align=\"center\" style=\"display:none;\">".$id."</td>
                        <td align=\"center\" width='15%'>".$n."</td>
                        <td id='txtNamaJns".$id."' align=\"left\" width='85%'>$nama</td>
                    </tr>";
					$n++;
                }
        }
        echo $txtHead."!".$txtData;
    }
}