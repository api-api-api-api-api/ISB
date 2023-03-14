<?php
App::uses('AppController', 'Controller');
/**
 * Inputmasterbarang Controller
 *
 */
class MasterjenisitemsController extends AppController {
    public $components = array('Function','Paginator');
    public function index(){
		echo $this->Function->cekSession($this);
    }
	
//	 public function onLoadHandler(){
//      $this->autoRender = false;
//      $this->loadModel('User');
//      $group=$_POST['group'];
//     
//
//      $sql="SELECT * FROM definance.`kategoribarangs` WHERE  groupFPB='".$group."' ORDER BY nama";
//     
//      $querysql=$this->User->query($sql);
//      $jumQuery=count($querysql);
//	  $txtKategori="";
//      if($jumQuery>0){
//        foreach($querysql as $data){
//			 $txtKategori.="<option value='".$data["kategoribarangs"]["id"]."'>".$data["kategoribarangs"]["nama"]."</option>";
//			}
//      }
//      echo $txtKategori;
//    }
	public function getKategori(){
      $this->autoRender = false;
      $this->loadModel('User');
      $group=$_POST['group'];
     

      $sql="SELECT * FROM definance.`kategoribarangs` WHERE  groupFPB='".$group."' ORDER BY nama";
     
      $querysql=$this->User->query($sql);
      $jumQuery=count($querysql);
	  $txtKategori="";
      if($jumQuery>0){
        foreach($querysql as $data){
			 $txtKategori.="<option value='".$data["kategoribarangs"]["id"]."'>".$data["kategoribarangs"]["nama"]."</option>";
			}
      }
      echo $txtKategori;
    }
    public function getData(){
      $this->autoRender = false;
      $this->loadModel('User');
      $txtjenisBarang=$_POST['txtjenisBarang'];
	  $kategori=$_POST['kategori'];
      $hm=$_POST['hal'];
      $fungsi=$_POST['fungsi'];
	  $group=$_POST['group'];
      
      
      //filter
      $txtData='';
      $limit=10;
      
      if(empty($hm)||$hm==1){
      $start=0; 
      }else{ 
        $start=($hm-1)*$limit; 
      }

      $sql="SELECT * FROM definance.jenisbarangs WHERE nama like '%$txtjenisBarang%' and groupFPB='".$group."' and kategoriId='".$kategori."' ORDER BY nama";
     
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
          <td colspan=3 style=\"text-align:center;\">Kosong</td>
        </tr>";
      }else{
          $style1='';
          $style2='';
          $style3='';
          $style4='';
          $style5='';
          $style6='';
          $style7='';
          $style8='';
        foreach($rsTampil as $data){
          $id=$data['jenisbarangs']['id'];
          if(fmod($n,10)==0 OR $n===$jumQuery){
            $style1='border-bottom:1px solid Brown;';
            $style2='border-bottom:1px solid DarkGreen;';
            $style3='border-bottom:1px solid SteelBlue;';
            $style4='border-bottom:1px solid Chocolate;';
            $style5='border-bottom:1px solid DarkSlateGray;';
            $style6='border-bottom:1px solid IndianRed;';
            $style7='border-bottom:1px solid Black;';
            $style8='border-bottom:1px solid #ddd;';
          }
          //var_dump($data[$table]);exit();
          $txtData.="<tr>
              <td  style=\"$style8\" id='id".$n."' align=\"center\">".$n.".</td>
              <td  id='id".$id."' align=\"center\" style=\"display:none;$style8\">".$id."<input type='hidden' name='txtid' id='txtid".$id."' value='".$id."'></td>
              <td  style=\"$style8\" id='txtNama".$id."' align=\"left\" >
                <label id='lbl".$id."'>".$data['jenisbarangs']['nama']."</label> 
                <input type='text' class='form-control' name='idNama' id='idNama".$id."' value='".$data['jenisbarangs']['nama']."' style='display:none;'>
              </td>
              <td  style=\"$style8\" id='txtBtn".$id."' align=\"right\">
              <button id='btnEditTag".$id."'type='button' class='btn btn-danger btn-sm' onClick='editTag(".$id.")'>edit</button>
              <div class=\"btn-group btn-group-sm\" role=\"group\" aria-label=\"...\">
                <button id='btnSimpanTag".$id."' type='button' class='btn btn-primary' onClick='simpanTag(".$id.")' style='display:none'>simpan</button>
                <button id='btnBatalTag".$id."' type='button' class='btn btn-warning' onClick='batalTag(".$id.")' style='display:none'>batal</button>
              </div>
              
              </td>
            </tr>";
            $n++;
        }
      }
      echo $txtData."!".$linkHal;
    }

    public function updateTag(){
      $this->autoRender = false;
      $this->loadModel('User');

    try{
			$dataSource = $this->User->getdatasource();
      $dataSource->begin();
      
        $id=$_POST['id'];
        $nama=$_POST['nama'];
		$group=$_POST['group'];
		$kategori=$_POST['kategori'];
        $table='definance.jenisbarangs';
        
        if($group=="ATK"){$groupId="2";}else if($group=="INVENTARIS"){$groupId="1";}else{$groupId="3";}
        $sql="UPDATE $table SET nama='$nama', groupsId='".$groupId."', kategoriId='".$kategori."'
          WHERE id = '$id' and groupFPB='".$group."'";
        
        $querys = $this->User->query($sql);
        echo "Sukses";

      $dataSource->commit();	
			}
			catch(Exception $e){
			var_dump($e->getTrace());
				$dataSource->rollback();
		  }
  
    }
    public function saveJenis(){
      $this->autoRender = false;
      $this->loadModel('User');

      try{
        $dataSource = $this->User->getdatasource();
        $dataSource->begin();
        
          //$id=$_POST['id'];
          $nama=$_POST['nama'];
		  $group=$_POST['group'];
		  $kategori=$_POST['kategori'];
		  
		  
          $table='definance.jenisbarangs';
          
        	if($group=="ATK"){$groupId="2";}else if($group=="INVENTARIS"){$groupId="1";}else{$groupId="3";}
          $simpanJenis="INSERT INTO  $table (nama, groupsId,kategoriId,groupFPB)VALUES('$nama','".$groupId."','".$kategori."','".$group."')";
          //echo($simpanJenis);exit();
          $this->User->query($simpanJenis);
            
         
          echo "Sukses";

        $dataSource->commit();	
        }
        catch(Exception $e){
        var_dump($e->getTrace());
          $dataSource->rollback();
        }
    }

  //fungsi paging multi
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