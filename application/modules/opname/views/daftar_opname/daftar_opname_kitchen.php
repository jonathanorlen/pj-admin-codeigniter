
<div class="row">      
<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <a class="dashboard-stat dashboard-stat-light blue-soft" id="gudang">
      <div class="visual">
        <i class="glyphicon glyphicon-tasks" ></i>
      </div>
      <div class="details" >
        <div class="number">

        </div>
        <div class="desc">
          Gudang
        </div>
      </div>
    </a>
  </div>
  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <a class="dashboard-stat dashboard-stat-light red-soft"  id="kitchen">
      <div class="visual">
        <i class="glyphicon glyphicon-shopping-cart"></i>
      </div>
      <div class="details">
        <div class="number">

        </div>
        <div class="desc">
          Kitchen
        </div>
      </div>
    </a>
  </div>
  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <a class="dashboard-stat dashboard-stat-light green-soft"  id="bar">
      <div class="visual">
        <i class="glyphicon glyphicon-shopping-cart"></i>
      </div>
      <div class="details">
        <div class="number">

        </div>
        <div class="desc">
          Bar
        </div>
      </div>
    </a>
  </div>
  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <a class="dashboard-stat dashboard-stat-light purple-soft"  id="serve">
      <div class="visual">
        <i class="glyphicon glyphicon-shopping-cart"></i>
      </div>
      <div class="details">
        <div class="number">

        </div>
        <div class="desc">
          Server
        </div>
      </div>
    </a>
  </div> 
  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
         Daftar Opname Kitchen
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
          <a style="padding:13px; margin-bottom:10px;width: 100px" class="btn btn-app green" href="<?php echo base_url().'stok/kitchen'; ?>"><i class="fa fa-edit"></i> Stok </a>
          <a style="padding:13px; margin-bottom:10px;width: 100px" class="btn btn-app blue" href="<?php echo base_url().'spoil/kitchen'; ?>"><i class="fa fa-edit"></i> Spoil </a>
    <!-- <a style="padding:13px; margin-bottom:10px;" class="btn btn-app red" href="<?php echo base_url().'retur_pembelian/kitchen'; ?>"><i class="fa fa-edit"></i> Retur </a>
  -->
  <a style="padding:13px; margin-bottom:10px;width: 100px" class="btn btn-app red" href="<?php echo base_url().'mutasi/kitchen'; ?>"><i class="fa fa-edit"></i> Mutasi </a>
  <a style="padding:13px; margin-bottom:10px;width: 100px" class="btn btn-warning" href="<?php echo base_url().'opname/kitchen'; ?>"><i class="fa fa-edit"></i> Opname </a>
  <div class="row">
          <div class="col-md-12">
            <!--  <a style="padding:13px; margin-bottom:10px;" class="btn btn-app green" href="<?php echo base_url() . 'opname/tambah_opname/01' ?>"><i class="fa fa-edit"></i> Tambah </a> -->
      <!-- a style="padding:13px; margin-bottom:10px;" class="btn btn-app blue" href="<?php echo base_url() . 'opname/daftar_opname/01' ?>"><i class="fa fa-list"></i> Daftar </a> -->
          </div>
          </div>
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
              <button style="width: 147px" type="button" class="btn btn-warning pull-right" id="cari"><i class="fa fa-search"></i> Cari</button>
            </div>
          </div><br>
          <div id="cari_transaksi">
          <table class="table table-striped table-hover table-bordered" id="tabel_daftar"  style="font-size:1.5em;">
            <thead>
              <tr>
                <th>No</th>
                <th>Kode Opname</th>
                <th>Tanggal Opname</th>
                <th>Petugas</th>
                <th>Status Validasi</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $kode_default = $this->db->get('setting_kitchen');
              $hasil_unit =$kode_default->row();
              $param=$hasil_unit->kode_unit;
              //$param =$this->uri->segment(3);
              $opname = $this->db->get_where('transaksi_opname',array('kode_unit' => $param));
              $list_opname = $opname->result();
              $nomor = 1;  

              foreach($list_opname as $daftar){ 
                ?> 
                <tr>
                  <td><?php echo @$nomor; ?></td>
                  <td><?php echo @$daftar->kode_opname; ?></td>
                  <td><?php echo @$daftar->tanggal_opname; ?></td>
                  <td><?php echo @$daftar->petugas; ?></td>
                  <td><?php echo @$daftar->validasi; ?></td>
                  <td align="center">
                    <?php 
                    if (@$daftar->validasi == 'confirmed') {
                      echo '-';
                    } else {
                      echo get_validasi_opname_kitchen($param,@$daftar->kode_opname);
                    }
                    ?>
                  </td>
                </tr>
                <?php 
                $nomor++; 
              } 
              ?>

            </tbody>
            <tfoot>
              <tr>
                <th>No</th>
                <th>Kode Opname</th>
                <th>Tanggal Opname</th>
                <th>Petugas</th>
                <th>Status Validasi</th>
                <th>Action</th>
              </tr>
            </tfoot>                
          </table>
          </div>
        </div>
      </div>
    </div>
    <input type="hidden" name="kode_unit" id="kode_unit" value="<?php echo $param;?>">
  </div><!-- /.col -->
</div>
</div>    
</div>  


<div id="modal-confirm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color:grey">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title" style="color:#fff;">Konfirmasi Hapus Data</h4>
      </div>
      <div class="modal-body">
        <span style="font-weight:bold; font-size:14pt">Apakah anda yakin akan menghapus data menu tersebut ?</span>
        <input id="id-delete" type="hidden">
      </div>
      <div class="modal-footer" style="background-color:#eee">
        <button class="btn green" data-dismiss="modal" aria-hidden="true">Tidak</button>
        <button onclick="delData()" class="btn red">Ya</button>
      </div>
    </div>
  </div>
</div>
<script src="<?php echo base_url().'component/lib/jquery.min.js'?>"></script>
<script src="<?php echo base_url().'component/lib/zebra_datepicker.js'?>"></script>
<link rel="stylesheet" href="<?php echo base_url().'component/lib/css/default.css'?>"/>
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
      url : "<?php echo base_url().'opname/cari_opname_kitchen'; ?>",  
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
<script>


  $(document).ready(function(){
   $("#tabel_daftar").dataTable({
    "paging":   false,
    "ordering": false,
    "info":     false
  });
   $("#gudang").click(function(){
    window.location = "<?php echo base_url() . 'stok/gudang' ?>";

  });

   $("#bar").click(function(){
    window.location = "<?php echo base_url() . 'stok/bar' ?>";
  });

   $("#kitchen").click(function(){
    window.location = "<?php echo base_url() . 'stok/kitchen' ?>";
  });

   $("#serve").click(function(){
    window.location = "<?php echo base_url() . 'stok/server' ?>";
  });
 })


</script>