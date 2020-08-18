
<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Pre Order
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

        <a style="padding:13px; margin-bottom:10px" class="btn btn-app green" href="<?php echo base_url().'pre_order/pendaftaran'; ?>">
              <i class="fa fa-plus"></i> Tambah PO
            </a>
            
            <a style="padding:13px; margin-bottom:10px" class="btn btn-app blue" href="<?php echo base_url().'pre_order/daftar'; ?>">
              <i class="fa fa-list"></i> Daftar PO
            </a>

        <div class="box-body">            
          <div class="sukses" ></div>
                  <div class="row">
        
          <div class="col-md-5" id="">
                  <div class="input-group">
                      <span class="input-group-addon">Tanggal Awal</span>
                      <input type="text" class="form-control tgl" id="tgl_awal">
                  </div>
                </div>
               
                <div class="col-md-5" id="">
                    <div class="input-group">
                        <span class="input-group-addon">Tanggal Akhir</span>
                        <input type="text" class="form-control tgl" id="tgl_akhir">
                    </div>
                </div>                        
                  <div class="col-md-2 pull-left">
                    <button style="width: 178px" type="button" class="btn btn-warning pull-right" id="cari"><i class="fa fa-search"></i> Cari</button>
                  </div>
           <div id="cari_transaksi">
            <section class="col-md-12">
              <?php
                      $this->db->select('*');
                      $total = $this->db->get_where('transaksi_po');
                      $hasil_total = $total->num_rows();
                      
                  ?>
                  <div class="row">
               <br><br>
              <div class="col-md-2 pull-right">
              <div class="" style="background-color: #428bca ;width:auto;">
                            <a style="padding:13px; margin-bottom:10px;color:white;margin-left:0px;" class="btn"> Total Transaksi PO : <span style="font-size:20px;"><?php echo $hasil_total; ?></span></a>
                             
              </div>
              </div>
            </div>
              <br>
                <div class="box box-info">
                    <div class="box-header">
                        <!-- tools box -->
                        <div class="pull-right box-tools"></div><!-- /. tools -->
                    </div>
                    <?php 
                                $user = $this->session->userdata('astrosession');
                               //print_r($user);
                                $modul = $user->uname;
                                
                              ?>
                             
                              
                    <div class="box-body">            
                        <div class="sukses" ></div>
                        <table id="tabel_daftar" class="table table-bordered table-striped">
                            <?php
                              $po = $this->db->query("SELECT * from transaksi_po");
                              $hasil_po = $po->result();
                            ?>
                            <thead>
                              <tr>
                                <th>No</th>
                                <th>Kode Pembelian</th>
                                <th>Tanggal Pembelian</th>
                                <th>Unit</th>
                                <th>Petugas</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $nomor = 1;

                                    foreach($hasil_po as $daftar){ ?> 
                                    <tr style="font-size: 15px;">
                                      <td><?php echo $nomor; ?></td>
                                      <td><?php echo @$daftar->kode_po; ?></td>
                                      <td><?php echo TanggalIndo(@$daftar->tanggal_input);?></td>
                                      <td>
                                        <?php
                                            $get_nama_unit = $this->db->get_where('master_unit',array('kode_unit'=>$daftar->position));
                                            $hasil_nama_unit = $get_nama_unit->row();
                                            echo $hasil_nama_unit->nama_unit;   
                                        ?>
                                      </td>
                                      <td><?php echo @$daftar->petugas; ?></td>
                                      <td align="center"><?php echo get_detail_print($daftar->kode_po); ?></td>
                                    </tr>
                                <?php $nomor++; } ?>
                               
                            </tbody>
                             
                        </table>
                   
            </section><!-- /.Left col -->  
            </div>    
        </div><!-- /.row (main row) -->
         <input type="hidden" name="kode_unit" id="kode_unit" value="U001">
        </div>
         
          <!------------------------------------------------------------------------------------------------------>

        </div>
      </div>
    </div><!-- /.col -->
  </div>
</div>    
</div>  
<script src="<?php echo base_url().'component/lib/jquery.min.js'?>"></script>
<script src="<?php echo base_url().'component/lib/zebra_datepicker.js'?>"></script>
<link rel="stylesheet" href="<?php echo base_url().'component/lib/css/default.css'?>"/>
<script type="text/javascript">
  $(document).ready(function() {

  
  $("#tabel_daftar").dataTable({
    "paging":   false,
    "ordering": true,
     "searching": false,
    "info":     false
  });
} );
</script>
<script type="text/javascript">

       $('.tgl').Zebra_DatePicker({});


  $('#cari').click(function(){

      var tgl_awal =$("#tgl_awal").val();
      var tgl_akhir =$("#tgl_akhir").val();
      var kode_unit =$("#kode_unit").val();
      if (tgl_awal=='' || tgl_akhir==''){ 
        alert('Masukan Tanggal Awal & Tanggal Akhir..!')
      }
      else{
    $.ajax( {  
        type :"post",  
        url : "<?php echo base_url().'pre_order/cari_order'; ?>",  
        cache :false,
        beforeSend:function(){
          $(".tunggu").show();  
        },  
        data : {tgl_awal:tgl_awal,tgl_akhir:tgl_akhir,kode_unit:kode_unit},
        beforeSend:function(){
          $(".tunggu").show();  
        },
 success : function(data) {
           $(".tunggu").hide();  
             $("#cari_transaksi").html(data);
        },  
        error : function(data) {  
         // alert("das");  
        }  
      });
    }
   
    $('#tgl_awal').val('');
    $('#tgl_akhir').val('');

  });
</script>