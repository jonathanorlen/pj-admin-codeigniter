
<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Daftar PO
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
                $total = $this->db->get_where('transaksi_po',array('position' => 'U001', 'status' => 'menunggu'));
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
                    $bulan_ini = date('Y-m');
                    $po = $this->db->query("SELECT * from transaksi_po where position='U001' and status='menunggu' and tanggal_input like '%".$bulan_ini."%'");
                    $hasil_po = $po->result();
                    ?>
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Kode PO</th>
                        <th>Tanggal Pembelian</th>
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
                        <td><?php echo @$daftar->kode_transaksi; ?></td>
                        <td><?php echo TanggalIndo(@$daftar->tanggal_input);?></td>
                        <td><?php echo @$daftar->petugas; ?></td>
                        <td align="center">
                          <!-- <?php
                          $opsi_po=$this->db->get_where('opsi_transaksi_po',array('kode_po' => $daftar->kode_po,'status' =>'Belum Datang'));
                          $hasil_opsi_po=$opsi_po->result();
                          $belum_datang=count($hasil_opsi_po);
                          if($belum_datang > 0){
                            ?>
                            <a href="edit/<?php echo $daftar->kode_po;?>" id="edit" data-toggle="tooltip" title="Edit" class="btn btn-icon-only btn-circle yellow"><i class="fa fa-pencil"></i></a>
                            <?php
                          }
                          ?>
                          <?php echo get_detail_print($daftar->kode_po); ?> -->
                           <?php echo get_detail_print_edit($daftar->kode_po); ?>

                        </td>
                      </tr>
                      <?php $nomor++; } ?>

                    </tbody>

                  </table>

                </section><!-- /.Left col -->  
              </div> 
              <input type="hidden" name="kode_unit" id="kode_unit" value="U001">   
            </div><!-- /.row (main row) -->
          </div>

          <!------------------------------------------------------------------------------------------------------>

        </div>
      </div>
    </div><!-- /.col -->
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

<script>
  $('.btn-back').click(function(){
    $(".tunggu").show();
    window.location = "<?php echo base_url().'pembelian/daftar_pembelian'; ?>";
  });
</script>  
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