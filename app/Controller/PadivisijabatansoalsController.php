<?php
App::uses('AppController', 'Controller');
/**
 *  Controller Linkperuntukan soal
 *  referent DB kpireg
 */
class  PadivisijabatansoalsController extends AppController {
    public $components = array('Function','Paginator'); 
    public function index(){
        echo $this->Function->cekSession($this);
    }

    // scoup divisi
    public function getDataDivisi(){
        $this->autoRender = false;
        $this->loadModel('Asset');

        //filter

        $txtSrcDivisi=$_POST['txtSrcDivisi'];

        $hm=$_POST['hal'];
        $fungsi=$_POST['fungsi'];
       
        
        
        $txtData='';
        $limit=10;
        if(empty($hm)||$hm==1){$start=0;}else{$start=($hm-1)*$limit;}

        $sql="SELECT * FROM kpireg.`padivisisoals` WHERE namaDivisi like '%$txtSrcDivisi%'  ORDER BY namaDivisi";
        
        $querysql=$this->Asset->query($sql);
        $jumQuery=count($querysql);
        $sum=ceil($jumQuery/$limit);
        //var_dump($sum);exit();

         /* -----------------------------Navigasi Record ala google style ----------------------------- */
         $linkHal=$this->pageNavMulti($hm,$sum,$limit,$fungsi);
         /* -----------------------------End Navigasi Record ala google style ----------------------------- */
         $rsTampil=$this->Asset->query($sql." limit $start, $limit");
         $n=$start+1;
         
         if($jumQuery==0 || $jumQuery==Null){
         
           $txtData.="
               <tr>
                    <td colspan=3 style='text-align:center;'>Kosong</td>
               </tr>";
           }else{
                foreach($rsTampil as $data){
                    $id=$data['padivisisoals']['id'];
                    
                    $txtData.="<tr class='tab'>
                        <td style='vertical-align:middle;text-align:center' id='id".$n."' align='center'>".$n.".</td>
                        <td id='id".$id."' align='center' style='display:none'>".$id."<input type='text' name='txtid' id='txtid".$id."' value='".$id."'></td>
                        <td style='vertical-align:middle;text-align:left;' id='txtNamaDivisi".$id."' >
                            <label id='lblDiv".$id."' style='margin-bottom:unset;font-weight:unset;'>".$data['padivisisoals']['namaDivisi']."</label> 
                            <input type='text' class='form-control' name='idNamaDivisi' id='idNamaDivisi".$id."' value='".$data['padivisisoals']['namaDivisi']."' style='display:none;font-size:12px;'>
                        </td>
                        <td style= id='txtBtn".$id."' align='center'>
                            <div class='' id='btnDivEdit".$id."'>
                                <button id='btnDivEditTag".$id."'type='button' class='btn btn-default btn-xs editTagDiv'><i class='fa fa-pencil fa-lg'  style='margin: 5px 5px;'></i> </button>
                                <button id='btnDivHapusTag".$id."'type='button' class='btn btn-default btn-xs hapusTagDiv'><i class='fa fa-trash-o fa-lg'  style='margin: 5px 5px;'></i> </button>
                            </div>
                            <div class='' id='btnDiv".$id."' style='display:none'>
                                <button id='btnDivSimpanTag".$id."' type='button' class='btn btn-default btn-xs simpanTagDiv'><i class='fa fa-floppy-o fa-lg'  style='margin: 5px 5px;'></i> </button>
                                <button id='btnDivBatalTag".$id."' type='button' class='btn btn-default btn-xs batalTagDiv'><i class='fa fa-ban fa-lg'  style='margin: 5px 5px;'></i> </button>
                            </div>
                        </td>
                        <td style='display:none'>".$id."</td>
                    </tr>";
                    $n++;
                }
                
           }
           echo $txtData."^".$linkHal;
    }
    function simpan(){
        $this->autoRender = false;
        $this->loadModel('User');
        $this->loadModel('Asset');
        $this->Asset->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'");
        try{
            $dataSource = $this->Asset->getdatasource();
            $dataSource->begin();
            date_default_timezone_set("Asia/Jakarta");
            $hm='';
            $limit=10;
            $CRUD=$_POST['CRUD'];
            if($CRUD=='create'){
                $namaDivisi=strtoupper($_POST['namaDivisi']);
                $sql="INSERT INTO kpireg.`padivisisoals` (namaDivisi)VALUES('$namaDivisi')";
                $this->Asset->query($sql);


                //get hm
                $querygetId=$this->Asset->query("SELECT m.id FROM kpireg.`padivisisoals`  m  ORDER BY m.id DESC limit 1");
                $recordid=0;
                $id=$querygetId[0]['m']['id'];
                $query=$this->Asset->query("SELECT * FROM  kpireg.`padivisisoals`  m  ORDER BY m.namaDivisi");
                foreach($query as $rowid){
                    $recordid ++;
                    if($rowid['m']['id']==$id){
                        break;
                    }
                }
                $hm=ceil($recordid/$limit); 
            }elseif($CRUD=='update'){
                //var_dump($_POST);exit();
                $id=$_POST['id'];
                $namaDivisi=strtoupper($_POST['namaDivisi']);           
                $sql="UPDATE  kpireg.`padivisisoals` SET namaDivisi='$namaDivisi' WHERE id = '$id'";

                 $this->Asset->query($sql);
            }
            //$idPeriode=$_POST['isiPeriode'];
            
            echo "sukses".$hm;
            $dataSource->commit(); 
        }
        catch(Exception $e){
            var_dump($e->getTrace());
                $dataSource->rollback();
        }

    }
    
