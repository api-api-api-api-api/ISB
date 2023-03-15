<?php
App::uses('AppController','Controller');

class MaintenanceusersController extends AppController {
    public $components = array('Function','Paginator');
    function index()
    {
         echo $this->Function->cekSession($this);
    }
    
    public function getGroup(){
        $this->autoRender = false;
        $this->loadModel('User');
        $txtGroup='';
        $id=$_POST['id'];
        $selected='';
		$hasil1=$this->User->query("SELECT ID,namaGroup FROM tripleadb.groups ORDER BY namaGroup");
		// $txtDivisi="<option value=''>All</option>";
		foreach($hasil1 as $group){
            $groupID=$group['groups']['ID'];
            if($id===$groupID){
				$selected='selected';
			}else{$selected='';}
			$txtGroup.="<option value='".$group['groups']['ID']."' $selected>".$group['groups']['namaGroup']."</option>";
		}				
		echo $txtGroup;	
    }

    public function getPerusahaan(){
        $this->autoRender = false;
        $this->loadModel('User');
        $txtPerusahaan='';
        $id=$_POST['id'];
        $selected='';
		$hasil1=$this->User->query("SELECT id,namaPrincipal FROM tripleadb.principals ORDER BY namaPrincipal");
		// $txtDivisi="<option value=''>All</option>";
		foreach($hasil1 as $principal){
            $principalid=$principal['principals']['id'];
            if($id===$principalid){
				$selected='selected';
			}else{$selected='';}
			$txtPerusahaan.="<option value='".$principal['principals']['id']."' $selected>".$principal['principals']['namaPrincipal']."</option>";
		}				
		echo $txtPerusahaan;	
    }
    public function getDivisi(){
        $this->autoRender = false;
        $this->loadModel('User');
        $txtDivisi='';
        $id=$_POST['id'];
        $selected='';
		$hasil1=$this->User->query("SELECT id,nama_divisi FROM dpfdplnew.divisis ORDER BY nama_divisi");
		// $txtDivisi="<option value=''>All</option>";
		foreach($hasil1 as $divisi){
            $divisiid=$divisi['divisis']['id'];
            if($id===$divisiid){
				$selected='selected';
			}else{$selected='';}
			$txtDivisi.="<option value='".$divisi['divisis']['id']."' $selected>".$divisi['divisis']['nama_divisi']."</option>";
		}				
		echo $txtDivisi;	
    }

