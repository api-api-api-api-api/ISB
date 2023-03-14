<?php
    echo $this->Html->script('h1pabanksoal.js');
    echo $this->Html->script('bundle.min.js');       
?>


<style>
 /* Select Pure Auto complate */
    .select-wrapper {margin: auto; max-width: 500px;width: calc(100% - 40px);}
    .select-pure__select {align-items: center;border-radius: 0;border: 1px solid #ccc;box-sizing: border-box;color: #363b3e;cursor: pointer; display: flex;font-size: 14px;font-weight: 500;justify-content: left;min-height: 34px;padding: 5px 10px; position: relative;transition: 0.2s; width: 100%;}
    .select-pure__options {  border-radius: 4px;border: 1px solid rgba(0, 0, 0, 0.15);box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04); box-sizing: border-box;color: #363b3e; display: none; left: 0; max-height: 221px;
    overflow-y: scroll; position: absolute; top: 35px; width: 100%; z-index: 5;}
    .select-pure__select--opened .select-pure__options { display: block;}
    .select-pure__option { background: #fff; border-bottom: 1px solid #e4e4e4; box-sizing: border-box;/* height: 44px;*/ line-height: 20px; padding: 10px;}
    .select-pure__option--selected { color: #e4e4e4; cursor: initial; pointer-events: none;}
    .select-pure__option--hidden { display: none;}
    .select-pure__selected-label {background: #5e6264;border-radius: 4px;color: #fff;cursor: initial;display: inline-block; margin: 5px 10px 5px 0;padding: 3px 7px;}
    .select-pure__selected-label:last-of-type { margin-right: 0;}
    .select-pure__selected-label i {cursor: pointer;display: inline-block; margin-left: 7px;}
    .select-pure__selected-label i:hover {  color: #e4e4e4;}
    .select-pure__autocomplete {background: #faebcc; border-bottom: 1px solid #e4e4e4;border-left: none; border-right: none;border-top: none; box-sizing: border-box;font-size: 14px;outline: none;padding: 10px; width: 100%; margin-bottom:0 !important}
    /* End Select Pure Auto complate */
    .tableRecordSoal tbody {display:block;height:500px;overflow:auto;}
    .tableRecordSoal thead, .tableRecordSoal tbody tr {display:table;	width:100%;	table-layout:fixed;	}
    .tableRecordSoal thead {width: calc( 100% - 1em )}
    @media only screen and (min-width: 650px) {
        #editmodal, #modalcopy {
            width: 50%;
            margin-left:25%;
            margin-top:2%;
            margin-bottom:2%;
        }
       
    }
    .modal-body{height: 85%;}
    .modal-content{border-radius: 6px !important;}
</style>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<blockquote>BANK SOAL</blockquote>
<hr>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
      
                <div class="row">
                    <div class="col-md-10">


                        <div class="row">
                            <div class="alert alert-info" role="alert"><h5 style='margin:0'>form input soal:</h5></div>

                            <ul class="nav nav-tabs" class="col-sm-7" style="margin-left: 0%">
                                <li class="active" id="tab1"><a href="#">Input Soal Pilihan</a></li>
                                <li id="tab2"><a href="#">Input Pertanyaan Tambahan</a></li>
                          </ul>
                          <!-- open well -->
                          <div class="well">
                            <div id="isitab1">
                              <div class="form-group">
                                <label for=""><em># Untuk inputan Peruntukan,Divisi,dan Jabatan hanya berlaku untuk Kategori -Pelaksanaan Pekerjaan (Job Implementation)- </em></label>
                              </div>
                              <div class="form-group">
                                <label for="txteditsoal">Peruntukan : </label>
                                <label><input type="radio" name="peruntukansoal" value="all" checked onclick="getdata(1)">All</label>
                                <label><input type="radio" name="peruntukansoal" value="marketing"  onclick="getdata(1)">Marketing</label>
                                <label><input type="radio" name="peruntukansoal" value="nonmarketing" onclick="getdata(1)">NON Marketing</label>
                              </div>
                              <div class="col-sm-12">
                                <div class="form-horizontal">
                                  <div class="form-group">
                                    <label for="fordivisi">Divisi</label>
                                    <input type="hidden" class="form-control" id="txtdivisiInput" name="" width="98%">
                                    <span class="autocomplete-select " id="divisiInput" ></span> 
                                  
                                  </div>
                                  <div class="form-group">
                                    <label for="forlabel" >Jabatan</label> 
                                    <input type="hidden" class="form-control" id="txtjabatanInput" name="" width="98%">
                                    <span class="autocomplete-select " id="jabatanInput" ></span> 

                                  </div>
                                </div>
                              </div>
                              <div class="col-sm-12"><hr></div>                             
                              

                            <div class="col-sm-3" style="display: none">Periode</div> 
                            <div class="" >
                                <div class="col-sm-3" style="display: none">
                                  <input type="text" class="form-control" id="txtperiode" style="display: none" name="" width="100%">
                                  <input type="text" class="form-control" id="periode" name="" width="100%" readonly="true">
                                </div>                         
                            </div>
                          <div class="row">
                            <div class="col-sm-12">
                                <div class="row">
                                  <div class="col-sm-7">
                                    <div class="form-group">
                                      <label for="txteditsoal">Kategori</label>
                                      <table width="100%">
                                          <tr>
                                              <td width="98%">
                                                  <input type="text" class="form-control" id="txtkategori" style="display: none;" name="" width="98%">
                                                  <span class="autocomplete-select" id="kategori" ></span> 
                                              </td>
                                              <td width="2%"> 
                                              </td>
                                              <td>
                                                  <button type="button" class="btn btn-primary stsperiode" onclick="kategorisoal()" data-dismiss="modal">+</button>
                                              </td>
                                          </tr>
                                        </table>
                                    </div>
                                  </div>
                                  <div class="col-sm-2">
                                    <div class="form-group"> 
                                      <label for="txteditsoal">Bobot</label>
                                      <input type="text" class="form-control" id="bobot" name="" width="100%">
                                    </div>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label for="soal">Soal</label>
                                  <textarea class="form-control" rows="5" id="soal"></textarea>
                                  <input type="text" id="bobottable" style="display: none">
                                </div>
                                <div class="form-group">
                                    <label for="forlabel">Tipe Soal</label> 
                                    <label><input type="radio" name="soalumumkhusus" value="umum" checked>Soal Umum</label>
                                    <label><input type="radio" name="soalumumkhusus" value="khusus">Soal Khusus</label>
                                </div>
                            </div>
                            
                            <!-- <div class="col-sm-2">Soal</div>
                            <div class="col-md-12">
                              
                              <input type="text" id="soalumumkhusus" style="display: none">
                            </div> -->
                          </div>

                          <div class="row">
                          <div class="col-sm-5">
                                
                                <br>
                                  <button type="button" class="btn btn-primary stsperiode" id="btntambah" onclick="savedata()">Tambah Soal</button>
                              
                          </div>
                        
                          <div class="row">
                              <div class="col-md-4">
                                  <br>
                                
                              
                              </div>
                          </div>
                          </div>
                        </div>

                          <!--     TAB2 ------------------------------------>


                        <div id="isitab2">
                          <!--  <div class="col-sm-3">Periode</div> -->
                            <div class="row">
                              <div class="col-xs-12">
                                <div class="form-group">
                                  <label for="txteditsoal">Soal</label>
                                  <textarea class="form-control" rows="5" id="soaluraian"></textarea>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                  <div class="panel panel-primary">
                                        <div class="panel-heading">Tambahkan Pilihan </div>

                                        <div class="panel-body">
                                          <table width="100%">
                                            <tr>
                                                <td width="80%">
                                                    <input type="text" class="form-control" id="txtisiansoal" class="txtisiansoal" >
                                                </td>
                                                <td width="1%"><font color="white">.</font> </td>
                                                <td >
                                                <button type="button" class="btn btn-primary stsperiode" id="btntambah" onclick="tambahpilihansoal()">+</button>
                                                </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <div class="panel panel-default"  id="panelisian"></div>
                                              </td>
                                            </tr>
                                          </table>
                                        </div>
                                  </div>
                                  <button type="button" class="btn btn-success stsperiode" id="btntambah" onclick="savedatauraian()">Tambah Soal</button>
                                </div>
                            </div>
                         
                              <!--
                            <div class="col-sm-3"><input type="text" class="form-control" id="txtperiode" style="display: none" name="" width="100%">
                              <input type="text" class="form-control" id="periode" name="" width="100%" readonly="true">
                  
                            </div>
                        -->
                            
                              <!--
                              <div class="row">
                              <div class="col-sm-5">
                                    <label><input type="radio" name="soalumumkhusus" value="umum" checked>Soal Umum</label>
                            
                                    <label><input type="radio" name="soalumumkhusus" value="khusus">Soal Khusus</label>
                              </div>
                              -->

                          <!-- END TAB2 -->
                          </div>
                          <!-- end well -->
                    </div>



                    <div class="col-md-12">
                        <div class="row">                          
<br>


                    
                           
                            <div id="tabel1">

                                <!--
                            <ul class="nav nav-tabs" id="navkategori">

                            </ul>

                              <table class="table table-bordered" style="margin-top: 20px">
                                <thead>
                                  <tr>
                                    <th width="5%" style="display:none">No</th>
                                    <th width="55%">soal</th>
                                    <th width="15%">kategori</th>
                                    <th width="5%">tipe soal</th>
                                    <th width="5%">bobot</th>
                                    <th width="20%">aksi</th>
                                  </tr>
                                </thead>
                                <tbody id="tblperiode">
                                 

                                </tbody>
                              </table>
                          -->
                            <div id="linkHal"></div>
                        </div>

                        <div id="tabel2">
                                <table class="table table-bordered" style="margin-top: 20px">
                                <thead>
                                  <tr>
                                    <th width="5%">No</th>
                                    <th width="30%">Soal</th>
                                    <th width="30%">peruntukan soal</th>
                                    <th width="15%">aksi</th>
                                  </tr>
                                </thead>
                                <tbody id="tblsoal2">
                                 

                                </tbody>
                              </table>
                            <div id="linkHal2"></div>
                        </div>

                        </div>
                    </div>

                    <div class="container">
                    
                      <!-- Trigger the modal with a button -->
            

                      <!-- Modal edit-->
                      <div class="modal fade" id="editmodal" role="dialog" >
                        <div class="modal-dialog">
                          <!-- Modal content-->
                          <div class="modal-content" style="border-radius: 6px;">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title"><b>Edit Soal</b></h4>
                            </div>
                            <div class="modal-body" style="overflow-y:auto;">
                                <div class="row">
                                  <div class="col-sm-12">
                                    <div class="">
                                      <input type="hidden" id="kategoriSoal" >
                                      <div class="form-group" id='editPeruntukan' style='display:none'>
                                        <label for="txteditsoal">Peruntukan</label>
                                        <label><input type="radio" name="txteditperuntukansoal" id="epmr" value="marketing" checked>Marketing</label>
                                        <label><input type="radio" name="txteditperuntukansoal" id="epnonmr" value="nonmarketing">NON Marketing</label>
                                      </div>
                                      <div class="form-group">
                                        <label for="txteditsoal">Bobot</label>
                                        <input type="hidden" class="form-control" id="txteditid" name="" style="width: 40%">
                                        <input type="text" class="form-control" id="txteditbobot" name="" style="width: 40%">
                                      </div>
                                      <div class="form-group">
                                        <label for="txteditsoal">Soal</label>
                                        <textarea class="form-control" id="txteditsoal" rows="5"></textarea>
                                      </div>
                                      <div class="form-group" id='editDivisi' style='display:none'>
                                        <label for="fordivisi">Divisi</label>
                                        <input type="hidden" class="form-control" id="txtdivisiEdit" name="" width="98%">
                                        <span class="autocomplete-select " id="divisiEdit" ></span> 
                                      
                                      </div>
                                      <div class="form-group" id='editJabatan' style='display:none'>
                                        <label for="forlabel" >Jabatan</label> 
                                        <input type="hidden" class="form-control" id="txtjabatanEdit" name="" width="98%">
                                        <span class="autocomplete-select " id="jabatanEdit" ></span> 

                                      </div>
                                      <div class="form-group">
                                        <label for="forlabel">Tipe Soal</label> 
                                        <label><input type="radio" name="txteditsoalumumkhusus" id="epUmum" value="umum" checked>Soal Umum</label>
                                        <label><input type="radio" name="txteditsoalumumkhusus" id="epKhusus"value="khusus">Soal Khusus</label>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                               

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary stsperiode" onclick="updatesoal()" >Update</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                          </div>
                          
                        </div>
                      </div>
                      <!-- end edit modal -->
                    </div>


                     <div class="container">
                    
                      <!-- Trigger the modal with a button -->
            

                      <!-- Modal -->
                      <div class="modal fade" id="modalgantikategori" role="dialog" style="width: 40%;height: 30%; margin-left: 30%; margin-top: 10%; overflow-x: auto; overflow-y: auto;">
                        <div class="modal-dialog">
                        
                          <!-- Modal content-->
                          <div class="modal-content" >
                            <div class="modal-header" >
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title"><b>Ganti Kategori Soal</h4></b>
                            </div>
                            <div class="modal-body">
                                <b>Kategori Awal</b><br>
                                <span id="spankategoriganti1"></span>
                                <input type="hidden" class="form-control" id="txtidgantikategori" name="" style="width: 40%">
                                <br><br>
                                <b>Kategori Baru</b><br>
                                <span id="spankategoriganti2"></span>
                                <input type="hidden" class="form-control" id="kategoriganti" name="" style="width: 40%">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary stsperiode" onclick="simpangantikategori()" data-dismiss="modal">Ganti</button>
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                          </div>
                          
                        </div>
                      </div>
                      
                    </div>


                      <div class="modal fade" id="modalcopy" role="dialog" aria-labelledby="modalcopy"  >
                        <div class="modal-dialog" role="document">
                          <!-- Modal content-->
                          <div class="modal-content" >
                            <div class="modal-header" >
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title"><b>Copy Soal</h4></b>
                            </div>
                            <div class="modal-body"  style="overflow-y:auto;">
                              <div class="row">
                                <div class="col-sm-12">
                                  <div class="well">
                                    <div class="form-group">
                                      <label for="txtKategoriSoalCopy">Kategori:</label>
                                      <input type="text" class="form-control" id="txtKategoriSoalCopy" name="" style="width: 100%" readonly>
                                    </div>
                                    <div class="form-group">
                                      <label for="txtSoalCopy">Soal:</label>
                                      <textarea class="form-control" rows="5" id="txtSoalCopy" readonly></textarea>
                                    </div>
                                    <div class="row">
                                      <div class='col-sm-2'>
                                        <div class="form-group">
                                          <label for="txteditsoal">Bobot Soal</label>
                                          <input type="text" class="form-control" id="txtBobotCopy" name="" readonly>
                                        </div>
                                      </div>
                                      <div class='col-sm-5'>
                                        <div class="form-group">
                                          <label for="txteditsoal">Peruntukan</label>
                                          <input type="text" class="form-control" id="txtPeruntukanCopy" name="" readonly>
                                        </div>
                                      </div>
                                      <div class='col-sm-5'>
                                        <div class="form-group">
                                          <label for="txteditsoal">Tipe Soal</label>
                                          <input type="text" class="form-control" id="txtTipeCopy" name="" readonly>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="row">
                                      <div class='col-sm-6'>
                                        <div class="form-group">
                                          <label for="txteditsoal">Divisi Soal</label>
                                          <input type="text" class="form-control" id="txtDivisiCopyView" name="" readonly>
                                          <input type="hidden" class="form-control" id="txtDivisiCek" name="" readonly>
                                        </div>
                                      </div>
                                      <div class='col-sm-6'>
                                        <div class="form-group">
                                          <label for="txteditsoal">Jabatan Soal</label>
                                          <input type="text" class="form-control" id="txtJabatanCopyView" name="" readonly>
                                          <input type="hidden" class="form-control" id="txtJabatanCek" name="" readonly>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-xs-12">
                                <blockquote>
                                <h5>Copy Soal ke :</h5><b></b>
                                </blockquote>
                                  <div class="form-group">
                                    <label for="fordivisi">Divisi</label>
                                    <input type="hidden" class="form-control" id="txtdivisiCopy" name="" width="98%">
                                    <span class="autocomplete-select " id="divisiCopy" ></span>   
                                  </div>
                                  <div class="form-group">
                                    <label for="forlabel" >Jabatan</label> 
                                    <input type="hidden" class="form-control" id="txtjabatanCopy" name="" width="98%">
                                    <span class="autocomplete-select " id="jabatanCopy" ></span>
                                  </div>
                                </div>
                                
                              </div>
                                <input type="hidden" class="form-control" id="txtidcopykategori" name="" style="width: 40%">
                                <div class='form-group' style='display:none;'>
                                <span id="spankategoricopy" ></span>
                                <input type="hidden" class="form-control" id="kategoricopy" name="" style="width: 40%">
                                </div>
                               
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary stsperiode" onclick="simpancopy()">COPY</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                          </div>
                          
                        </div>
                      </div>
                      
                    </div>



                    <div class="container">
                    
                      <!-- Trigger the modal with a button -->
            

                      <!-- Modal -->
                      <div class="modal fade" id="editmodal2" role="dialog" style="width: 40%;height: 80%; margin-left: 30%; margin-top: 5%">
                        <div class="modal-dialog">
                        
                          <!-- Modal content-->
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title"><b>Edit Soal Uraian</h4></b>
                            </div>
                            <div class="modal-body">
                                Soal<br>
                                <input type="text" class="form-control" id="xtxteditsoal" name="" style="width: 100%">
                                <hr>
                                Tambah Pilihan Soal<br>
                              <table width="110%">
                                  <tr>
                                      <td>
                               <input type="hidden" class="form-control" id="xtxtideditpilihan" name="" style="width: 100%">
                              <input type="text" class="form-control" id="xtxttambahpilihan" name="" style="width: 100%">
                                      </td>
                                      <td><font color="white">.</font></td>
                                      <td><button type="button" class="btn btn-primary " id="btntambah" onclick="edittambahpilihansoal()">+</button></td>
                                  </tr>
                              </table>


                               <br>
                              <div id="xdivpilihansoal">
                            </div>
                            <br>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary " onclick="updatedatauraian()" data-dismiss="modal">Update</button>
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                          </div>
                          
                        </div>
                      </div>
                      
                    </div>


                     <div class="modal fade" id="kategorimodal" role="dialog" style="width: 40%;height: 60%; margin-left: 30%; margin-top: 10%">
                        <div class="modal-dialog">
                        
                          <!-- Modal content-->
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title"><b>Manage Kategori Soal</h4></b>
                            </div>
                            <div class="modal-body">
                                Kategori<br>
                              
                              <label><input type="radio" name="tambahsoalumumkhusus" value="umum" checked>Soal Umum</label>
                      
                               <label><input type="radio" name="tambahsoalumumkhusus" value="khusus">Soal Khusus</label>
                            
                              <table>
                                  <tr>
                                      <td style="width:80%">
                                          <input type="text" class="form-control" id="txttambahkategori" name="" placeholder="kategori" style="width: 100%" >
                                      </td>
                                      <td><font color="white">.</font></td>
                                      <td style="width:20%">
                                          <input type="text" class="form-control" id="txttambahbobotkategori" name="" placeholder="bobot kategori" style="width: 100%">
                                      </td>
                    
                                      <td><font color="white">.</font></td>
                                      <td style="margin-left:100%">
                                        <tr>
                                            <td>
                                           
                                          *CONTOH BOBOT KATEOGRI: 0.4 BERARTI 40% DARI TOTAL NILAI 
                                          
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><font color="white">.</font></td>
                                        </tr>
                                        <table><tr>
                                            <td><button type="button" class="btn btn-primary stsperiode" onclick="tambahkategori()"  id="btntekategori">Tambah</button></td>
                                            <td><button type="button" class="btn btn-warning" onclick="cancelupdatekategori()" id="btncancelkategori">X</button></td>
                                        </tr></table>
                                           
                                           
                                      </td>
                                  </tr>
                              </table>
                    



                              
                              
                             
                                <table class="table table-bordered" style="margin-top: 20px">
                                <thead>
                                  <tr>
                  
                                    <th width="60%">kategori</th>
                                    <th width="10%">bobot</th>
                                    <th width="30%">aksi</th>
                                  </tr>
                                </thead>
                                <tbody id="tbodykategori">
                                 

                                </tbody>
                              </table>
                            </div>
                            <div class="modal-footer">
                                
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                          </div>
                          
                        </div>
                      </div>
                      
                    </div>

                   
                    <!--
                    <div class="row">
                        <div class="form-horizontal">
                        <div class="alert alert-info" role="alert"><h5 style='margin:0'>form input soal penilaian:</h5></div>
                
                            <div class="form-group">
                                <label class="col-md-2 control-label">Periode</label>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" id="tglstart" name="" width="100%">
                                </div>

                                <label class="col-md-2 control-label">Kategori</label>
                                <div class="col-md-2 ">
                                    <input type="text" class="form-control" id="tglend" name="">
                                   
                                </div>

                                  <label class="col-md-2 control-label">Bobot</label>
                                <div class="col-md-2 ">
                                    <input type="text" class="form-control" id="tglend" name="">
                                   
                                </div>
                            </div>
                           
                            <div class="form-group">
                                <label class="col-md-2 control-label"></label>
                                <div class="col-md-8">
                                <button  type="button" class="btn btn-primary" id="" onclick="savedata()">
                                    <i class="fa  fa-floppy-o fa-fw" aria-hidden="true"></i> SUBMIT</button></div>
                                </div>
                            </div>
                          
                            <table class="table" >
                                <thead>
                                  <tr>
                                    <th>No</th>
                                    <th>Periode Start</th>
                                    <th>Periode End</th>
                                    <th>Aksi</th>
                                  </tr>
                                </thead>
                                <tbody id="tblperiode">
                                 

                                </tbody>
                            </table>
                            <div id="linkHal"></div>

                        </div>
                        
                    </div>
                -->
                

        </div>
    </div>
</div>