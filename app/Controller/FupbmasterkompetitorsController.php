<?php
App::uses('AppControlle','Controller');

class FupbmasterkompetitorsController extends AppController {
    public $components = array('Function','Paginator');
    function index()
    {
         echo $this->Function->cekSession($this);
    }

    public function getData(){
        $this->autoRender = false;
        $this->loadModel('User');

        //filter

        $txtNamaKompetitor=$_POST['txtNamaKompetitor'];

        $hm=$_POST['hal'];
        $fungsi=$_POST['fungsi'];
       
        
        
        $txtData='';
        $limit=10;
        if(empty($hm)||$hm==1){$start=0;}else{$start=($hm-1)*$limit;}

        $sql="SELECT * FROM dpfdplnew.mastercompanycompatitors WHERE namaCompany like '%$txtNamaKompetitor%'  ORDER BY namaCompany";
        
        $querysql=$this->User->query($sql);
        $jumQuery=count($querysql);
        $sum=ceil($jumQuery/$limit);
        //var_dump($sum);exit();

         /* -----------------------------Navigasi Record ala google style ----------------------------- */
         $linkHal=$this->pageNavMulti($hm,$sum,$limit,$fungsi);
         /* -----------------------------End Navigasi Record ala google style ----------------------------- */
         $rsTampil=$this->User->query($sql." limit $start, $limit");
         $n=$start+1;
         
         if($jumQuery==0 || $jumQuery==Null){
         
           $txtData.="
               <tr>
                    <td colspan=3 style='text-align:center;'>Kosong</td>
               </tr>";
           }else{
                foreach($rsTampil as $data){
                    $id=$data['mastercompanycompatitors']['id'];
                    
                    $txtData.="<tr>
                        <td style='vertical-align:middle;text-align:center' id='id".$n."' align='center'>".$n.".</td>
                        <td id='id".$id."' align='center' style='display:none'>".$id."<input type='hidden' name='txtid' id='txtid".$id."' value='".$id."'></td>
                        <td style='vertical-align:middle;text-align:left;' id='txtNamaKompetitor".$id."' >
                            <label id='lbl".$id."' style='margin-bottom:unset;font-weight:unset;'>".$data['mastercompanycompatitors']['namaCompany']."</label> 
                            <input type='text' class='form-control' name='idNamaKompetitor' id='idNama".$id."' value='".$data['mastercompanycompatitors']['namaCompany']."' style='display:none;font-size:12px;'>
                        </td>
                        <td style= id='txtBtn".$id."' align='right'>
                            <div class='btn-group btn-group-sm' id='btnDivEdit".$id."'>
                                <button id='btnEditTag".$id."'type='button' class='btn btn-warning btn-sm editTag'><i class='fa fa-pencil fa-lg'></i> edit</button>
                                <button id='btnHapusTag".$id."'type='button' class='btn btn-danger btn-sm hapusTag'><i class='fa fa-trash-o fa-lg'></i> hapus</button>
                            </div>
                            <div class='btn-group btn-group-sm' id='btnDiv".$id."' style='display:none'>
                                <button id='btnSimpanTag".$id."' type='button' class='btn btn-primary simpanTag' ><i class='fa fa-floppy-o fa-lg'></i> save</button>
                                <button id='btnBatalTag".$id."' type='button' class='btn btn-warning batalTag'><i class='fa fa-ban fa-lg'></i> batal</button>
                            </div>
                        </td>
                        <td style='display:none'>".$id."</td>
                    </tr>";
                    $n++;
                }
                
           }
           echo $txtData."!".$linkHal;
    }

    public function saveKompetitor(){
        $this->autoRender = false;
        $this->loadModel('User');
  
        try{
            $dataSource = $this->User->getdatasource();
            $dataSource->begin();
            $hm='';
            $limit=10;
            //$id=$_POST['id'];
            $CRUD=$_POST['CRUD'];
            if($CRUD=='create'){
                $namaCompany=$_POST['namaCompany'];           
                $sql="INSERT INTO  dpfdplnew.mastercompanycompatitors (namaCompany)VALUES('$namaCompany')";
                //var_dump($simpanJenis);exit();
                $this->User->query($sql);

                $querygetID=$this->User->query("SELECT m.id FROM dpfdplnew.mastercompanycompatitors m  ORDER BY m.id DESC limit 1");
                $recordid=0;
                $id=$querygetID[0]['m']['id'];
                $query=$this->User->query("SELECT * FROM dpfdplnew.mastercompanycompatitors m  ORDER BY m.namaCompany");
                foreach($query as $rowid){
                    $recordid ++;
                    if($rowid['m']['id']==$id){
                        break;
                    }
                }
                $hm=ceil($recordid/$limit); 

            }elseif($CRUD=='update'){
                $id=$_POST['id'];
                $namaCompany=$_POST['namaCompany'];           
                $sql="UPDATE dpfdplnew.mastercompanycompatitors SET namaCompany='$namaCompany' WHERE id = '$id'";
                 $this->User->query($sql);
            }else{
                
            }
           
              
           
            echo "Sukses".$hm;
  
            $dataSource->commit();	
        }
        catch(Exception $e){
            var_dump($e->getTrace());
            $dataSource->rollback();
        }
    }
    
    public function deleteKompetitor(){
        $this->autoRender = false;
        $this->loadModel('User');
  
        try{
            $dataSource = $this->User->getdatasource();
            $dataSource->begin();
            //set variable-variable 
            $hm='';
            $limit=10;
                $recordid=0;
                $id=$_POST['id'];
                $query=$this->User->query("SELECT * FROM dpfdplnew.mastercompanycompatitors m  ORDER BY m.namaCompany");
                foreach($query as $rowid){
                    $recordid ++;
                    if($rowid['m']['id']==$id){
                        break;
                    }
                }
                $sum1=ceil($recordid/$limit); 
                //echo $sum1;exit();
                $this->User->query("DELETE	FROM dpfdplnew.mastercompanycompatitors WHERE id='$id'");

                $query2=$this->User->query("SELECT * FROM dpfdplnew.mastercompanycompatitors m  ORDER BY m.namaCompany");
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

    // function navigasi
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