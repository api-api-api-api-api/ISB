<?php
App::uses('AppController', 'Controller');
/**
 * Inputsettingpivots Controller
 *
 */
class  PabanksoalsController extends AppController {
public $components = array('Function','Paginator');	
public function index(){
	echo $this->Function->cekSession($this);
	}


	// tambahan rizki set data divisi and jabatan
	public function getDivisi(){
        $this->autoRender = false;
        $this->loadModel('User');
        $this->loadModel('Asset');
        $this->Asset->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'"); 
    
       
        //$txtdata=[];
		//dari master karyawan
        //$queryDivisi=$this->Asset->query("SELECT DISTINCT kodedivisi FROM absensi.`master_karyawan` WHERE tglKeluar > CURDATE() AND kodedivisi IS NOT NULL AND kodedivisi <> '' ORDER BY kodedivisi");
		$queryDivisi=$this->Asset->query("SELECT * FROM kpireg.`padivisisoals` padiv ORDER BY padiv.`namaDivisi`");

        if(count($queryDivisi)<1){
             $txtdata[]=array('label'=>'-Empty-','value'=>'0');
            echo json_encode($txtdata);
            return;
        }
        $txtdata[]=array('label'=>'-Please Select-','value'=>'0');
        foreach($queryDivisi as $dtDivisi){
            $txtdata[]= array('label'=>$dtDivisi["padiv"]["namaDivisi"],'value'=>$dtDivisi["padiv"]["namaDivisi"].'~'.$dtDivisi["padiv"]["id"]);
        }

        echo json_encode($txtdata);
        exit();
    }
	public function getJabatan(){
        $this->autoRender = false;
        $this->loadModel('User');
        $this->loadModel('Asset');
        $this->Asset->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'"); 
    
       	$divisiId=$_POST['divisi'];
        //$txtdata=[];
		//dari masterkaryawan
        //$queryJabatan=$this->Asset->query("SELECT DISTINCT jabatan FROM absensi.`master_karyawan` WHERE tglKeluar >  CURDATE() AND jabatan IS NOT NULL AND jabatan<>'' AND kodedivisi='$kodeDivisi' ORDER BY jabatan;");
		$queryJabatan=$this->Asset->query("SELECT *  FROM kpireg.`pajabatansoals` pajab WHERE pajab.`divisiId`='$divisiId' ORDER BY pajab.`namaJabatan`");

        if(count($queryJabatan)<1){
             $txtdata[]=array('label'=>'-Empty-','value'=>'0');
            echo json_encode($txtdata);
            return;
        }
        $txtdata[]=array('label'=>'-Please Select-','value'=>'0');
        foreach($queryJabatan as $dtJabatan){
            $txtdata[]= array('label'=>$dtJabatan["pajab"]["namaJabatan"],'value'=>$dtJabatan["pajab"]["namaJabatan"].'~'.$dtJabatan["pajab"]["id"]);
        }

        echo json_encode($txtdata);
        exit();
    }
	public function getdata(){
	
		//$this->loadModel('Group');
		$this->loadModel('Asset');
		$this->autoRender = false;
		
		$idUser=$this->Session->read('dpfdpl_userId');
      
        $hm=$_POST['hal'];
        $fungsi=$_POST['fungsi'];

        $hm=$_POST['kategori'];
       
        

        $limit=1000;
        if(empty($hm)||$hm==1){$start=0;}else{$start=($hm-1)*$limit;}
		

		$sql="SELECT a.* FROM kpireg.pabanksoals AS a WHERE  a.soal!='' and a.`statusSoal` IS NULL ORDER BY a.kategori DESC";


		/*
					$sql="SELECT a.*,b.periodeStart as pstart, b.periodeEnd as pend FROM ppkbanksoals AS a JOIN ppkperiodepenilaians AS b ON a.periode=b.id WHERE statusSoal='true' and  a.soal!='0' order by a.tanggalInput,a.kategori";
		*/
        //var_dump($sql);exit();
        
        //var_dump($sql);exit();
        $querysql=$this->Asset->query($sql);
        //var_dump($querysql);exit();
        $jumQuery=count($querysql);
        $sum=ceil($jumQuery/$limit);
        /* -----------------------------Navigasi Record ala google style ----------------------------- */
        $linkHal=$this->pageNavMulti($hm,$sum,$limit,$fungsi);
        /* -----------------------------End Navigasi Record ala google style ----------------------------- */
        $rsTampil=$this->Asset->query($sql." limit $start, $limit");
        $n=$start+1;
        
        if($jumQuery==0 || $jumQuery==Null){
                
        $txtData=' <tr><td colspan="7"><center>Data masih kosong</center></td></tr>';
    

          }else{
          	$txtData="";
          	$no=1;
				foreach($rsTampil as $data){
					//var_dump();exit();
					
				$replacekategori=preg_replace("/[^a-zA-Z0-9]/", "", $data['a']['kategori']);
				$txtData.=" <tr class='trhasildata trdata".$replacekategori."'>";
				$txtData.="<td style='display:none'>".$no."<input type='hidden' id='txtid_".$data['a']['id']."' value='".$data['a']['id']."'></td>";
				//$txtData.="<td id='periode_".$data['a']['id']."'>".$data['b']['pstart']." sampai ".$data['b']['pend']."</td>";
				$txtData.="<td id='soal_".$data['a']['id']."'>".$data['a']['soal']."</td>";
				$txtData.="<td id='peruntukansoal_".$data['a']['id']."'>".$data['a']['peruntukanSoal']."</td>";
				$txtData.="<td id='kategori_".$data['a']['id']."'>".$data['a']['kategori']."</td>";
				$txtData.="<td id='tipesoal_".$data['a']['id']."'>".$data['a']['tipeSoal']."</td>";
				$txtData.="<td id='bobot_".$data['a']['id']."'>".$data['a']['bobot']."</td>";
				$txtData.="<td><button type='button' class='btn btn-success btn-sm stsperiode' onclick='editsoal(".$data['a']['id'].")'>edit Soal</button><button type='button' class='btn btn-danger btn-sm stsperiode' onclick='hapussoal(".$data['a']['id'].")'>hapus Soal</button></td>";
				$txtData.=" </tr>";
					
		
			   $no++;
			}
		}
		  echo $txtData."!".$linkHal;
	}







