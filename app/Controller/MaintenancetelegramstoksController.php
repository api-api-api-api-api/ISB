<?php
App::uses('AppController','Controller');

class MaintenancetelegramstoksController extends AppController{
	public $components = array('Function','Paginator');

	public function index(){
		echo $this->Function->cekSession($this);
	}
	function selectDivisi(){
        $this->autoRender = false;
        $this->loadModel('User');  
        $divisi=["MKT1","MKT2","MKT3","MKT4","MKT5"];
        //$hasil=$this->User->query("SELECT id,nama_divisi FROM dpfdplnew.divisis ORDER BY nama_divisi");
        
        $txtdata=[];
        for ($i=0;$i<count($divisi);$i++){
        	$txtdata[]= array('label'=>$divisi[$i],'value'=>$divisi[$i]);
        }
        echo json_encode($txtdata);
    }
    //fungsi tampil data
    function getData(){
        $this->autoRender = false;
        $this->loadModel('User');

		//var_dump($_POST);exit();
        $idUser=$this->Session->read('dpfdpl_userId');
        $userNama=$this->Session->read('dpfdpl_namaUser');
        //variable tampung
        $txtData="";
        //paging
        $hm=$_POST['hal'];
        $fungsi="getData";
        $limit=10;
        //filter
        $filterNama=$_POST['filterNama'];
        $filterDepartemen=$_POST['filterDepartemen'];
        $filterTeleID=$_POST['filterTeleID'];
        $filterStatus=$_POST['filterStatus'];

       
        //var_dump($filterStatus);EXIT();

        //cek halaman
        if(empty($hm)||$hm==1){
            $start=0; 
        }else{ 
            $start=($hm-1)*$limit; 
        }
        
        
        //start query
        $this->User->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'");   

        //$query="SELECT a.generateID,a.noFUPB,a.nd,a.tb,a.prodName,a.divID,a.divName,a.tanggalFUPB,a.komposisi,a.dosis,a.indikasi,
        //a.aturanPakai,a.sediaan,a.kemasan,a.jumlahKompetitor,a.jalurRegistrasi,a.statusKebutuhanMarketing,a.idPengaju,a.namaPengaju,a.statusFUPB FROM dpfdplnew.fupbs a GROUP BY a.generateID";
        $query="SELECT * FROM telegramstoks tele  WHERE
        tele.nama like '%$filterNama%' 
        AND tele.departemen like '%$filterDepartemen%' 
        AND tele.idTelegram like '%$filterTeleID%' 
        AND tele.isaktif like '%$filterStatus%' 
        ORDER BY tele.nama ASC";
        //WHERE a.prodName LIKE '%$namaProjectSrc%' AND a.noFUPB like '%$noFupbSrc%' $filterDate  AND a.idPengaju='$idUser'
        
         
	   
        $qsql=$this->User->query($query);
        $jumQuery=count($qsql);
        
        $sum=ceil($jumQuery/$limit);
       
        /* -----------------------------Navigasi Record ala google style ----------------------------- */
        $linkHal=$this->pageNavMulti($hm,$sum,$limit,$fungsi);
        /* -----------------------------End Navigasi Record ala google style ----------------------------- */
        $Qtampil=$this->User->query($query." limit $start, $limit");
        //var_dump($query." limit $start, $limit");exit();

        $no=$start+1;
        if($jumQuery==0 || $jumQuery==Null){
            $txtData="
            <tr>
            <td colspan=\"9\" style=\"text-align:center;\">--Empty Data--</td>
            </tr>";
            return $txtData."^";
        }



        foreach($Qtampil as $dataRow){

           	$id 		= $dataRow['tele']['id'];
           	$nama 		= $dataRow['tele']['nama'];
           	$departemen	= $dataRow['tele']['departemen'];
           	$idTelegram = $dataRow['tele']['idTelegram'];
           	$isaktif	= $dataRow['tele']['isaktif'];    
           	 //var_dump($nama);exit();           
            if($isaktif=='true'){$aktif='aktif';}else{$aktif='tidak aktif';}

            $txtData.="<tr>
                            <td style='text-align:center;vertical-align: middle;'>".$no."</td>
                            <td style='vertical-align: middle;'>".$nama."</td>
                            <td style='text-align:center;vertical-align: middle;'>".$departemen."</td>
                            <td style='text-align:center;vertical-align: middle;'>".$idTelegram."</td>
                            <td style='text-align:center;vertical-align: middle;'>".$aktif."</td>
                            <td style='vertical-align: middle;text-align:center;'>
                            	<input type='hidden' name='edtNama' id='edtNama".$id."' value='".$nama."'>
	                            <input type='hidden' name='edtDepartemen' id='edtDepartemen".$id."' value='".$departemen."'>
	                            <input type='hidden' name='edtIdTelegram' id='edtIdTelegram".$id."' value='".$idTelegram."'>
	                            <input type='hidden' name='edtIsAktif' id='edtIsAktif".$id."' value='".$isaktif."'>
	                            <button type='button' class='btn btn-danger btn-sm btnEdit'>Ubah</button>
	                            <button type='button' class='btn btn-danger btn-sm btnDel'>Hapus</button>
	                            <input type='hidden' name='id' id='edtName".$id."' value='".$id."'>
                            </td>                          
                        </tr>";
            $txtData=$txtData."";
            $no++;
        }

        return $txtData."^".$linkHal;
        
    }

