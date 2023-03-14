<?php
App::uses('AppController','Controller');

class MasterrewardsController extends AppController{
    public $components=array('Function','Paginator');
    public function index(){
        echo $this->Function->cekSession($this);
    }

    public function onLoadHandler(){
        $this->loadModel('User');
        $this->autoRender = false;
    }
    public function getDtMarketplace(){
        $this->autoRender = false;
        $this->loadModel('User');
        
        //$queryUser=$this->User->query("SELECT groupId,penanggungJawab,pejabatId FROM users WHERE penanggungJawab <=> '' OR penanggungJawab IS NOT NULL ");
        $queryMarketplace=$this->User->query("SELECT ms.id,ms.namaMarketplace FROM definance.mastermarketplaces ms ORDER BY ms.namaMarketplace");
        //var_dump($queryUser);exit();
        $txtdata=[];
        //$txtdata['dtkaryawan']=[];
        $txtdata[]=array('label'=>'-Please Select-','value'=>'~');
       
        foreach($queryMarketplace as $dtMarketplace){ 
              $txtdata[]= array('label'=>$dtMarketplace["ms"]["namaMarketplace"],'value'=>$dtMarketplace["ms"]["id"]."~".$dtMarketplace["ms"]["namaMarketplace"]);
        }
        echo json_encode($txtdata);
    }
    public function getData()
    {
        $this->autoRender = false;
        $this->loadModel('User');

        //post filter
        $txtNamaMastermarketplacefilter=$_POST['txtNamaMastermarketplacefilter'];
        $txtNamaMasterrewardfilter=$_POST['txtNamaMasterrewardfilter'];
        $txtStatus=$_POST['txtStatus'];
        // $txtNamaGroupFilter=$_POST['txtNamaGroupFilter'];
        
        // $txtNIKFilter=$_POST['txtNIKFilter'];
        // $txtNamaKaryawanFilter=$_POST['txtNamaKaryawanFilter'];

        // if(!empty($txtNIKFilter)){$txtNIKFilter=" AND u.nik like '%$txtNIKFilter%'";}
        // if(!empty($txtNamaKaryawanFilter)){$txtNamaKaryawanFilter=" AND u.namaKary like '%$txtNamaKaryawanFilter%'";}
        $hm=$_POST['hal'];
        $fungsi=$_POST['fungsi'];
       
        
        
        $txtData='';
        $limit=10;

        if(empty($hm)||$hm==1){$start=0;}else{$start=($hm-1)*$limit;}
       
        $sql="SELECT * FROM definance.masterrewards m  WHERE 
             m.namaReward like '%$txtNamaMasterrewardfilter%' 
             AND m.sts like '%$txtStatus%' ORDER BY m.id";
         
         //var_dump($sql);exit();
         
        $querysql=$this->User->query($sql);
        $jumQuery=count($querysql);
        $sum=ceil($jumQuery/$limit);
       
       
        /* -----------------------------Navigasi Record ala google style ----------------------------- */
        $linkHal=$this->pageNavMulti($hm,$sum,$limit,$fungsi);
        /* -----------------------------End Navigasi Record ala google style ----------------------------- */
        $rsTampil=$this->User->query($sql." limit $start, $limit");
        $n=$start+1;
        //var_dump($querysql);exit();
        if($jumQuery==0 || $jumQuery==Null){
          
            $txtData.="
                <tr>
                     <td colspan='13' style='text-align:center;'><div class='alert alert-success' role='alert' style='margin-bottom: 0;'><strong>Data Kosong</strong></div></td>
                </tr>";
            }else{
                foreach($rsTampil as $data){
                    $id=$data['m']['id'];
                    if($data['m']['sts']=='true')
                    {$status='<span class="label label-primary"><i class="fa fa-check-circle  fa-lg"></i> Aktif</span>';}else{$status='<p class="label label-danger"><i class="fa fa-times-circle fa-lg"></i> Tidak Aktif</p>';}
                    $txtData.="<tr>
                        <td style='vertical-align:middle;text-align:center' id='id".$n."' align='center'>".$n.".</td>
                        <td style= id='txtBtn".$id."' align='center'>
                            <button type='button' class='btn btn-xs btn-default edtBtn'><i class='fa fa-edit fa-lg' style='margin: 5px 5px;'></i></button>
                        </td>
                        <td style='display:none'>".$id."</td>
                        <td style='display:none' id='radio".$id."' align='center'>".$data['m']['sts']."</td>
                        <td style='vertical-align:middle;text-align:left' id='tdNamareward".$id."' align='center'>".$data['m']['namaReward']."</td>
                        <td style='vertical-align:middle;text-align:left' id='tdJenissaldo".$id."' align='center'>".$data['m']['jenisSaldo']."</td>
                        <td style='vertical-align:middle;text-align:center' id='tdStatus".$id."' align='center'>".$status."</td>
                        
                    </tr>";
                    $n++;
                }
            }
        echo $txtData."!".$linkHal;
    }

    public function saveMode(){
        $this->autoRender = false;
        $this->loadModel('User');
        try{
            $dataSource = $this->User->getdatasource();
            $dataSource->begin();
            $sukses='';
            $hm='';
            $limit=10;
            //$id=$_POST['id'];
            $mode=$_POST['mode'];
            //var_dump($_POST);exit();
            $namaReward=$_POST['namaReward'];
            $statusCek=$_POST['statusCek'];
            $dateCreate=date("Y-m-d h:i:s");
            $jenisSaldo=$_POST['jenisSaldo'];
            //var_dump($mode);exit();
            if($mode=='add'){
                $sql="INSERT INTO definance.masterrewards (namaReward,
                sts,jenisSaldo,
                dateCreate)
                    VALUES
                ('$namaReward',
                '$statusCek',
                '$jenisSaldo',
                '$dateCreate'
                )";
                //var_dump($sql);exit();
                //var_dump($sql);exit();
                //var_dump($simpanJenis);exit();
                $this->User->query($sql);

                $sukses='sukses';
                $querygetID=$this->User->query("SELECT m.id FROM definance.masterrewards  m  ORDER BY m.id DESC limit 1");
                $recordid=0;
                $id=$querygetID[0]['m']['id'];
                $query=$this->User->query("SELECT * FROM definance.masterrewards  m  ORDER BY m.id");
                foreach($query as $rowid){
                    $recordid ++;
                    if($rowid['m']['id']==$id){
                        break;
                    }
                }
                $hm=ceil($recordid/$limit); 

            }elseif($mode=='edit'){
                //var_dump($_POST);exit();
                $rewardID=$_POST['rewardID'];
                 
                $sql="UPDATE definance.masterrewards  SET 
                namaReward='$namaReward',
                jenisSaldo='$jenisSaldo',
                sts='$statusCek'
                
                WHERE id = '$rewardID'";

                $this->User->query($sql);
                $sukses='sukses';
                $recordid=0;
                $query=$this->User->query("SELECT * FROM definance.masterrewards m  ORDER BY m.id ");
                foreach($query as $rowid){
                    $recordid ++;
                    if($rowid['m']['id']==$rewardID){
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
    //fungtion pagin
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