	public function getdatabaru(){
	
		//$this->loadModel('Group');
		$this->loadModel('Asset');
		$this->autoRender = false;
		
		$idUser=$this->Session->read('dpfdpl_userId');
		
/////////////////////////////////NAV KATEGORI/////////////////////////////////////////////////////////////////////////////////////
		$sql="SELECT DISTINCT(kategori) AS dkategori,id,tipeSoal,bobotTable FROM kpireg.pabanksoals AS a WHERE bobot IS NULL GROUP BY kategori ORDER BY FIELD(dkategori, 'Unset Kategori') DESC";
        $querysql=$this->Asset->query($sql);
  
      	$dashboardKategori1="";
      	$dashboardKategori2="";
      	$dashboardKategoriUnset="";
      	$tabPertama="true";
      	$txtTabPertama="";
		foreach($querysql as $data){
							if($data['a']['dkategori']=="Unset Kategori"){
								
							$akatagori=$data['a']['dkategori'];
							$replacekategori=preg_replace("/[^a-zA-Z0-9]/", "", $data['a']['dkategori']);
							$dashboardKategoriUnset='<li id="lid'.$replacekategori.'" class="lidi" onclick="liclick(/'.$akatagori.'/)"><a href="javascript:void(0)">'.$data['a']['dkategori'].'</a></li>';
							}else{
			
								if($tabPertama=="true"){
									$akatagori=$data['a']['dkategori'];
									$replacekategori=preg_replace("/[^a-zA-Z0-9]/", "", $data['a']['dkategori']);
									$dashboardKategori1='<li class="active lidi"  id="lid'.$replacekategori.'" onclick="liclick(/'.$akatagori.'/)"><a href="javascript:void(0)" >'.$data['a']['dkategori'].'</a></li>';
									$tabPertama="false";
									$txtTabPertama=$data['a']['dkategori'];
								}else{
									$akatagori=$data['a']['dkategori'];
									$replacekategori=preg_replace("/[^a-zA-Z0-9]/", "", $data['a']['dkategori']);
									$dashboardKategori2.='<li id="lid'.$replacekategori.'" class="lidi" onclick="liclick(/'.$akatagori.'/)"><a href="javascript:void(0)">'.$data['a']['dkategori'].'</a></li>';
								}
					
					}
		}

/////////////////////////////////////////////////////////////////////////////////////////////////



      

		//mengambil kategori soal untuk sikap(Attitude)
		$txtDataAttitude="";
		
		$sqlSikap="SELECT a.* FROM kpireg.`pabanksoals` AS a WHERE  a.`kategori`='Sikap (Attitude)' AND a.`statusSoal` IS NULL";
		//var_dump($sqlSikap);exit();
		$rsTampil=$this->Asset->query($sqlSikap);
    	$jumQuery=count($rsTampil);
		if($jumQuery==0 || $jumQuery==Null){
			$txtData=' <tr><td colspan="7"><center>Data masih kosong</center></td></tr>';
			$replacekategoriAtt=preg_replace("/[^a-zA-Z0-9]/", "","Sikap (Attitude)");
			$txtData.=' <tr class="trhasildata trdata'.$replacekategoriAtt.'"><td colspan="7"><center>Data masih kosong</center></td></tr>';
		}else{
			$no=1;
			foreach($rsTampil as $data){
				$replacekategoriAtt=preg_replace("/[^a-zA-Z0-9]/", "", $data['a']['kategori']);
				$peruntukanSoal=$data['a']['peruntukanSoal']=="marketing"?"MARKETING":($data['a']['peruntukanSoal']=="nonmarketing"?"NON MARKETING":"");
				$txtDataAttitude.=" <tr class='trhasildata trdata".$replacekategoriAtt."'>";
				$txtDataAttitude.="<td width='3%'>".$no."<input type='hidden' id='txtid_".$data['a']['id']."' value='".$data['a']['id']."'></td>";
				$txtDataAttitude.="<td width='30%' id='soal_".$data['a']['id']."'>".$data['a']['soal']."</td>";
				$txtDataAttitude.="<td width='10%' id='peruntukansoal_".$data['a']['id']."' style='display:none;'>".$peruntukanSoal."</td>";
				$txtDataAttitude.="<td width='15%' id='kategori_".$data['a']['id']."'>".$data['a']['kategori']."<input type='hidden' id='xtxtkategori_".$data['a']['id']."' value='".$data['a']['kategori']."'></td>";
				$txtDataAttitude.="<td width='5%' id='tipesoal_".$data['a']['id']."'>".$data['a']['tipeSoal']."</td>";
				$txtDataAttitude.="<td width='5%' id='bobot_".$data['a']['id']."'>".$data['a']['bobot']."</td>";
				$txtDataAttitude.="<td id='divisi_".$data['a']['id']."' style='display:none;'>".$data['a']['divisiId']."</td>";
				$txtDataAttitude.="<td id='jabatan_".$data['a']['id']."' style='display:none;'>".$data['a']['jabatanId']."</td>";
				$txtDataAttitude.="<td width='8%'  id='divisiNama_".$data['a']['id']."' style='display:none;'>".$data['a']['namaDivisi']."</td>";
				$txtDataAttitude.="<td width='8%'  id='jabatanNama_".$data['a']['id']."' style='display:none;'>".$data['a']['namaJabatan']."</td>";
				$txtDataAttitude.="<td width='16%' >
						<button type='button' class='btn btn-success btn-sm stsperiode' onclick='editsoal(".$data['a']['id'].")'><i class='fa fa-pencil fa-lg'  style='margin: 3px 1px;'></i></button>
						<button type='button' class='btn btn-danger btn-sm stsperiode' onclick='hapussoal(".$data['a']['id'].")'><i class='fa fa-trash-o fa-sm' style='margin: 3px 3px;'></i></button>
						<button type='button' class='btn btn-primary btn-sm stsperiode' onclick='gantikategorisoal(".$data['a']['id'].")'><i class='fa fa-share'  style='margin: 3px 2px;'></i></button>
						
						</td>";
						
				$txtDataAttitude.=" </tr>";
				$no++;
			}
		}
		// <button type='button' class='btn btn-info btn-sm stsperiode' onclick='copysoal(".$data['a']['id'].")'><i class='fa fa-files-o fa-sm' style='margin: 3px 1px;'></i></button>

		//	$sql="SELECT a.* FROM performanceappraisal.pabanksoals AS a WHERE  a.soal!='' and a.kategori='".$txtTabPertama."' ORDER BY a.kategori DESC";
		//var_dump($_POST);exit();
		//filter divisi dan jabatan
		$divisi 		=$_POST['divisi'];
		$jabatan		=$_POST['jabatan'];
		$peruntukan		=$_POST['peruntukan'];
		$divisiJabatanFilter="";
		$jabatanFilter="";
		//var_dump($divisi);exit();
		if(!empty($divisi) ){
			$divisi=explode('~',$divisi);
			$divisiJabatanFilter=" AND a.`divisiId`='$divisi[1]'";
			
			if(!empty($jabatan)){
				$jabatan=explode('~',$jabatan);
				$divisiJabatanFilter.=" AND a.`jabatanId`='$jabatan[1]'";
			}else{
				$divisiJabatanFilter=$divisiJabatanFilter;
			}
		}else{
			$divisiJabatanFilter=" AND (a.`divisiId` IS NULL OR a.`divisiId`='') AND (a.`jabatanId` IS NULL OR a.`jabatanId`='')";
		}
		
		if($peruntukan=='all'){
			$peruntukan='';
		}elseif($peruntukan=='marketing'){
			$peruntukan=' AND a.`peruntukanSoal`="marketing"';
		}elseif($peruntukan=='nonmarketing'){
			$peruntukan=' AND a.`peruntukanSoal`="nonmarketing" ';
		}
		$txtDataJobImplementation="";
		
		// $sql="SELECT a.* FROM kpireg.pabanksoals AS a WHERE   a.`kategori`='Pelaksanaan Pekerjaan (Job Implementation)' AND a.soal!='' $peruntukan AND a.`statusSoal` IS NULL $divisiJabatanFilter   ORDER BY a.kategori DESC";
		$sql="SELECT a.*,dv.* ,jab.* FROM kpireg.`pabanksoals` AS a LEFT JOIN kpireg.`padivisisoals` dv ON dv.`id`=a.`divisiId` LEFT JOIN kpireg.`pajabatansoals` jab ON a.`jabatanId`=jab.`id` WHERE   a.`kategori`='Pelaksanaan Pekerjaan (Job Implementation)' AND a.soal!='' $peruntukan AND a.`statusSoal` IS NULL $divisiJabatanFilter   ORDER BY a.kategori DESC";
		//var_dump($sql);exit();
        $rsTampil=$this->Asset->query($sql);
    	$jumQuery=count($rsTampil);
        
        if($jumQuery==0 || $jumQuery==Null){
                
        
		$replacekategoriJob=preg_replace("/[^a-zA-Z0-9]/", "", "Pelaksanaan Pekerjaan (Job Implementation)");
		$txtDataJobImplementation.="<tr class='trhasildata trdata".$replacekategoriJob."'><td colspan='7'><center>Data masih kosong</center></td></tr>";
          }else{
          
          	$no=1;
			$noAtitude=1;
			$noJobImplementation=1;
				foreach($rsTampil as $data){
					// if($data['a']['peruntukanSoal']=="marketing"){
					// 	$peruntukanSoal="MARKETING";
					// }else{
					// 	$peruntukanSoal="NON MARKETING";
					// }
					$peruntukanSoal=$data['a']['peruntukanSoal']=="marketing"?"MARKETING":($data['a']['peruntukanSoal']=="nonmarketing"?"NON MARKETING":"");

		
				$replacekategoriJob=preg_replace("/[^a-zA-Z0-9]/", "", $data['a']['kategori']);
				$txtDataJobImplementation.=" <tr class='trhasildata trdata".$replacekategoriJob."'>";
				// if($replacekategori=="SikapAttitude"){
				// 	$txtData.="<td width='3%'>".$noAtitude."<input type='hidden' id='txtid_".$data['a']['id']."' value='".$data['a']['id']."'></td>";
				// 	$noAtitude++;
				// }else{
				// 	$txtData.="<td width='3%'>".$noJobImplementation."<input type='hidden' id='txtid_".$data['a']['id']."' value='".$data['a']['id']."'></td>";
				// 	$noJobImplementation++;
				// }
				
				//$txtData.="<td id='periode_".$data['a']['id']."'>".$data['b']['pstart']." sampai ".$data['b']['pend']."</td>";
				$txtDataJobImplementation.="<td width='3%'>".$no."<input type='hidden' id='txtid_".$data['a']['id']."' value='".$data['a']['id']."'></td>";
				$txtDataJobImplementation.="<td width='30%' id='soal_".$data['a']['id']."'>".$data['a']['soal']."</td>";
				$txtDataJobImplementation.="<td width='10%' id='peruntukansoal_".$data['a']['id']."'>".$peruntukanSoal."</td>";
				$txtDataJobImplementation.="<td width='15%' id='kategori_".$data['a']['id']."'>".$data['a']['kategori']."<input type='hidden' id='xtxtkategori_".$data['a']['id']."' value='".$data['a']['kategori']."'></td>";
				$txtDataJobImplementation.="<td width='5%' id='tipesoal_".$data['a']['id']."'>".$data['a']['tipeSoal']."</td>";
				$txtDataJobImplementation.="<td width='5%' id='bobot_".$data['a']['id']."'>".$data['a']['bobot']."</td>";
				$txtDataJobImplementation.="<td id='divisi_".$data['a']['id']."' style='display:none;'>".$data['a']['divisiId']."</td>";
				$txtDataJobImplementation.="<td id='jabatan_".$data['a']['id']."' style='display:none;'>".$data['a']['jabatanId']."</td>";
				$txtDataJobImplementation.="<td width='8%'  id='divisiNama_".$data['a']['id']."'>".$data['dv']['namaDivisi']."</td>";
				$txtDataJobImplementation.="<td width='8%'  id='jabatanNama_".$data['a']['id']."'>".$data['jab']['namaJabatan']."</td>";
				$txtDataJobImplementation.="<td width='16%' >
						<button type='button' class='btn btn-success btn-sm stsperiode' onclick='editsoal(".$data['a']['id'].")'><i class='fa fa-pencil fa-lg'  style='margin: 3px 1px;'></i></button>
						<button type='button' class='btn btn-danger btn-sm stsperiode' onclick='hapussoal(".$data['a']['id'].")'><i class='fa fa-trash-o fa-sm' style='margin: 3px 3px;'></i></button>
						<button type='button' class='btn btn-primary btn-sm stsperiode' onclick='gantikategorisoal(".$data['a']['id'].")'><i class='fa fa-share'  style='margin: 3px 2px;'></i></button>
						<button type='button' class='btn btn-info btn-sm stsperiode' onclick='copysoal(".$data['a']['id'].")'><i class='fa fa-files-o fa-sm' style='margin: 3px 1px;'></i></button>
						</td>";
				$txtDataJobImplementation.="";
				$txtDataJobImplementation.=" </tr>";
						
			   $no++;
			}
			$txtDataJobImplementation.="<tr><td colspan='7'><center></center></td></tr>";
		}
		// <div class="panel panel-default">
		// <div class="panel-body" style="height:500px;max-height: 500px;overflow-y:auto;">	
		// </div></div>
		$datatampil='<ul class="nav nav-tabs" id="navkategoris">
														'.$dashboardKategori1.'
														'.$dashboardKategori2.'
														'.$dashboardKategoriUnset.'
                            </ul>
							<div class="table-responsive">
							<table class="table table-bordered tableRecordSoal trhasildata trdata'.$replacekategoriAtt.'" style="margin-top: 20px">
                                <thead>
                                  <tr class="active">
                                    <th width="3%">No</th>
                                    <th width="30%">soal</th>
                                    <th width="15%">kategori</th>
                                    <th width="5%">tipe soal</th>
                                    <th width="5%">bobot</th>
                                    <th width="16%">aksi</th>
                                  </tr>
                                </thead>
                                <tbody id="tblperiode">
                                 '.$txtDataAttitude.'
                                </tbody>
                              </table>
                              <table class="table table-bordered tableRecordSoal trhasildata  trdata'.$replacekategoriJob.'" style="margin-top: 20px">
                                <thead>
                                  <tr class="active">
                                    <th width="3%">No</th>
                                    <th width="30%">soal</th>
                                    <th width="10%">peruntukan</th>
                                    <th width="15%">kategori</th>
                                    <th width="5%">tipe soal</th>
                                    <th width="5%">bobot</th>
									<th width="8%">divisi</th>
									<th width="8%">jabatan</th>
                                    <th width="16%">aksi</th>
                                  </tr>
                                </thead>
                                <tbody id="tblperiode">
                                 '.$txtDataJobImplementation.'
                                </tbody>
                              </table>
							  </div>
							 ';

        echo $datatampil."@@".$txtTabPertama;


		// <th width="5%">No</th>
		// <th width="40%">soal</th>
		// <th width="5%">peruntukan</th>
		// <th width="15%">kategori</th>
		// <th width="5%">tipe soal</th>
		// <th width="5%">bobot</th>
		// <th width="5%">divisi</th>
		// <th width="5%">jabatan</th>
		// <th width="15%">aksi</th>

	}