    public function deleteDivisi(){
        $this->autoRender = false;
        $this->loadModel('Asset');
  
        try{
            $dataSource = $this->Asset->getdatasource();
            $dataSource->begin();
            //set variable-variable 
            $hm='';
            $limit=10;
                $recordid=0;
                $id=$_POST['id'];

                //var_dump($_POST);exit();
                $query=$this->Asset->query("SELECT * FROM kpireg.`padivisisoals` m  ORDER BY m.namaDivisi");
                foreach($query as $rowid){
                    $recordid ++;
                    if($rowid['m']['id']==$id){
                        break;
                    }
                }
                $sum1=ceil($recordid/$limit); 
                //echo $sum1;exit();
                //cek divisi dan jabatan sudah digunakan atau belum;
                $cekDivisi=$this->Asset->query("SELECT * FROM kpireg.`pabanksoals` bs WHERE bs.`divisiId`='$id'");
                if(count($cekDivisi)>0){
                    echo "ada";
                    return;
                }

                //var_dump(count($cekDivisi));exit();

                $this->Asset->query("DELETE	FROM kpireg.`padivisisoals` WHERE id='$id'");
                $this->Asset->query("DELETE	FROM kpireg.`pajabatansoals` WHERE divisiId='$id'");

                $query2=$this->Asset->query("SELECT * FROM kpireg.`padivisisoals` m  ORDER BY m.namaDivisi");
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

    //end scoup divisi

    //scoup jabatan
    public function deleteJabatan(){
        $this->autoRender = false;
        $this->loadModel('Asset');
  
        try{
            $dataSource = $this->Asset->getdatasource();
            $dataSource->begin();
            //set variable-variable 
            $hm='';
            $limit=10;
                $recordid=0;
                $id=$_POST['id'];
                $txtDivisiId=$_POST['txtDivisiId'];
                //var_dump($_POST);exit();
                $query=$this->Asset->query("SELECT * FROM kpireg.`pajabatansoals` m  WHERE m.divisiId='$txtDivisiId' ORDER BY m.namaJabatan");
                foreach($query as $rowid){
                    $recordid ++;
                    if($rowid['m']['id']==$id){
                        break;
                    }
                }
                $sum1=ceil($recordid/$limit); 
                 //cek divisi dan jabatan sudah digunakan atau belum;
                $cekDivisi=$this->Asset->query("SELECT * FROM kpireg.`pabanksoals` bs  WHERE bs.`jabatanId`='$id'");
                if(count($cekDivisi)>0){
                    echo "ada";
                    return;
                }
                //echo $sum1;exit();
                $this->Asset->query("DELETE	FROM kpireg.`pajabatansoals` WHERE id='$id'");

                $query2=$this->Asset->query("SELECT * FROM kpireg.`pajabatansoals` m   WHERE m.divisiId='$txtDivisiId' ORDER BY m.namaJabatan");
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
    function simpanJabatan(){
        $this->autoRender = false;
        $this->loadModel('User');
        $this->loadModel('Asset');
        $this->Asset->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'");
        try{
            $dataSource = $this->Asset->getdatasource();
            $dataSource->begin();
            date_default_timezone_set("Asia/Jakarta");
            $hm='';
            $limit=10;
            $CRUD=$_POST['CRUD'];
            if($CRUD=='create'){
                $txtDivisiId=$_POST['txtDivisiId'];
                $namaJabatan=strtoupper($_POST['namaJabatan']);
                $sql="INSERT INTO kpireg.`pajabatansoals` (divisiId,namaJabatan)VALUES('$txtDivisiId','$namaJabatan')";
                $this->Asset->query($sql);


                //get hm
                $querygetId=$this->Asset->query("SELECT m.id FROM kpireg.`pajabatansoals`  m WHERE m.`divisiId`='$txtDivisiId'  ORDER BY m.id DESC limit 1");
                $recordid=0;
                $id=$querygetId[0]['m']['id'];
                $query=$this->Asset->query("SELECT * FROM  kpireg.`pajabatansoals`  m  WHERE m.`divisiId`='$txtDivisiId'  ORDER BY m.namaJabatan");
                foreach($query as $rowid){
                    $recordid ++;
                    if($rowid['m']['id']==$id){
                        break;
                    }
                }
                $hm=ceil($recordid/$limit); 
            }elseif($CRUD=='update'){
                //var_dump($_POST);exit();
                $id=$_POST['id'];
                $namaJabatan=strtoupper($_POST['namaJabatan']);           
                $sql="UPDATE  kpireg.`pajabatansoals` SET namaJabatan='$namaJabatan' WHERE id = '$id'";

                 $this->Asset->query($sql);
            }
            //$idPeriode=$_POST['isiPeriode'];
            
            echo "sukses".$hm;
            $dataSource->commit(); 
        }
        catch(Exception $e){
            var_dump($e->getTrace());
                $dataSource->rollback();
        }

    }
    

    public function getDataJabatan(){
        $this->autoRender = false;
        $this->loadModel('Asset');

        //filter

        $txtDivisiId=$_POST['txtDivisiId'];

        $hm=$_POST['hal'];
        $fungsi=$_POST['fungsi'];
       
        
        
        $txtData='';
        $limit=10;
        if(empty($hm)||$hm==1){$start=0;}else{$start=($hm-1)*$limit;}

        $sql="SELECT * FROM kpireg.`pajabatansoals` WHERE divisiId='$txtDivisiId' ORDER BY namaJabatan";
        
        $querysql=$this->Asset->query($sql);
        $jumQuery=count($querysql);
        $sum=ceil($jumQuery/$limit);
        //var_dump($sum);exit();

         /* -----------------------------Navigasi Record ala google style ----------------------------- */
         $linkHal=$this->pageNavMulti($hm,$sum,$limit,$fungsi);
         /* -----------------------------End Navigasi Record ala google style ----------------------------- */
         $rsTampil=$this->Asset->query($sql." limit $start, $limit");
         $n=$start+1;
         
         if($jumQuery==0 || $jumQuery==Null){
         
           $txtData.="
               <tr>
                    <td colspan=3 style='text-align:center;'>Kosong</td>
               </tr>";
           }else{
                foreach($rsTampil as $data){
                    $id=$data['pajabatansoals']['id'];
                    
                    $txtData.="<tr>
                        <td style='vertical-align:middle;text-align:center' id='id".$n."' align='center'>".$n.".</td>
                        <td id='id".$id."' align='center' style='display:none'>".$id."<input type='text' name='txtid' id='txtid".$id."' value='".$id."'></td>
                        <td style='vertical-align:middle;text-align:left;' id='txtNamaJabatan".$id."' >
                            <label id='lblJab".$id."' style='margin-bottom:unset;font-weight:unset;'>".$data['pajabatansoals']['namaJabatan']."</label> 
                            <input type='text' class='form-control' name='idNamaJabatan' id='idNamaJabatan".$id."' value='".$data['pajabatansoals']['namaJabatan']."' style='display:none;font-size:12px;'>
                        </td>
                        <td style= id='txtBtn".$id."' align='center'>
                            <div class='' id='btnJabEdit".$id."'>
                                <button id='btnJabEditTag".$id."'type='button' class='btn btn-default btn-xs editTagJab'><i class='fa fa-pencil fa-lg'  style='margin: 5px 5px;'></i> </button>
                                <button id='btnJabHapusTag".$id."'type='button' class='btn btn-default btn-xs hapusTagJab'><i class='fa fa-trash-o fa-lg'  style='margin: 5px 5px;'></i> </button>
                            </div>
                            <div class='' id='btnJab".$id."' style='display:none'>
                                <button id='btnJabSimpanTag".$id."' type='button' class='btn btn-default btn-xs simpanTagJab'><i class='fa fa-floppy-o fa-lg'  style='margin: 5px 5px;'></i> </button>
                                <button id='btnJabBatalTag".$id."' type='button' class='btn btn-default btn-xs batalTagJab'><i class='fa fa-ban fa-lg'  style='margin: 5px 5px;'></i> </button>
                            </div>
                        </td>
                        <td style='display:none'>".$id."</td>
                    </tr>";
                    $n++;
                }
                
           }
           echo $txtData."^".$linkHal;
    }
    //end scoup jabatan
    
    //pagination
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