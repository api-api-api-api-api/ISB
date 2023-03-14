<?php
App::uses('AppController', 'Controller');
/**
 * Inputsettingpivots Controller
 *
 */
class  OpenlayersController extends AppController {
    public $components = array('Function','Paginator');	
    public function index(){
	echo $this->Function->cekSession($this);
	}
    public function getNama(){   
        $this->loadModel('User');
        $queryNama=$this->User->query("select * from geolokasi.lokasi l  group by l.nama");
        $txtOptionNama='<option value="">PILIH NAMA</option>';
        if(count($queryNama)>0){
            foreach($queryNama as $data){
                $txtOptionNama.="<option value=\"".$data['l']['nama']."\">".$data['l']['nama']."</option>";
            }
        }
        echo $txtOptionNama;	
    }
    public function posisi(){
        $this->loadModel('User');
        //$nama=$_POST["nama"];
        
        // $queryPosisi=$this->User->query("select * from geolokasi.lokasi l  where l.nama='$nama' order by l.id");

        // $txtTablePosisi='';
        // $index=0;
        // if(count($queryPosisi)>0){
           
        //     foreach($queryPosisi as $data){
        //         $id=$data['l']['id'];
        //         $txtTablePosisi.="
        //             <tr class='tab'>
        //                 <td>".$data['l']["date"]."<input type=\"hidden\" name='tdDate' value=".$data['l']["date"]."></td>
        //                 <td>".$data['l']["time"]."<input type=\"hidden\" name='tdTime' value=".$data['l']["time"]."></td>
        //                 <td>".$data['l']["lokasi"]." ".$data['l']["kota"]."</td>
        //                 <td style='display:none;'>".$data['l']["kota"]."<input type=\"hidden\" name='tdKota' value=".$data['l']["kota"]."></td>
        //                 <td style='display:none;'>".$data['l']["lokasi"]."<input type=\"hidden\" name='tdLokasi' value=".$data['l']["lokasi"]."></td>
        //                 <td style='display:none;'>".$data['l']["lon"]."<input type=\"hidden\" name='tdLon' value=".$data['l']["lon"]."></td>
        //                 <td style='display:none;'>".$data['l']["lat"]."<input type=\"hidden\" name='tdLat' value=".$data['l']["lat"]."></td>
        //                 <td style='display:none;'><input type=\"hidden\" name='index' value=".$index."></td>
        //             </tr>
        //         ";
        //         $index++;
        //         }
        //     }
            
        // echo $txtTablePosisi;	exit();
        $nik='21301930';
        $awal=$_POST['startDate'];
		$akhir=$_POST['endDate'];
		// if($nikAbsen==""){
		// 	$nikAbsen="''";
		// }
		if($awal==""){
				$tglAwal=date("Y-m-d");
			}else{
				$tglAwal=$this->Function->dateluar($awal);
				}
		if($akhir==""){
				$tglAkhir=date("Y-m-d");
			}else{
				$tglAkhir=$this->Function->dateluar($akhir);
		}
        $queryData=$this->User->query("SELECT * FROM absensi.`attendanceonline` atto 
        LEFT JOIN absensi.`lokasicheckpoints` loc ON loc.id=atto.lokasiid
        WHERE atto.nik = '$nik' AND atto.`tanggal` BETWEEN '$tglAwal' AND '$tglAkhir'");
        //var_dump($queryData);exit();
        $txtTablePosisi='';
        $index=0;
        if(count($queryData)>0){
           
            foreach($queryData as $data){
                //var_dump($data);exit();
                $id=$data['atto']['id'];
                //var_dump($data['loc']["namaLokasi"]);exit();
                $txtTablePosisi.="
                    <tr class='tab'>
                        <td>".$data['atto']['tanggal']."<input type=\"hidden\" name='tdDate' value=".$data['atto']['tanggal']."></td>
                        <td>".$data['atto']['waktu']."<input type=\"hidden\" name='tdTime' value=".$data['atto']['waktu']."></td>
                        <td>".$data['loc']['namaLokasi']." ".$data['loc']['kabKota']." ".$data['loc']['propinsi']."</td>
                        <td style='display:none;'>".$data['loc']['kabKota']."<input type=\"hidden\" name='tdKota' value='".$data['loc']['namaLokasi']." ".$data['loc']['kabKota']."'></td>
                        <td style='display:none;'>".$data['loc']['namaLokasi']."<input type=\"hidden\" name='tdLokasi' value=".$data['loc']['namaLokasi']."></td>
                        <td style='display:none;'>".$data['atto']['long']."<input type=\"hidden\" name='tdLat' value=".$data['atto']['long']."></td>
                        <td style='display:none;'>".$data['atto']['lat']."<input type=\"hidden\" name='tdLon' value=".$data['atto']['lat']."></td>
                        <td style='display:none;'><input type=\"hidden\" name='index' value=".$index."></td>
                    </tr>
                ";
                $index++;
                }
            }
            //var_dump($data['loc']["namaLokasi"]);exit();
        echo $txtTablePosisi;	exit();
        
    }
}