	public function getdata2(){
	
		//$this->loadModel('Group');
		$this->loadModel('Asset');
		$this->autoRender = false;
		
		$idUser=$this->Session->read('dpfdpl_userId');
	

		
      
        $hm=$_POST['hal'];
        $fungsi=$_POST['fungsi'];
       
        

        $limit=10;
        if(empty($hm)||$hm==1){$start=0;}else{$start=($hm-1)*$limit;}
		

		$sql="SELECT a.* FROM kpireg.pasoaluraians AS a WHERE a.statusSoal='true' order by a.tanggalInput";


		/*
					$sql="SELECT a.*,b.periodeStart as pstart, b.periodeEnd as pend FROM ppkbanksoals AS a JOIN ppkperiodepenilaians AS b ON a.periode=b.id WHERE statusSoal='true' and  a.soal!='0' order by a.tanggalInput,a.kategori";
		*/
        //var_dump($sql);exit();
        
        //var_dump($sql);exit();
        $querysql=$this->Asset->query($sql);
        //var_dump($querysql);exit();
        $jumQuery=count($querysql);
        $sum=ceil($jumQuery/$limit);
        /* -----------------------------Navigasi Record ala google style ----------------------------- */
        $linkHal=$this->pageNavMulti($hm,$sum,$limit,$fungsi);
        /* -----------------------------End Navigasi Record ala google style ----------------------------- */
        $rsTampil=$this->Asset->query($sql." limit $start, $limit");
        $n=$start+1;
        
        if($jumQuery==0 || $jumQuery==Null){
                
        $txtData=' <tr><td colspan="7"><center>Data masih kosong</center></td></tr>';
    

          }else{
          	$txtData="";
          	$no=1;
				foreach($rsTampil as $data){
					//var_dump();exit();

			    $soalsplit=explode("@@",$data['a']['pilihanSoal']);
			    $csoalsplit=count($soalsplit);
			    $isisoalsplit="";
			    for($x = 1; $x <= $csoalsplit-1; $x++){
			    	$isisoalsplit.="<br>".$x.". ".$soalsplit[$x];
			    }
			    $isisoalsplit=substr($isisoalsplit,4);
					
				$txtData.="<tr>";
				$txtData.="<td>".$no."</td>";
				//$txtData.="<td id='periode_".$data['a']['id']."'>".$data['b']['pstart']." sampai ".$data['b']['pend']."</td>";
				$txtData.="<td id='txtsoal_".$data['a']['id']."'>".$data['a']['soal']."
				<input type='hidden' id='xtxtid_".$data['a']['id']."' value='".$data['a']['id']."'>
				<input type='hidden' id='xtxtsoal_".$data['a']['id']."' value='".$data['a']['soal']."'>
				<input type='hidden' id='xtxtpilihansoal_".$data['a']['id']."' value='".$data['a']['pilihanSoal']."'></td>";
				$txtData.="<td id='txtpilihansoal_".$data['a']['id']."'>".$isisoalsplit."</td>";
				$txtData.="<td><button type='button' class='btn btn-success btn-sm stsperiode' onclick='editsoal2(".$data['a']['id'].")'><li class='material-icons' style='font-size:18px;color:white'>mode_edit</i></button><button type='button' class='btn btn-danger btn-sm stsperiode' onclick='hapussoal2(".$data['a']['id'].")'><li class='material-icons' style='font-size:18px;color:white;'>delete_sweep</i></button>

				</td>";
				$txtData.=" </tr>";
					
		
			   $no++;
			}
		}
		  echo $txtData."!".$linkHal;
	}
		public function updatedatauraian(){

		$this->loadModel('Asset');
		$this->autoRender = false;
		$idUser=$this->Session->read('dpfdpl_userId');
		$id=$_POST['id'];
		$soal=$_POST['soal'];
		$allsoal=$_POST['allsoal'];
				$sql="UPDATE kpireg.pasoaluraians SET soal='$soal', pilihanSoal='$allsoal' where id='$id'";
        $querysql=$this->Asset->query($sql);
        echo "berhasil merubah soal uraian";

	}


