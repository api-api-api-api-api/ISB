<?php
App::uses('AppController', 'Controller');
/**
 * Approvaldpfbrngens Controller
 *
 */
class MaintenancekantorcabangsController extends AppController {
	public $components = array('Function','Paginator');
	function index(){
		// Initialise the framework sessions
		echo $this->Function->cekSession($this);
    }
    public function getData(){
        $this->autoRender = false;
        $this->loadModel('User');

        //filter
        $txtNamaCabangFilter=$_POST['txtNamaCabangFilter'];
        $txtAlamatCabangFilter=$_POST['txtAlamatCabangFilter'];
        $txtKotaCabangFilter=$_POST['txtKotaCabangFilter'];
        
        $txtKodeFilter=$_POST['txtKodeFilter'];
        $txtKontakFilter=$_POST['txtKontakFilter'];
        
        
        $hm=$_POST['hal'];
        $fungsi=$_POST['fungsi'];
       
        
        
        $txtData='';
        $limit=10;

        if(empty($hm)||$hm==1){$start=0;}else{$start=($hm-1)*$limit;}
       
        $sql="SELECT * FROM tripleadb.kantorcabang kc
        WHERE kc.nama like '%$txtNamaCabangFilter%' 
        AND kc.alamat like '%$txtAlamatCabangFilter%' 
        AND kc.kota like '%$txtKotaCabangFilter%'
        AND kc.kodecabang like '%$txtKodeFilter%'
        AND kc.kontakPerson like '%$txtKontakFilter%'
      
        ORDER BY kc.nama";
        //var_dump($sql);exit();
         
        $querysql=$this->User->query($sql);
        $jumQuery=count($querysql);
        $sum=ceil($jumQuery/$limit);
         
       
        /* -----------------------------Navigasi Record ala google style ----------------------------- */
        $linkHal=$this->pageNavMulti($hm,$sum,$limit,$fungsi);
        /* -----------------------------End Navigasi Record ala google style ----------------------------- */
        $rsTampil=$this->User->query($sql." limit $start, $limit");
        $n=$start+1;
         
        if($jumQuery==0 || $jumQuery==Null){
          
            $txtData.="
                <tr>
                     <td colspan='13' style='text-align:center;'><div class='alert alert-success' role='alert' style='margin-bottom: 0;'><strong>Data Kosong</strong></div></td>
                </tr>";
            }else{
                foreach($rsTampil as $data){
                    $id=$data['kc']['id'];

                    $txtData.="<tr>
                        <td style='vertical-align:middle;text-align:center' id='id".$n."' align='center'>".$n.".</td>
                        <td style='vertical-align:middle;text-align:left;' id='tdNamaCabang".$id."' align='center'>".$data['kc']['nama']."</td>
                        <td style='vertical-align:middle;text-align:left;' id='tdAlamat".$id."' align='center'>".$data['kc']['alamat']."</td>
                        <td style='vertical-align:middle;text-align:left;' id='tdKota".$id."' align='center'>".$data['kc']['kota']."</td>
                        <td style='vertical-align:middle;text-align:left;' id='tdkodeCabang".$id."' align='center'>".$data['kc']['kodecabang']."</td>
                        <td style='vertical-align:middle;text-align:left;' id='tdkontakPerson".$id."' align='center'>".$data['kc']['kontakPerson']."</td>
                        <td style='vertical-align:middle;text-align:left;' id='tdkantorCabangId".$id."' align='center'>".$data['kc']['kantorCabangId']."</td>
                        <td style= id='txtBtn".$id."' align='center'>
                            <button type='button' class='btn btn-xs btn-default edtBtn'><i class='fa fa-edit fa-lg' style='margin: 5px 5px;'></i></button>
                            <button type='button' class='btn btn-xs btn-default delBtn' style='display:none'><i class='fa fa-trash-o fa-lg'  style='margin: 5px 5px;'></i> </i></button>
                        </td>
                        <td style='display:none'>".$id."</td>
                    </tr>";
                    $n++;
                }
            }
        echo $txtData."!".$linkHal;
    }

