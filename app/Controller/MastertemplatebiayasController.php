<?php
App::uses("AppController","Controller");
class MastertemplatebiayasController extends AppController{
    public $components = array('Function','Paginator');
    function index()
    {
        echo $this->Function->cekSession($this);
    }
    
    function getDivisi(){
        $this->autoRender=false;
        $this->loadModel('User');
        
            if(empty($_POST)){
                $setDivisiId="";
            }else{
                $setDivisiId=$_POST['divisiId'];
            }
            //echo "a";exit();
       
            
        //var_dump(isset($_POST));exit();
        $selected='';
        
        $queryDiv="SELECT * FROM definance.karyawans d WHERE d.nik like '%DIV%'"; 
        //GROUP BY d.id ASC";
        
        $queryData=$this->User->query($queryDiv);
        
        //var_dump($queryData);exit();
        $txtDivisi="";
        foreach($queryData as $dataDivisis){
            $divisiID=$dataDivisis['d']['nik'];
            if($setDivisiId===$divisiID){
				$selected='selected';
			}else{$selected='';}
            $txtDivisi.="<option value='".$dataDivisis["d"]["nik"]."' $selected>".$dataDivisis["d"]["namaKaryawan"]."</option>";	
        }
        return $txtDivisi;
    }

    function getData(){
        $this->autoRender=false;
        $this->loadModel('User');
        $hm=$_POST['hal'];
		$fungsi=$_POST['fungsi'];


		$txtData='';
		$limit=10;
		if(empty($hm)||$hm==1){$start=0;}else{$start=($hm-1)*$limit;}
		
		$sql="SELECT namaTemplate FROM definance.templatebiayalpus GROUP BY namaTemplate ASC";
		$querysql=$this->User->query($sql);
        //var_dump($querysql);exit();
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
				 <td colspan='3' style='text-align:center;'><div class='alert alert-success' role='alert' style='margin-bottom: 0;'><strong>Data Kosong</strong></div></td>
			</tr>";
		 }else{
			foreach($rsTampil as $data){

                //var_dump($data);exit();
				
				$txtData.="<tr>
                    <td style='vertical-align:middle;text-align:center' id='id".$n."' align='center'>".$n.".</td>
                    <td style='vertical-align:middle;'>".$data['templatebiayalpus']['namaTemplate']."</td>
                    <td align='center' style='vertical-align:middle;'>
                    <button type='button' class='btn btn-default btn-xs btnEdit'><i class='fa fa-pencil-square fa-lg' style='margin: 5px 5px;' aria-hidden='true'></i></button></td>
				</tr>
				";
				$n++;
			}
		 }
		echo $txtData."!".$linkHal;
    }

    function geteditdata(){
        $this->autoRender = false;
		//echo $this->Function->cekSession($this);
        $this->loadModel('User');
        $namaTemplate=$_POST['namaTemplate'];
        $sql="SELECT * FROM definance.templatebiayalpus WHERE namaTemplate='$namaTemplate'";
        $querysql=$this->User->query($sql);
        $jumData=count($querysql);
        $txtData=[];
        $i=0;
        $txtdata=[];
        foreach($querysql as $data){ 
            $txtdata[]= array('id'=>$data["templatebiayalpus"]["id"],'namaTemplate'=>$data["templatebiayalpus"]["namaTemplate"],'divisiId'=>$data["templatebiayalpus"]["divisiId"],'divisi'=>$data['templatebiayalpus']['divisi'],'nominal'=>number_format($data['templatebiayalpus']['nominal'],0,'','.'));
        } 
        echo json_encode($txtdata);
    }

    function deleteRecord(){
        $this->autoRender = false;
        $this->loadModel('User');

        try{ 
            $dataSource = $this->User->getdatasource();
            $dataSource->begin();

            $id=$_POST['id'];
            $QueryCRUD="DELETE	FROM definance.templatebiayalpus  WHERE  templatebiayalpus.id='$id'";
            $this->User->query($QueryCRUD);
            //var_dump($_POST);exit();
            echo "sukses";
            $dataSource->commit();	
        }
        catch(Exception $e){
            var_dump($e->getTrace());
                $dataSource->rollback();
        }
    }

    function saved(){
        $this->autoRender = false;
        $this->loadModel('User');
        try{ 
            $dataSource = $this->User->getdatasource();
            $dataSource->begin();

            $namaTemplate=$_POST['namaTemplate'];
            //var_dump($_POST);exit();
            $CRUD=$_POST['jnsCRUD'];
            
            
            $queryInsert="INSERT INTO definance.templatebiayalpus(namaTemplate,divisiId,divisi,nominal)VALUES";
            
            $jum=count($_POST['rowDivisi']);
            if ($CRUD=="addnew"){
                $cek=$this->User->query("SELECT * FROM definance.templatebiayalpus WHERE namaTemplate='$namaTemplate'");
                if(count($cek)>0){
                    //echo "gagal";
                    echo "dataGanda";
                    exit();
                }
                $queryValues="";
                for($i=0;$i<$jum;$i++){
                    $divisiID=$_POST['rowDivisi'][$i];
                    $divisiNama=$_POST['divisiName'][$i];
                    $nominal=preg_replace("/[^0-9]/", "",$_POST['nominalDivisi'][$i]);
                    $queryValues.="('$namaTemplate','$divisiID','$divisiNama','$nominal'),";
                    //var_dump($nominal);exit();
                }
                $queryValues = rtrim($queryValues, ", ");
                $queryInsert=$queryInsert.$queryValues;
                //var_dump($queryInsert);exit();
                $this->User->query($queryInsert);
                echo "addSukses"; 
            }
            
            //var_dump($_POST['idRecord']['0']);exit();
            $lanjut="";
            if($CRUD=="edit"){
                $idFirst=$_POST['idRecord'][0];
                if($idFirst!=''){
                    $get=$this->User->query("SELECT namaTemplate FROM definance.templatebiayalpus WHERE id='$idFirst'");
                    $getNama=$get[0]['templatebiayalpus']['namaTemplate'];
                    if($getNama!=$namaTemplate){
                        $cek=$this->User->query("SELECT * FROM definance.templatebiayalpus WHERE namaTemplate='$namaTemplate'");
                        if(count($cek)>0){
                            //echo "gagal";
                            echo "dataGanda";
                            exit();
                        }
                    }
                }else{
                    $cek=$this->User->query("SELECT * FROM definance.templatebiayalpus WHERE namaTemplate='$namaTemplate'");
                    if(count($cek)>0){
                        //echo "gagal";
                        echo "dataGanda";
                        exit();
                    }
                }
                //exit();
                for($i=0;$i<$jum;$i++){
                    $idRecord=$_POST['idRecord'][$i];
                    $divisiID=$_POST['rowDivisi'][$i];
                    $divisiNama=$_POST['divisiName'][$i];
                    $nominal=preg_replace("/[^0-9]/", "",$_POST['nominalDivisi'][$i]);
                    if($idRecord!=""){
                        $this->User->query("UPDATE definance.templatebiayalpus  SET namaTemplate='$namaTemplate',divisiId ='$divisiID',divisi ='$divisiNama',nominal='$nominal' WHERE id='$idRecord'");
                    }else{
                        $queryInsert=$queryInsert."('$namaTemplate','$divisiID','$divisiNama','$nominal')";
                        $this->User->query($queryInsert);
                    }
                }
                echo "editSukses"; 
            }

            
            
            $dataSource->commit();	
        }
        catch(Exception $e){
            var_dump($e->getTrace());
                $dataSource->rollback();
        }
    }


    //fungsi
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