	public function getdatakategori(){
	
		//$this->loadModel('Group');
		$this->loadModel('Asset');
		$this->autoRender = false;
		
		$idUser=$this->Session->read('dpfdpl_userId');
	

		$sql="SELECT DISTINCT(kategori) AS dkategori,id ,tipeSoal,bobotTable FROM kpireg.pabanksoals AS a WHERE bobot IS NULL GROUP BY kategori ORDER BY FIELD(dkategori, 'Unset Kategori') DESC";

        $querysql=$this->Asset->query($sql);
      	$txtData="";
				foreach($querysql as $data){
					if($data['a']['dkategori']=="Unset Kategori"){
							$txtDataPlus="<td>-</td>";
					
					}else{
						$kategorix=$data['a']['dkategori'];
												$txtDataPlus="<td><button type='button' class='btn btn-success' onclick='editkategori(".$data['a']['id'].")'>Edit</button><button type='button' class='btn btn-Danger' onclick='hapuskategori(".$data['a']['id'].")'>Hapus</button></td>";

				
					
					}



					$txtData.="<tr>";
					$txtData.="<td> <input type='hidden' id='txtedtkategori_".$data['a']['id']."' value='".$data['a']['dkategori']."' >".$data['a']['dkategori']."</td>";
					$txtData.="<td> <input type='hidden' id='txtedtbobotkategori_".$data['a']['id']."' value='".$data['a']['bobotTable']."' >".$data['a']['bobotTable']."</td>";
					$txtData.=$txtDataPlus;
					$txtData.="</tr>";
		
					/*
				$txtData.="<td id='txtsoal_".$data['a']['id']."'>".$data['a']['soal']."
				<input type='hidden' id='xtxtid_".$data['a']['id']."' value='".$data['a']['id']."'>
				<input type='hidden' id='xtxtpilihansoal_".$data['a']['id']."' value='".$data['a']['pilihanSoal']."'></td>";
				$txtData.="<td id='txtpilihansoal_".$data['a']['id']."'>".$isisoalsplit."</td>";
				$txtData.="<td><button type='button' style='display: none' class='btn btn-success btn-sm stsperiode' onclick='editsoal2(".$data['a']['id'].")'>edit Soal</button><button type='button' class='btn btn-danger btn-sm stsperiode' onclick='hapussoal2(".$data['a']['id'].")'>hapus Soal</button></td>";
				$txtData.=" </tr>";
					*/

			
		}
		  echo $txtData;
	}

