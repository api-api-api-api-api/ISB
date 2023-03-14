<?php
App::uses('AppController', 'Controller');
/**
 * Inputsettingpivots Controller
 *
 */
class  paperiodepenilaiansController extends AppController {
public $components = array('Function','Paginator');	
public function index(){
	echo $this->Function->cekSession($this);
	}



public function getdata(){
	
		//$this->loadModel('Group');
		$this->loadModel('Asset');
		$this->autoRender = false;
		
		$idUser=$this->Session->read('dpfdpl_userId');
	

		
      
        $hm=$_POST['hal'];
        $fungsi=$_POST['fungsi'];
       
        

        $limit=10;
        if(empty($hm)||$hm==1){$start=0;}else{$start=($hm-1)*$limit;}
		

		$sql="SELECT * from kpireg.paperiodepenilaians as a order by periodeStart desc";
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
                
        $txtData=' <tr><td colspan="4"><center>Data masih kosong</center></td></tr>';
    

          }else{
          	$txtData="";
          	$no=1;
          
				foreach($rsTampil as $data){
					//var_dump();exit();

					if($data['a']['status']=='EDITABLE'){
					$txtstatus='<td><select class="form-control" id="xtxtupdatestatus"><option value="EDITABLE">editable</option><option value="OPEN">open</option><option value="CLOSE">close</option></select></td>';
				}elseif($data['a']['status']=='OPEN'){
					$txtstatus='<td><select class="form-control" id="xtxtupdatestatus" ><option value="OPEN">open</option><option value="CLOSE">close</option></select></td>';
				}else{
					$txtstatus='<td>'.$data["a"]["status"].'</td>';
				}
					
				$txtData.=" <tr>";
				$txtData.="<td>".$no."</td>";
				$txtData.="<td>".$data['a']['namaPeriode']."<input type='hidden' id='xtxtnamaperiode_".$data['a']['id']."' value='".$data['a']['namaPeriode']."'></td>";
				$txtData.="<td>".$data['a']['periodeStart']."<input type='hidden' id='xtxtperiodestart_".$data['a']['id']."' value='".$data['a']['periodeStart']."'></td>";
				$txtData.="<td>".$data['a']['periodeEnd']."<input type='hidden' id='xtxtperiodeend_".$data['a']['id']."' value='".$data['a']['periodeEnd']."'></td>";
				$txtData.="<td>".$data['a']['status']."<input type='hidden' id='xtxtstatusperiode_".$data['a']['id']."' value='".$txtstatus."'></td>";
					$txtData.="<td><button type='button' class='btn btn-success btn-sm stsperiode' onclick='editstatus(".$data['a']['id'].")'><li class='material-icons' style='font-size:12px;color:white'>mode_edit</i></button>
				</td>";

				/*
				if($data['a']['status']=='EDITABLE'){
					$txtData.="<td><select class='form-control' id='txtupdatestatus' onchange='updatestatus(".$data['a']['id'].")'><option value='EDITABLE'>editable</option><option value='OPEN'>open</option><option value='CLOSE'>close</option></select></td>";
				}elseif($data['a']['status']=='OPEN'){
					$txtData.="<td><select class='form-control' id='txtupdatestatus' onchange='updatestatus(".$data['a']['id'].")'><option value='OPEN'>open</option><option value='CLOSE'>close</option></select></td>";
				}else{
					$txtData.="<td>".$data['a']['status']."</td>";
				}
				*/
	
				$txtData.=" </tr>";
					
		
			   $no++;
			}
		}
		  echo $txtData."!".$linkHal;
	}

	public function updatestatus(){
		$this->autoRender = false;
		$this->loadModel('Asset');
		try{
			$dataSource = $this->Asset->getdatasource();
			$dataSource->begin();
			
			$idUser=$this->Session->read('dpfdpl_userId');


			//get variable
			$id=$_POST['id'];
			$status=$_POST['status'];

			$queryUpdate="UPDATE kpireg.paperiodepenilaians SET status='$status' where id=$id ";
			$this->Asset->query($queryUpdate);



			

			$dataSource->commit();
			echo "berhasil update status";
		}catch(Exception $e){
			var_dump($e->getTrace());
			$dataSource->rollback();
		}
	}


		public function updateperiode(){
		$this->autoRender = false;
		$this->loadModel('Asset');

	
			
			$idUser=$this->Session->read('dpfdpl_userId');


			//get variable
			$id=$_POST['id'];
			$namaperiode=$_POST['namaperiode'];
			$status=$_POST['status'];
			$tglstart=$_POST['tglstart'];
			$tglend=$_POST['tglend'];

			$queryUpdate="UPDATE kpireg.paperiodepenilaians SET namaPeriode='$namaperiode',status='$status',periodeStart='$tglstart',periodeEnd='$tglend' where id=$id ";
			$this->Asset->query($queryUpdate);



			

			echo "berhasil update periode";

	}
	
	public function savedata(){
		$this->autoRender = false;
		$this->loadModel('Asset');
		try{
			$dataSource = $this->Asset->getdatasource();
			$dataSource->begin();
			
			$idUser=$this->Session->read('dpfdpl_userId');


			//get variable
			$namaperiode=$_POST['namaperiode'];
			$tglstart=$_POST['tglstart'];
			$tglend=$_POST['tglend'];
			$tahun = explode('-', $tglstart);

			$queryUpdate="UPDATE kpireg.paperiodepenilaians SET status='CLOSE'";
			$this->Asset->query($queryUpdate);


			$queryInsert="INSERT INTO kpireg.paperiodepenilaians(periodeStart,periodeEnd,tahun,status,namaPeriode)VALUES('$tglstart','$tglend','$tahun[0]','EDITABLE','$namaperiode')";
			$this->Asset->query($queryInsert);
			//echo $queryInsert;exit();

			

			$dataSource->commit();
			echo "berhasil insert data";
		}catch(Exception $e){
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