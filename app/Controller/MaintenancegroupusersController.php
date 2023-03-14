<?php
App::uses('AppControlle','Controller');

class MaintenancegroupusersController extends AppController {
    public $components = array('Function','Paginator');
    function index()
    {
         echo $this->Function->cekSession($this);
    }
    public function getData(){
        $this->autoRender = false;
        $this->loadModel('User');

        //filter

        $txtNamaGroup=$_POST['txtNamaGroup'];

        $hm=$_POST['hal'];
        $fungsi=$_POST['fungsi'];
       
        
        
        $txtData='';
        $limit=10;
        if(empty($hm)||$hm==1){$start=0;}else{$start=($hm-1)*$limit;}

        $sql="SELECT * FROM tripleadb.groups WHERE namaGroup like '%$txtNamaGroup%'  ORDER BY namaGroup";
        
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
                    $id=$data['groups']['ID'];
                    
                    $txtData.="<tr>
                        <td style='vertical-align:middle;text-align:center' id='id".$n."' align='center'>".$n.".</td>
                        <td id='id".$id."' align='center' style='display:none'>".$id."<input type='hidden' name='txtid' id='txtid".$id."' value='".$id."'></td>
                        <td style='vertical-align:middle;text-align:left;' id='txtNamaGroup".$id."' >
                            <label id='lbl".$id."' style='margin-bottom:unset;font-weight:unset;'>".$data['groups']['namaGroup']."</label> 
                            <input type='text' class='form-control' name='idNamaGroup' id='idNama".$id."' value='".$data['groups']['namaGroup']."' style='display:none;font-size:12px;'>
                        </td>
                        <td style= id='txtBtn".$id."' align='center'>
                            <div class='' id='btnDivEdit".$id."'>
                                <button id='btnEditTag".$id."'type='button' class='btn btn-default btn-xs editTag'><i class='fa fa-pencil fa-lg'  style='margin: 5px 5px;'></i> </button>
                                <button id='btnHapusTag".$id."'type='button' class='btn btn-default btn-xs hapusTag'><i class='fa fa-trash-o fa-lg'  style='margin: 5px 5px;'></i> </button>
                            </div>
                            <div class='' id='btnDiv".$id."' style='display:none'>
                                <button id='btnSimpanTag".$id."' type='button' class='btn btn-default btn-xs simpanTag'><i class='fa fa-floppy-o fa-lg'  style='margin: 5px 5px;'></i> </button>
                                <button id='btnBatalTag".$id."' type='button' class='btn btn-default btn-xs batalTag'><i class='fa fa-ban fa-lg'  style='margin: 5px 5px;'></i> </button>
                            </div>
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
        $this->loadModel('Asset');
  
        try{
            $dataSource = $this->Asset->getdatasource();
            $dataSource->begin();
            $hm='';
            $limit=10;
            //$id=$_POST['id'];
            $CRUD=$_POST['CRUD'];
            if($CRUD=='create'){
                $namaGroup=$_POST['namaGroup'];           
                $sql="INSERT INTO tripleadb.groups (namaGroup)VALUES('$namaGroup')";
                //var_dump($simpanJenis);exit();
                $this->Asset->query($sql);
              
                $querygetID=$this->Asset->query("SELECT m.ID FROM tripleadb.groups  m  ORDER BY m.ID DESC limit 1");
                $recordid=0;
                $id=$querygetID[0]['m']['ID'];
                $query=$this->Asset->query("SELECT * FROM tripleadb.groups  m  ORDER BY m.namaGroup");
                foreach($query as $rowid){
                    $recordid ++;
                    if($rowid['m']['ID']==$id){
                        break;
                    }
                }
                $hm=ceil($recordid/$limit); 

            }elseif($CRUD=='update'){
                //var_dump($_POST);exit();
                $ID=$_POST['id'];
                $namaGroup=$_POST['namaGroup'];           
                $sql="UPDATE tripleadb.groups  SET namaGroup='$namaGroup' WHERE ID = '$ID'";

                 $this->Asset->query($sql);
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
    
    public function deleteGroup(){
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
                $query=$this->User->query("SELECT * FROM tripleadb.groups m  ORDER BY m.namaGroup");
                foreach($query as $rowid){
                    $recordid ++;
                    if($rowid['m']['ID']==$id){
                        break;
                    }
                }
                $sum1=ceil($recordid/$limit); 
                //echo $sum1;exit();
                $this->User->query("DELETE	FROM tripleadb.groups WHERE ID='$id'");

                $query2=$this->User->query("SELECT * FROM tripleadb.groups m  ORDER BY m.namaGroup");
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