		public function statusperiode(){
		$this->loadModel('Asset');
		$this->autoRender = false;
		$sql="SELECT status FROM kpireg.paperiodepenilaians as a order by id desc limit 1";
		   $querysql=$this->Asset->query($sql);
		   $status="";
		   foreach($querysql as $data){
		   	$status=$data['a']['status'];
		   }
		   echo $status;
	}

	public function simpangantikategori(){
		$this->loadModel('Asset');
		$this->autoRender = false;
		$kategori=$_POST['kategori'];
		$id=$_POST['id'];
		$sql="UPDATE kpireg.pabanksoals SET kategori='$kategori' where id='$id'";
		$this->Asset->query($sql);
		 echo "berhasil mengganti kategori";
	}

	public function simpancopy(){
		$this->loadModel('Asset');
		$this->autoRender = false;
		$kategori=$_POST['kategori'];
		$id=$_POST['id'];
		$divisi=$_POST['txtdivisiCopy'];
		if(!empty($divisi) || $divisi!='0' ){
			$divisi=explode('~',$divisi);
			$divisiId=$divisi[1];
			$namaDivisi=$divisi[0];
		}
		$jabatan=$_POST['txtjabatanCopy'];
		if(!empty($jabatan) || $jabatan!='0' ){
			$jabatan=explode('~',$jabatan);
			$jabatanId=$jabatan[1];
			$namaJabatan=$jabatan[0];
		}
		//var_dump($_POST);exit();
		// $sql='INSERT INTO kpireg.pabanksoals(kategori, soal, bobot, tipeSoal, statusSoal, bobotTable) 
		// SELECT "'.$kategori.'", soal, bobot, tipeSoal, statusSoal, bobotTable FROM kpireg.pabanksoals WHERE id = "'.$id.'"';
		$sql="INSERT INTO kpireg.`pabanksoals`(`kategori`,`soal`,`bobot`,`tipeSoal`,`statusSoal`,`bobotTable`,`peruntukanSoal`,`divisiId`,`namaDivisi`,`jabatanId`,`namaJabatan`) 
		SELECT `kategori`,`soal`,`bobot`,`tipeSoal`,`statusSoal`,`bobotTable`,`peruntukanSoal`,'$divisiId' divisiId,'$namaDivisi' namaDivisi,'$jabatanId'  jabatanId, '$namaJabatan' namaJabatan FROM kpireg.`pabanksoals` WHERE id='".$id."'";
		$this->Asset->query($sql);
		 echo "berhasil menyalin soal";
	}