    //fungsi CRUD
    public function crud(){
		$this->autoRender=false;
		$this->loadModel('User');
		//filter crud
		  try{ 

		  	$sukses='';
            $hm='';
            $limit=10;

            $dataSource = $this->User->getdatasource();
            $dataSource->begin();
            //var_dump($_POST);exit();
            $crud=$_POST['crud'];
            $nama=$_POST['nama'];
            $divisiDipilih=$_POST['divisiDipilih'];
            $telegramID=$_POST['telegramID'];
            $check=$_POST['check'];
            $dateTime=date("Y-m-d h:i:s");

            //user akses
            $idUserInput=$this->Session->read('dpfdpl_userId');
            $userInputNama=$this->Session->read('dpfdpl_namaUser');
           
            //var_dump($dateTime);exit();
            if($crud=='add'){
            	$QueryCRUD="INSERT INTO telegramstoks (nama,departemen,idtelegram,isaktif) VALUES ('$nama','$divisiDipilih','$telegramID','$check')";
            	$this->User->query($QueryCRUD);
            	//get id kendaraan new input
            	$idtelegramstok=$this->User->query("SELECT id FROM telegramstoks ORDER BY Id DESC LIMIT 1");
            	$idtelegramstok=$idtelegramstok[0]['telegramstoks']['id'];
            	
            	//var_dump($idKendaraan);exit();
            	//simpan history crud
            	$HistoryCRUDInput="INSERT INTO historytelegramstoks (idTelegramstok,keteranganAkses,dateAkses,idUser,userAksesNama)VALUES('$idtelegramstok','ADD','$dateTime','$idUserInput','$userInputNama')";
            	$this->User->query($HistoryCRUDInput);

            	$sukses='sukses';
            	$recordid=0;
                $id=$idtelegramstok;
                $query=$this->User->query("SELECT * FROM  telegramstoks m  ORDER BY m.nama");
                foreach($query as $rowid){
                    $recordid ++;
                    if($rowid['m']['id']==$id){
                        break;
                    }
                }
                $hm=ceil($recordid/$limit); 

	        }else{
	        //var_dump($_POST);exit();
			$idtelegramstok=$_POST['idTelegramStok'];

			//var_dump($_POST);exit();
			$Update="UPDATE telegramstoks  SET nama='$nama',
						departemen='$divisiDipilih',
						idtelegram='$telegramID',
						isaktif='$check'
						WHERE id='$idtelegramstok'";
	                //var_dump($Update);exit();
	            $this->User->query($Update);
	            //simpan history crud
                $HistoryCRUDEdit="INSERT INTO historytelegramstoks (idTelegramstok,keteranganAkses,dateAkses,idUser,userAksesNama)VALUES('$idtelegramstok','EDIT','$dateTime','$idUserInput','$userInputNama')";
                $this->User->query($HistoryCRUDEdit);
                $sukses='sukses';
                $recordid=0;
                $query=$this->User->query("SELECT * FROM telegramstoks m  ORDER BY m.nama ");
                foreach($query as $rowid){
                    $recordid ++;
                    if($rowid['m']['id']==$idtelegramstok){
                        break;
                    }
                }
                $hm=ceil($recordid/$limit); 
        	}
            
            //var_dump($_POST);exit();
            echo $hm."~".$sukses;
            //echo "sukses";
            $dataSource->commit();	
        }
        catch(Exception $e){
            var_dump($e->getTrace());
                $dataSource->rollback();
        }
	}
	 public function hapus(){
        $this->autoRender = false;
        $this->loadModel('User');
  
        try{
            $dataSource = $this->User->getdatasource();
            $dataSource->begin();
            //set variable-variable 
            $idUserInput=$this->Session->read('dpfdpl_userId');
            $userInputNama=$this->Session->read('dpfdpl_namaUser');
            $dateTime=date("Y-m-d h:i:s");
            $hm='';
            $limit=10;
                $recordid=0;
                $id=$_POST['id'];

                $query=$this->User->query("SELECT * FROM telegramstoks t  ORDER BY t.nama");

                foreach($query as $rowid){
                    $recordid ++;
                    if($rowid['t']['id']==$id){
                        break;
                    }
                }
                //var_dump($recordid);exit();

                $sum1=ceil($recordid/$limit); 
                //echo $sum1;exit();
                $this->User->query("DELETE	FROM telegramstoks WHERE id='$id'");
				$HistoryCRUDDEL="INSERT INTO historytelegramstoks (idTelegramstok,keteranganAkses,dateAkses,idUser,userAksesNama)VALUES('$id','DELETE','$dateTime','$idUserInput','$userInputNama')";
                $this->User->query($HistoryCRUDDEL);

                $query2=$this->User->query("SELECT * FROM telegramstoks t  ORDER BY t.nama");
                $jumQuery2=count($query2);
                $sum2=ceil($jumQuery2/$limit);
                
                if($sum2>$sum1){
                    $hm=$sum1;
                }else{
                    $hm=$sum2;
                }
                
                echo $hm;


            $dataSource->commit();	
        }
        catch(Exception $e){
            var_dump($e->getTrace());
            $dataSource->rollback();
        }
    }

    function qrcode(){
        
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
            } else {
                $linkHal=$linkHal." <li class='page-item'><a class='page-link'>Next</a></li><li class='page-item'><a class='page-link'>Last</a></li></ul>";
              	}
            }
        return $linkHal;
    }
}