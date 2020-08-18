

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->

  <style type="text/css">
   .ombo{
    width: 400px;
  } 

</style>    
<!-- Main content -->
<section class="content">             
  <!-- Main row -->

  <div class="row">
    <!-- Left col -->
    <section class="col-lg-12 connectedSortable">
      <div class="portlet box blue">
        <div class="portlet-title">
          <div class="caption">
            Daftar Piutang
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
                <button style="width: 147px" type="button" class="btn btn-warning pull-right" id="cari"><i class="fa fa-search"></i> Cari</button>
              </div>
            </div><br>
            <div id="cari_transaksi">
              <table style="font-size: 1.5em;" id="tabel_daftar" class="table table-striped table-hover table-bordered">
                <?php
                              $this->db->group_by('kode_customer');/*
                              $this->db->order_by('sisa','desc');*/
                              $this->db->order_by('nama_customer', 'asc');
                              $this->db->order_by('tanggal_transaksi','desc');
                              $hutang = $this->db->get_where('transaksi_piutang',array('sisa >' => 0));
                              $hasil_hutang = $hutang->result();
                              ?>
                              <thead>
                                <tr>
                                  <th>No</th>
                                  <th>Customer</th>
                                  <th>Nominal Piutang</th>
                                  <th>Sisa</th>
                                  <th>Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                $nomor = 1;
                                // Select Nz(sum(Xcolumn), 0) from [Xtable] where id = "1234"
                                foreach($hasil_hutang as $daftar){ 

                                  $this->db->where('kode_customer', $daftar->kode_customer);
                                  $this->db->where('sisa', $daftar->sisa);
                                  $this->db->select('SUM(nominal_piutang) as piutang, SUM(sisa) as sisa');
                                  //$this->db->select('(SUM(sisa),)');
                                  $get_total = $this->db->get_where('transaksi_piutang');
                                  $hasil_total = $get_total->row();
                                  $tgl = ($daftar->tanggal_transaksi=='0000-00-00' || empty($daftar->tanggal_transaksi)) ? '-' : @TanggalIndo(@$daftar->tanggal_transaksi) ;
                                  ?> 
                                  <tr class=" <?php if($daftar->sisa !='0'){ echo "danger"; } ?>">
                                    <td><?php echo $nomor; ?></td>
                                    <td><?php echo @$daftar->nama_customer; ?></td>
                                    <td><?php echo format_rupiah(@$hasil_total->piutang); ?></td>
                                    <td><?php echo format_rupiah(@$hasil_total->sisa); ?></td>
                                    <td><?php echo get_detail_hut($daftar->kode_customer)?></td>
                                  </tr>
                                  <?php $nomor++; } ?>

                                </tbody>
                                <tfoot>
                                  <tr>
                                    <th>No</th>
                                    <th>Customer</th>
                                    <th>Nominal Piutang</th>
                                    <th>Sisa</th>
                                    <th>Action</th>
                                  </tr>
                                </tfoot>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                    </section> 
                  </div>
                </section> 
              </div>
              <script type="text/javascript">
                $(document).ready(function() {

                 $("#tabel_daftar").dataTable({
                  "paging":   false,
                  "ordering": true,
                  "info":     false
                });   
               } );
             </script>
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
                window.location = "<?php echo base_url().'keuangan'; ?>";
              });
            </script>
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
                    url : "<?php echo base_url().'hutang_piutang/piutang/cari_daftar_piutang'; ?>",  
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