	public function updatekategori(){
		$this->loadModel('Asset');
		$this->autoRender = false;
		$kategori=$_POST['kategori'];
		$kategoriawal=$_POST['kategoriawal'];
		$bobot=$_POST['bobot'];
		$sql="UPDATE kpireg.pabanksoals SET kategori='$kategori', bobotTable='$bobot' where kategori='$kategoriawal'";
		   $querysql=$this->Asset->query($sql);

		   echo "berhasil update";
	}
	 
	public function savedata(){
		$this->autoRender = false;
		$this->loadModel('Asset');
		try{
			$dataSource = $this->Asset->getdatasource();
			$dataSource->begin();
			
			$idUser=$this->Session->read('dpfdpl_userId');


			//get variable
			//$periode=$_POST['periode'];
			//var_dump($_POST);exit();
			$kategori=$_POST['kategori'];
			$bobot=$_POST['bobot'];
			$soal=$_POST['soal'];
			$soalumumkhusus=$_POST['soalumumkhusus'];
			$bobottable=$_POST['bobottable'];
			//$tahun = explode('-', $tglstart);
			$tanggalinput=date("Y-m-d");
			$peruntukansoal=$_POST['peruntukansoal'];
			//tambahan divisi dan jabatan
			$divisi=$_POST['divisi'];
			if($kategori=='Sikap (Attitude)'){
				$divisiId="";
				$namaDivisi="";
				$jabatanId="";
				$namaJabatan="";
			}else{
				if(!empty($divisi) || $divisi!='0' ){
					$divisi=explode('~',$divisi);
					$divisiId=$divisi[1];
					$namaDivisi=$divisi[0];
				}
				$jabatan=$_POST['jabatan'];
				if(!empty($jabatan) || $jabatan!='0' ){
					$jabatan=explode('~',$jabatan);
					$jabatanId=$jabatan[1];
					$namaJabatan=$jabatan[0];
				}
			}
			
		
			$queryInsert="INSERT INTO kpireg.pabanksoals (soal,kategori,bobot,tipeSoal,bobotTable,peruntukanSoal,divisiId,namaDivisi,jabatanId,namaJabatan)VALUES('$soal','$kategori','$bobot','$soalumumkhusus','$bobottable','$peruntukansoal','$divisiId','$namaDivisi','$jabatanId','$namaJabatan')";

			//echo $queryInsert;exit();

			$this->Asset->query($queryInsert);

			$dataSource->commit();
			echo "berhasil input soal";
		}catch(Exception $e){
			var_dump($e->getTrace());
			$dataSource->rollback();
		}
	}