    public function getComid(){
        $this->autoRender = false;
        $this->loadModel('User');
        $txtComid='';
        $id=$_POST['id'];
        $selected='';
        //echo "SELECT kantorCabangId,nama FROM tripleadb.kantorcabang WHERE DATALENGTH(kantorCabangId) > 0  ORDER BY nama";exit();
		$hasil1=$this->User->query("SELECT kantorCabangId,nama FROM tripleadb.kantorcabang WHERE (kantorCabangId<>'' OR kantorCabangId IS NOT NULL)  ORDER BY nama");
		// $txtDivisi="<option value=''>All</option>";
		foreach($hasil1 as $com){
            $comid=$com['kantorcabang']['kantorCabangId'];
            if($id===$comid){
				$selected='selected';
			}else{$selected='';}
			$txtComid.="<option value='".$com['kantorcabang']['kantorCabangId']."' $selected>".$com['kantorcabang']['nama']."</option>";
		}				
		echo $txtComid;	
    }
    public function getData(){
        $this->autoRender = false;
        $this->loadModel('User');

        //filter
        $txtNamaUserFilter=$_POST['txtNamaUserFilter'];
        $txtPenanggungJawabFilter=$_POST['txtPenanggungJawabFilter'];
        $txtNamaGroupFilter=$_POST['txtNamaGroupFilter'];
        
        $txtNIKFilter=$_POST['txtNIKFilter'];
        $txtNamaKaryawanFilter=$_POST['txtNamaKaryawanFilter'];

        if(!empty($txtNIKFilter)){$txtNIKFilter=" AND u.nik like '%$txtNIKFilter%'";}
        if(!empty($txtNamaKaryawanFilter)){$txtNamaKaryawanFilter=" AND u.namaKary like '%$txtNamaKaryawanFilter%'";}
        $hm=$_POST['hal'];
        $fungsi=$_POST['fungsi'];
       
        
        
        $txtData='';
        $limit=10;

        if(empty($hm)||$hm==1){$start=0;}else{$start=($hm-1)*$limit;}
       
        $sql="SELECT * FROM users u
        LEFT JOIN groups g ON g.ID=u.groupId

        WHERE u.namaUser like '%$txtNamaUserFilter%' 
        AND u.penanggungJawab like '%$txtPenanggungJawabFilter%' 
        AND g.namaGroup like '%$txtNamaGroupFilter%'
        $txtNIKFilter
        $txtNamaKaryawanFilter
        ORDER BY u.id";
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
                    $id=$data['u']['ID'];
                    $setTglLahir="";
                    if(!empty($data['u']['tglLahir'])){$setTglLahir=$this->Function->dateindo($data['u']['tglLahir']);}
                    $txtData.="<tr>
                        <td style='vertical-align:middle;text-align:center' id='id".$n."' align='center'>".$n.".</td>
                        <td style='vertical-align:middle;text-align:left' id='tdNamaUser".$id."' align='center'>".$data['u']['namaUser']."</td>
                        <td style='vertical-align:middle;text-align:left;display:none;' id='tdgroup".$id."' align='center'>".$data['u']['groupId']."</td>
                        <td style='vertical-align:middle;text-align:left' id='tdnamaGroup".$id."' align='center'>".$data['g']['namaGroup']."</td>
                        <td style='vertical-align:middle;text-align:left;display:none;' id='tdstatusLog".$id."' align='center'>".$data['u']['statusLog']."</td>
                        <td style='vertical-align:middle;text-align:left' id='tdpenanggungJawab".$id."' align='center'>".$data['u']['penanggungJawab']."</td>
                        
                        <td style='vertical-align:middle;text-align:left;display:none;' id='tdcomId".$id."' align='center'>".$data['u']['comId']."</td>
                        <td style='vertical-align:middle;text-align:left;display:none;' id='tdketerangan".$id."' align='center'>".$data['u']['keterangan']."</td>
                        <td style='vertical-align:middle;text-align:left;display:none;' id='tdpejabatId".$id."' align='center'>".$data['u']['pejabatId']."</td>
                        <td style='vertical-align:middle;text-align:left;display:none;' id='tdperusahaanId".$id."' align='center'>".$data['u']['perusahaanId']."</td>
                        <td style='vertical-align:middle;text-align:left;display:none;' id='tddivisi".$id."' align='center'>".$data['u']['divisi']."</td>
                        
                        
                        <td style='vertical-align:middle;text-align:center' id='tdtglLahir".$id."' align='center'>".$setTglLahir."</td>
                        <td style='vertical-align:middle;text-align:left;display:none;' id='tdpword".$id."' align='center'>".$data['u']['pword']."</td>
                        <td style='vertical-align:middle;text-align:left;display:none;' id='tdidUser".$id."' align='center'>".$data['u']['idUser']."</td>
                        <td style='vertical-align:middle;text-align:left;display:none;' id='tdarcoId".$id."' align='center'>".$data['u']['arcoId']."</td>
                        <td style='vertical-align:middle;text-align:left;display:none;' id='tdsubDivisi".$id."' align='center'>".$data['u']['subDivisi']."</td>
                        <td style='vertical-align:middle;text-align:left;display:none;' id='tdreg".$id."' align='center'>".$data['u']['reg']."</td>
                        <td style='vertical-align:middle;text-align:left;display:none;' id='tdinisial".$id."' align='center'>".$data['u']['inisial']."</td>
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
                
                $namaUser=$_POST['namaUser'];
                //$password=$_POST['password'];
                $password="";
                $group=$_POST['group'];
                $statusLog=$_POST['statusLog'];
                $idUser=$_POST['idUser'];
                $penanggungJawab=$_POST['penanggungJawab'];
                $keterangan=$_POST['keterangan'];
                $pejabat=$_POST['pejabat'];
                $perusahaan=$_POST['perusahaan'];
                $divisi=$_POST['divisi'];
                $com=$_POST['com'];
                $arco=$_POST['arco'];
                $subDivisi=$_POST['subDivisi'];
                $reg=$_POST['reg'];
                $inisial=$_POST['inisial'];
                $nik=$_POST['nik'];
                $namaKaryawan=$_POST['namaKaryawan'];
                if(!empty($_POST['tglLahir'])){
                    $tglLahir="'".$this->Function->dateluar($_POST['tglLahir'])."'";
                    $passSplit=explode("-",$_POST['tglLahir']);
                    $password=$passSplit[0].$passSplit[1].$passSplit[2];
                }else{
                    $tglLahir='NULL';
                }
                //var_dump($password);exit();
            if($CRUD=='add'){
                        
                $sql="INSERT INTO tripleadb.users (namaUser,
                pword,
                groupId,
                -- statusLog,
                -- idUser,
                penanggungJawab,
                -- keterangan,
                -- pejabatId,
                -- perusahaanId,
                -- divisi,
                comId,
                -- arcoId,
                -- subDivisi,
                -- reg,
                -- inisial,
                nik,
                namaKary,
                tglLahir)VALUES('$namaUser',
                '$password',
                '$group',
                -- '$statusLog',
                -- '$idUser',
                '$penanggungJawab',
                -- '$keterangan',
                -- '$pejabat',
                -- '$perusahaan',
                -- '$divisi',
                '$com',
                -- '$arco',
                -- '$subDivisi',
                -- '$reg',
                -- '$inisial',
                '$nik',
                '$namaKaryawan',
                $tglLahir)";
                //var_dump($sql);exit();
                //var_dump($simpanJenis);exit();
                $this->User->query($sql);

                $sukses='sukses';
                $querygetID=$this->User->query("SELECT m.ID FROM tripleadb.users  m  ORDER BY m.ID DESC limit 1");
                $recordid=0;
                $id=$querygetID[0]['m']['ID'];
                $query=$this->User->query("SELECT * FROM tripleadb.users  m  ORDER BY m.ID");
                foreach($query as $rowid){
                    $recordid ++;
                    if($rowid['m']['ID']==$id){
                        break;
                    }
                }
                $hm=ceil($recordid/$limit); 

            }elseif($CRUD=='edit'){
                //var_dump($_POST);exit();
                $ID=$_POST['userID'];
                 
                $sql="UPDATE tripleadb.users  SET 
                namaUser='$namaUser', 
                pword='$password',
                groupId='$group',
                -- statusLog='$statusLog',
                -- idUser='$idUser',
                penanggungJawab='$penanggungJawab',
                -- keterangan='$keterangan',
                -- pejabatId='$pejabat',
                -- perusahaanId=$perusahaan,
                -- divisi='$divisi',
                comId=$com,
                -- arcoId='$arco', 
                -- subDivisi='$subDivisi',
                -- reg='$reg',
                -- inisial='$inisial',
                nik='$nik',
                namaKary='$namaKaryawan',
                tglLahir=$tglLahir
                
                WHERE ID = '$ID'";

                $this->User->query($sql);
                $sukses='sukses';
                $recordid=0;
                $query=$this->User->query("SELECT * FROM tripleadb.users m  ORDER BY m.ID ");
                foreach($query as $rowid){
                    $recordid ++;
                    if($rowid['m']['ID']==$ID){
                        break;
                    }
                }
                $hm=ceil($recordid/$limit); 
            }
              
           
            echo $hm."~".$sukses;
  
            $dataSource->commit();	
        }
        catch(Exception $e){
            var_dump($e->getTrace());
            $dataSource->rollback();
        }
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