<?php
App::uses('AppController','Controller');

class MasterdivisisController extends AppController {
    public $components = array('Function','Paginator');
    function index(){
         echo $this->Function->cekSession($this);
    }

    public function getData(){
        $this->autoRender = false;
        $this->loadModel('User');

        $hm=$_POST['hal'];
        $fungsi=$_POST['fungsi'];

        $txtData='';
        $limit=10;

        if(empty($hm)||$hm==1){$start=0;}else{$start=($hm-1)*$limit;}

        $sql="SELECT * FROM internationalbusiness.divisis u
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
                    $id=$data['u']['id'];
                    $txtData.="<tr>
                        <td style='vertical-align:middle;text-align:center' id='id".$n."' align='center'>".$n.".</td>
                        <td style='vertical-align:middle;text-align:left' id='tdNamaUser".$id."' align='center'>".$data['u']['divisi']."</td>
                        <td style='vertical-align:middle;text-align:left' id='tdgroup".$id."' align='center'>".$data['u']['groupDivisi']."</td>
                        <td style= id='txtBtn".$id."' align='center'>
                            <button type='button' class='btn btn-xs btn-default edtBtn' data-id='$id' data-divisi='".$data['u']['divisi']."' data-groupDivisi='".$data['u']['groupDivisi']."'><i class='fa fa-edit fa-lg' style='margin: 5px 5px;'></i></button>
                            <button type='button' class='btn btn-xs btn-default delBtn' data-id='$id' style='display:none;'><i class='fa fa-trash-o fa-lg'  style='margin: 5px 5px;'></i> </i></button>
                        </td>
                        <td style='display:none'>".$id."</td>
                    </tr>";
                    $n++;
                }
            }
        echo $txtData."^".$linkHal;

    }

    public function saveCRUD(){
        $this->autoRender = false;
        $this->loadModel('User');
        $sukses='';
        $hm='';
        $limit=10;
        try{
            $dataSource = $this->User->getdatasource();
            $dataSource->begin();
            // var_dump($_POST);exit();
            
            // $idDivisi=$_POST['idDivisi'];
            $inpDivisi=$_POST["inpDivisi"];
            $inpGroupDivisi=$_POST["inpGroupDivisi"];
            //var_dump($cek);exit();

            if(empty($_POST["idDivisi"])){
                $sql="INSERT INTO internationalbusiness.`divisis` 
                    (divisi,groupDivisi)VALUES('$inpDivisi','$inpGroupDivisi')";
                $this->User->query($sql);
                $sukses='sukses';
                $querygetID=$this->User->query("SELECT m.id FROM internationalbusiness.divisis  m  ORDER BY m.id DESC limit 1");
                $id=$querygetID[0]['m']['id'];

            }else{
                $id=$_POST["idDivisi"];
                
                $sql="UPDATE internationalbusiness.divisi  SET 
                divisi='$inpDivisi',groupDivisi='$inpGroupDivisi' WHERE id = '$id'";
                $this->User->query($sql);
                $sukses='sukses';
                
            }
            $recordid=0;
            $query=$this->User->query("SELECT * FROM internationalbusiness.divisis m  ORDER BY m.id ");
                foreach($query as $rowid){
                    $recordid ++;
                    if($rowid['m']['id']==$id){
                        break;
                    }
                }
            $hm=ceil($recordid/$limit); 
           
            echo $hm."^".$sukses;
            
            $dataSource->commit();	
        }
        catch(Exception $e){
            var_dump($e->getTrace());
            $dataSource->rollback();
        }
    }

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