	public function updatesoal(){
		$this->autoRender = false;
		$this->loadModel('Asset');
		try{
			$dataSource = $this->Asset->getdatasource();
			$dataSource->begin();
			
			$idUser=$this->Session->read('dpfdpl_userId');


			//get variable
			
			$id=$_POST['id'];
			$bobot=$_POST['bobot'];
			if(empty($bobot)){
				$bobot='(NULL)';
			}
			$soal=$_POST['soal'];
			
			
			if($_POST['kategoriSoal']=='Sikap (Attitude)'){
				$divisiId		="";
				$namaDivisi		="";
				$jabatanId		="";
				$namaJabatan	="";
				$peruntukansoal	="";
			}else{
				$peruntukansoal=$_POST['peruntukansoal'];
				$txtdivisiEdit=$_POST['txtdivisiEdit'];
				if(!empty($txtdivisiEdit) || $txtdivisiEdit!='0' ){
					$divisi			=explode('~',$txtdivisiEdit);
					$divisiId		=$divisi[1];
					$namaDivisi		=$divisi[0];
				}
				$txtjabatanEdit=$_POST['txtjabatanEdit'];
				if(!empty($txtjabatanEdit) || $txtjabatanEdit!='0' ){
					$jabatan		=explode('~',$txtjabatanEdit);
					$jabatanId		=$jabatan[1];
					$namaJabatan	=$jabatan[0];
					
				}
			}
			
			$typeSoal=$_POST['typeSoal'];

			//$tahun = explode('-', $tglstart);

		


			$queryupdate="UPDATE kpireg.pabanksoals SET soal='$soal',
			bobot=$bobot,
			peruntukanSoal='$peruntukansoal',
			divisiId='$divisiId',
			namaDivisi='$namaDivisi', 
			jabatanId='$jabatanId',
			namaJabatan='$namaJabatan',
			tipeSoal='$typeSoal'
			WHERE id='$id'";

			//echo $queryInsert;exit();

			$this->Asset->query($queryupdate);

			$dataSource->commit();
			echo "berhasil update data";
		}catch(Exception $e){
			var_dump($e->getTrace());
			$dataSource->rollback();
		}
	}


	public function savedatauraian(){
		$this->autoRender = false;
		$this->loadModel('Asset');
		try{
			$dataSource = $this->Asset->getdatasource();
			$dataSource->begin();
			
			$idUser=$this->Session->read('dpfdpl_userId');


			//get variable
			$soal=$_POST['soal'];
			$allsoal=$_POST['allsoal'];
			$tanggalinput=date("Y-m-d");

			$queryInsert="INSERT INTO kpireg.pasoaluraians(soal,pilihanSoal,tanggalInput,statusSoal) VALUES('$soal','$allsoal','$tanggalinput','true')";

			//echo $queryInsert;exit();

			$this->Asset->query($queryInsert);

			$dataSource->commit();
			echo "berhasil insert data";
		}catch(Exception $e){
			var_dump($e->getTrace());
			$dataSource->rollback();
		}
	}


	public function savekategori(){
		$this->autoRender = false;
		$this->loadModel('Asset');
		try{
			$dataSource = $this->Asset->getdatasource();
			$dataSource->begin();
			
			$idUser=$this->Session->read('dpfdpl_userId');

			//get variable
			$kategori=$_POST['kategori'];
			$tipesoal=$_POST['tipesoal'];
			$bobot=$_POST['bobot'];
			//$tahun = explode('-', $tglstart);

			if($kategori=="" or $bobot==""){
				return "harap melengkapi kolom inputan";
			}
		


			$queryInsert="INSERT INTO kpireg.pabanksoals (kategori,tipeSoal,statusSoal,bobotTable)VALUES('$kategori','$tipesoal','0','$bobot')";

			//echo $queryInsert;exit();

			$this->Asset->query($queryInsert);

			$dataSource->commit();
			echo "berhasil menambahkan kategori";
		}catch(Exception $e){
			var_dump($e->getTrace());
			$dataSource->rollback();
		}
	}


		

