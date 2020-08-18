<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
         Validasi RO
        </div>
        <div class="tools">
          <a href="javascript:;" class="collapse">
          </a>
          <a href="javascript:;" class="reload">
          </a>

        </div>
      </div>
  <div class="portlet-body">
        <!------------------------------------------------------------------------------------------------------>

       
        <div class="box-body">                   
          <div class="sukses" ></div>
              <section class="content">             
      <!-- Main row -->
      
        <div class="row">
        <!-- Left col -->
            <section class="col-lg-12 connectedSortable">

           

                <div class="box box-info">
                  <div class="box-header">
                      <!-- tools box -->
                      <div class="pull-right box-tools"></div><!-- /. tools -->
                  </div>
                    
                        <form id="data_form" action="" method="post">
                            <div class="box-body">
                              
                              <div class="row">
                                <div class="col-md-8">
                                  <div class="form-group">
                                    <label>Kode Transaksi</label>
                                    <?php
                                      $kode_ro=$this->uri->segment(3);
                                      $get_ro=$this->db->query("SELECT * from transaksi_ro where kode_ro='$kode_ro'");
                                      $hasil_get=$get_ro->row();
                                      // print_r($hasil_get);
                                   ?>
                                    <input readonly="true" type="text" value="<?php echo $hasil_get->kode_ro; ?>" class="form-control" placeholder="Kode Transaksi" name="kode_ro" id="kode_ro" />
                                  </div>
                                </div>

                                <div class="col-md-2">
                                  <div class="form-group">
                                    <label class="gedhi">Tanggal Transaksi</label>
                                    <input type="text" value="<?php echo TanggalIndo($hasil_get->tanggal_input); ?>" readonly="true" class="form-control" placeholder="Tanggal Transaksi" name="tanggal_input" id="tanggal_input"/>
                                  </div>

                              </div>
                              <?php 
                                $kode_unit=$hasil_get->position;
                                $unit = $this->db->query("SELECT nama_unit from master_unit where kode_unit='$kode_unit'");
                                $nama = $unit->row();
                              ?>
                              <div class="col-md-2">
                                  <div class="form-group">
                                    <label class="gedhi">Unit</label>
                                    <input type="text" value="<?php echo $nama->nama_unit; ?>" readonly="true" class="form-control"/>
                                  </div>

                              </div>
                            </div> 

                           
                            <div class="box-body">
                              <div class="row">
                                <div class="">
                                  <!-- <div class="col-md-3">
                                    <label>Jenis Bahan</label>
                                    <select name="kategori_bahan" id="kategori_bahan" class="form-control" tabindex="-1" aria-hidden="true">
                                      <option value="" selected="true">--Pilih Jenis Bahan--</option>
                                      <option value="bahan baku">Bahan Baku</option>                     
                                      <option value="bahan jadi">Bahan Jadi</option> 
                                    </select>
                                  </div> -->



                                  
                                  <!--<div class="col-md-2">
                                    <label>Satuan</label>
                                    <input type="text" readonly="true" class="form-control" placeholder="Satuan Pembelian" name="nama_satuan" id="nama_satuan" />
                                    <input type="hidden" name="kode_satuan" id="kode_satuan" />
                                  </div>
                                  <div class="col-md-2">
                                    <label>Harga Satuan</label>
                                    <input type="text" class="form-control" placeholder="Harga Satuan" name="harga_satuan" id="harga_satuan" />
                                    <input type="hidden" name="id_item" id="id_item" />
                                  </div>-->
                                  
                                </div>
                              </div>
                            </div>

                            <div id="list_transaksi_pembelian">
                              <div class="box-body">
                                <table style="font-size:1.5em;" id="tabel_daftar" class="table table-bordered table-striped">
                                  <thead>
                                    <tr>
                                      <th>No</th>
                                      <th>Nama bahan</th>
                                      <th>QTY</th>
                                      <th>Status</th>
                                      <th>Keterangan</th>
                                    </tr>
                                  </thead>
                                  <tbody id="tabel_temp_data_transaksi">
                                  <?php
                                  $no = 1;
                                    $get_opsi_ro = $this->db->query("SELECT * FROM (`opsi_transaksi_ro`) WHERE `kode_ro` = '$kode_ro' 
                                    AND `status_validasi` = 'batal' AND `jenis_bahan` = 'langsung' OR `kode_ro` = '$kode_ro' 
                                    AND `status_validasi` = 'selesai' AND `jenis_bahan` = 'langsung'");
                                    #echo $this->db->last_query();
                                    $hasil_opsi = $get_opsi_ro->result();
                                    foreach ($hasil_opsi as $daftar) {
                                      # code...
                                    
                                  ?>
                                  <tr>
                                  <td><?php echo $no; ?></td>
                                  <td><?php echo $daftar->nama_bahan; ?></td>
                                  <td><?php echo $daftar->jumlah." ".$daftar->nama_satuan; ?></td>
                                  <td><?php echo cek_status_ro($daftar->status_validasi); ?></td>
                                  <td><?php echo $daftar->keterangan; ?></td>
                                  </tr>
                                  <?php $no++; } ?>
                                  </tbody>
                                  <tfoot>
                                    
                                  </tfoot>
                                </table>
                              </div>
                            </div>

                              

                              <br>
                              <div class="box-footer">
                               
                              </div>
                             
                        </form> 
                       
                          </form>
                          <!-- <a onclick="panding()" style="margin-left:5px;width:100px;" class="btn btn-danger pull-right">Panding</a> -->
                         

                      </div>        
                    </div>  

                    
                      
                </div>
            </section><!-- /.Left col -->      
        </div><!-- /.row (main row) -->
       
    </section><!-- /.content -->
        <div class="box-footer clearfix">


        </div>
 
                     <!-- <a class="btn btn-app blue" id="upload_foto">
                        <i class="fa fa-edit"></i> Upload Logo
                      </a>
                    <div class="box_foto_upload"></div>
                    <div class="foto_upload"></div>   
                   -->
  </div>

  </div>
  </div>
  </div>
<style type="text/css" media="screen">
        .btn-back
          {
            position: fixed;
            bottom: 10px;
             left: 10px;
            z-index: 999999999999999;
                vertical-align: middle;
                cursor:pointer
          }
        </style>
                <img class="btn-back" src="<?php echo base_url().'component/img/back_icon.png'?>" style="width: 70px;height: 70px;">

        <script>           $('.btn-back').click(function(){
$(".tunggu").show();
window.location = "<?php echo base_url().'validasi_request_order/daftar'; ?>";
});         </script>

  <!------------------------------------------------------------------------------------------------------>