    public function saveCRUD(){
        $this->autoRender = false;
        $this->loadModel('User');
  
        try{
            $dataSource = $this->User->getdatasource();
            $dataSource->begin();
            
            $sukses='';
            $hm='';
            $limit=10;
            //$id=$_POST['id'];
            //var_dump($_POST);exit();
            
                $CRUD=$_POST['CRUD'];
                
                $idCabang=$_POST['idCabang'];
                $namaCabang=$_POST['namaCabang'];
                $alamat=$_POST['alamat'];
                $kota=$_POST['kota'];
                $kodeCabang=$_POST['kodeCabang'];
                $kontakPerson=$_POST['kontakPerson'];
                $kantorCabangId=$_POST['kantorCabangId'];
                
                //var_dump($_POST);exit();
            if($CRUD=='add'){
                
                // $cekDataCabang="SELECT * FROM tripleadb.kantorcabang WHERE id='$idCabang'";
                // $querysql=$this->User->query($cekDataCabang);
                // $jumQuery=count($querysql);
                // if($jumQuery>0){
                //     echo "~double";
                //     return;
                // }

                $sql="INSERT INTO tripleadb.kantorcabang (
                -- id,
                nama,
                alamat,
                kota,
                kodecabang,
                kontakPerson,kantorCabangId)VALUES(
                -- '$idCabang',
                '$namaCabang',
                '$alamat',
                '$kota',
                '$kodeCabang',
                '$kontakPerson',
                '$kantorCabangId')";
                //var_dump($sql);exit();
                //var_dump($simpanJenis);exit();
                $this->User->query($sql);

                $sukses='sukses';
                $querygetID=$this->User->query("SELECT m.id FROM tripleadb.kantorcabang  m  ORDER BY m.id DESC limit 1");
                $recordid=0;
                $id=$querygetID[0]['m']['id'];
                $query=$this->User->query("SELECT * FROM tripleadb.kantorcabang  m  ORDER BY m.nama");
                foreach($query as $rowid){
                    $recordid ++;
                    if($rowid['m']['id']==$id){
                        break;
                    }
                }
                $hm=ceil($recordid/$limit); 

            }elseif($CRUD=='edit'){
                //var_dump($_POST);exit();
                //$id=$_POST['idCabang'];
                 
                $sql="UPDATE tripleadb.kantorcabang  SET 
                nama='$namaCabang', 
                alamat='$alamat',
                kota='$kota',
                kodecabang='$kodeCabang',
                kontakPerson='$kontakPerson'
                
                WHERE id = '$idCabang'";

                //var_dump($sql);exit();
                $this->User->query($sql);
                $sukses='sukses';
                $recordid=0;
                $query=$this->User->query("SELECT * FROM tripleadb.kantorcabang m  ORDER BY m.nama ");
                foreach($query as $rowid){
                    $recordid ++;
                    if($rowid['m']['id']==$idCabang){
                        break;
                    }
                }
                $hm=ceil($recordid/$limit); 
            }else{
                
            }
           
              
           
            echo $hm."~".$sukses;
  
            $dataSource->commit();	
        }
        catch(Exception $e){
            var_dump($e->getTrace());
            $dataSource->rollback();
        }
    }

    public function getKantorCabangID(){
        $this->autoRender = false;
        $this->loadModel('User');
		$nomor="";
       
       
        $query=$this->User->query("select kantorCabangId from tripleadb.kantorcabang f2 WHERE f2.kantorCabangId = (select max(kantorCabangId) from tripleadb.kantorcabang)");
        $row=count($query);
        
        
        if($row==0){
            $nomor="101";
            return $nomor;
        }
        $getLastNomor=$query[0]["f2"]["kantorCabangId"];
        $nomor= (float)$getLastNomor+1;
        return $nomor;
		
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