	public function hapussoal(){
		$this->autoRender = false;
		$this->loadModel('Asset');
		try{
			$dataSource = $this->Asset->getdatasource();
			$dataSource->begin();
			
			$idUser=$this->Session->read('dpfdpl_userId');


			//get variable
			$id=$_POST['id'];


			//$queryupdate="DELETE FROM dpfdplnew.banksoals WHERE id='$id'";
			$queryupdate="DELETE FROM  kpireg.pabanksoals WHERE id='$id'";

			//echo $queryInsert;exit();

			$this->Asset->query($queryupdate);

			$dataSource->commit();
			echo "berhasil menghapus soal";
		}catch(Exception $e){
			var_dump($e->getTrace());
			$dataSource->rollback();
		}
	}


		public function cekhapuskategori(){
		$this->autoRender = false;
		$this->loadModel('Asset');

			
			$idUser=$this->Session->read('dpfdpl_userId');


			//get variable
			$id=$_POST['id'];


			$kategori="";
			$sql="SELECT kategori FROM kpireg.pabanksoals AS a WHERE id='$id' ";
			$querysql=$this->Asset->query($sql);

				foreach($querysql as $data){
						$kategori=$data["a"]["kategori"];
				}


			$sql2="SELECT count(kategori) as ckategori FROM kpireg.pabanksoals AS a WHERE kategori='$kategori' ";
			$querysql2=$this->Asset->query($sql2);
				$ckategori=0;
				foreach($querysql2 as $data2){
						$ckategori=$data2[0]["ckategori"];
				}

				if($ckategori>1){
						echo "unset@@".$kategori;
				}else{
			$sql3="DELETE FROM kpireg.pabanksoals WHERE id='$id' ";
			$querysql3=$this->Asset->query($sql3);

					echo "terhapus";
				}



			

}



		public function hapuskategori(){
		$this->autoRender = false;
		$this->loadModel('Asset');

			
			$idUser=$this->Session->read('dpfdpl_userId');


			//get variable
			$kategori=$_POST['kategori'];

			$sql="UPDATE kpireg.pabanksoals SET kategori='Unset Kategori' WHERE kategori='$kategori' and soal is not NULL";
			$querysql=$this->Asset->query($sql);

			$sql2="DELETE FROM kpireg.pabanksoals WHERE kategori='$kategori'";
			$querysql2=$this->Asset->query($sql2);

					echo "terhapus";
			

			

}



		public function hapussoal2(){
		$this->autoRender = false;
		$this->loadModel('Asset');
		try{
			$dataSource = $this->Asset->getdatasource();
			$dataSource->begin();
			
			$idUser=$this->Session->read('dpfdpl_userId');


			//get variable
			$id=$_POST['id'];


			//$queryupdate="DELETE FROM dpfdplnew.banksoals WHERE id='$id'";
			//$queryupdate="UPDATE dpfdplnew.ppksoaluraians SET statusSoal='false' WHERE id='$id'";
			$queryupdate="DELETE FROM kpireg.pasoaluraians WHERE id='$id'";
			//echo $queryInsert;exit();

			$this->Asset->query($queryupdate);

			$dataSource->commit();
			echo "berhasil menghapus soal";
		}catch(Exception $e){
			var_dump($e->getTrace());
			$dataSource->rollback();
		}
	}



  public function getkategori(){
    $this->autoRender = false;
    $this->loadModel('Asset');
    

    $hasil1=$this->Asset->query("SELECT DISTINCT(kategori) AS dkategori,tipeSoal,bobotTable FROM kpireg.pabanksoals AS a WHERE bobot IS NULL GROUP BY kategori");
    $txtdata=[];
    $txtdata[]=array('label'=>'-Please Select-','value'=>'^');
    foreach($hasil1 as $hsl){ 
      $txtdata[]= array('label'=>$hsl["a"]["dkategori"],'value'=>$hsl["a"]["dkategori"]."^".$hsl["a"]["tipeSoal"]."^".$hsl["a"]["bobotTable"]);
      } 

    echo json_encode($txtdata);
  }

  /*
   public function getperiode(){
    $this->autoRender = false;
    $this->loadModel('User');
    

    $hasil1=$this->User->query("SELECT id,periodeStart,periodeEnd from ppkperiodepenilaians where status='aktif' ");
   
    foreach($hasil1 as $hsl){ 
      $txtdata=$hsl["ppkperiodepenilaians"]["id"]."^".$hsl["ppkperiodepenilaians"]["periodeStart"]." sampai ".$hsl["ppkperiodepenilaians"]["periodeEnd"];
      } 

	    echo $txtdata;
	}
	*/
/*

    public function getperiode(){
    $this->autoRender = false;
    $this->loadModel('User');
    

    $hasil1=$this->User->query("SELECT id,periodeStart,periodeEnd from periodepenilaians where order by periodeStart asc ");
    $txtdata=[];
    $txtdata[]=array('label'=>'-Please Select-','value'=>'^');
    foreach($hasil1 as $hsl){ 
      $txtdata[]= array('label'=>$hsl["periodepenilaians"]["periodeStart"]."-".$hsl["periodepenilaians"]["dkategori"],'value'=>$hsl["periodepenilaians"]["periodeStart"]."^".$hsl["periodepenilaians"]["dkategori"]);
      } 

    echo json_encode($txtdata);
  }
	*/

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