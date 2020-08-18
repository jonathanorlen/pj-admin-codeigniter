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
    <section style="margin-left: 40px;" class="content-header">
    <?php
        $user = $this->session->userdata('astrosession');
      ?>
    <h1 style="font-size:30px; font-weight:bold"><?php echo ucfirst($user->uname);?></h1><div style="font-size:30px; font-weight:bold" id="clock"></div>
    
  </section>
    <section class="col-lg-12 connectedSortable">
    <div style="margin: 20px;" class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Tutup Kasir
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
          <div class="loading" style="z-index:9999999999999999; background:rgba(255,255,255,0.8); width:100%; height:100%; position:fixed; top:0; left:0; text-align:center; padding-top:25%; display:none" >
                          <img src="<?php echo base_url() . '/public/img/loading.gif' ?>" >
                        </div>
          <?php
        $kode_kasir = $this->uri->segment(4);
        $kasir = $this->db->get_where('transaksi_kasir',array('kode_transaksi'=>$kode_kasir));
        $hasil_kasir = $kasir->row();
        ?>
                    <form id="data_form" method="post">  
          <div class="box-body">            
            <div class="row">
              <div class="form-group  col-xs-5">
                <label>Kode Kasir</label>
                <input readonly="true" value="<?php echo $kode_kasir; ?>" type="text" class="form-control" name="kode_transaksi" />

              </div>


              <?php
              $this->db->select_sum('grand_total');
              $penjualan = $this->db->get_where('transaksi_penjualan',array('kode_kasir'=>$kode_kasir));
              $hasil_penjualan_kasir = $penjualan->row();

              ?>

              <input readonly="true" value="<?php echo ($hasil_penjualan_kasir->grand_total); ?>" type="hidden" name="nominal_penjualan" class="form-control" />



              <input readonly="true" value="<?php echo format_rupiah($hasil_kasir->saldo_awal); ?>" type="hidden" class="form-control" />
              <?php
              $this->db->select_sum('subtotal');
              $penjualan = $this->db->get_where('opsi_transaksi_penjualan',array('kode_kasir'=>$kode_kasir));
              $hasil_penjualan = $penjualan->row();
                                #echo $hasil_penjualan->subtotal;
              ?>

              <input type="hidden" name="saldo_sebenarnya" value="<?php echo $hasil_kasir->saldo_awal + $hasil_penjualan_kasir->grand_total;  ?>" class="form-control" />
              <div class="form-group col-xs-5" style="display:none;">
                <label>Setoran Teh Racek</label>
                <?php
                $this->db->select_sum('subtotal');
                $penjualan_tambahan = $this->db->get_where('opsi_transaksi_penjualan',array('kode_kasir'=>$kode_kasir,
                  'status_menu'=>'tambahan'));
                $hasil_penjualan_tambahan = $penjualan_tambahan->row();

                ?>
                <input readonly="true" type="text" value="<?php echo format_rupiah($hasil_penjualan_tambahan->subtotal); ?>" class="form-control"/>
                <input readonly="true" type="hidden" value="<?php echo ($hasil_penjualan_tambahan->subtotal); ?>" class="form-control" name="nominal_tambahan"/>
              </div>                       
              <div class="form-group col-xs-5">
                <label>Saldo Laporan Kasir</label>
                <div class="input-group">
                  <span id="dibayar">
                    <input onkeyup="rupiah()" type="text" value="" class="form-control" name="saldo_akhir" id="dp" />
                  </span>
                  <span id="rupiah" class="input-group-addon">Rp.</span>
                </div>
              </div>
              <input readonly="true" type="hidden" value="<?php echo format_rupiah($hasil_kasir->saldo_akhir - ($hasil_kasir->saldo_awal + $hasil_penjualan_kasir->grand_total) ) ;  ?>" class="form-control" name="selisih" id="dp" />
              <div class="form-group ombo" style="margin-left: 18px;">
                <input type="hidden" value="<?php echo $hasil_kasir->petugas; ?>" class="form-control" name="petugas" />
                <input type="hidden" value="<?php echo date("H:i:s"); ?>" class="form-control" name="check_out" />
                <input type="hidden" value="close" class="form-control" name="status" />
              </div>
            </div>
            <div class="box-footer">
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
          </div>
        </form>
                      
          
        </div>
        
        <!------------------------------------------------------------------------------------------------------>

      </div>
    </div>
      <!-- /.row (main row) -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<script type="text/javascript">
  $(document).ready(function(){
    $(".select2").select2();
  });
</script>
<script>
function startTime() {
              var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
              var hari = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
              var date = new Date();
              var day = date.getDate();
              var hari_ini = date.getDay();
              var month = date.getMonth();
              var yy = date.getYear();
              var year = (yy < 1000) ? yy + 1900 : yy;
              //document.write(day + " " + months[month] + " " + year);
              var today=new Date(),
              curr_hour=today.getHours(),
              curr_min=today.getMinutes(),
              curr_sec=today.getSeconds();
              curr_hour=checkTime(curr_hour);
              curr_min=checkTime(curr_min);
              curr_sec=checkTime(curr_sec);
              document.getElementById('clock').innerHTML=hari[hari_ini]+", "+day + " " + months[month] + " " + year+" || "+curr_hour+":"+curr_min+":"+curr_sec;
            }
            function checkTime(i) {
              if (i<10) {
                i="0" + i;
              }
              return i;
            }
            setInterval(startTime, 500);

  function rupiah(){
    var rupiah = $("#dp").val();
    var url = "<?php echo base_url().'kasir/diskon_all' ?>";
    $.ajax({
      type:"post",
      url:url,
      data:{rupiah:rupiah},
      success:function(data){
        $("#rupiah").text(data);
      }
    })
  }

  $(function(){
    $("#data_form").submit( function() {
       /* var vv = $(this).serialize();
       alert(vv);*/
       var url = "<?php echo base_url(). 'kasir/simpan_tutup_kasir'; ?>";  
       $.ajax( {
         type:"POST", 
         url : url,  
         cache :false,  
         data :$(this).serialize(),
         beforeSend: function(){
           $(".loading").show(); 
         },
          beforeSend:function(){
          $(".tunggu").show();  
        },
 success : function(data) {
          setTimeout(function(){$('.sukses').html('');window.location = "<?php echo base_url() . 'kasir/' ?>";},1000); 
          $(".loading").hide();             
        },  
        error : function(data) {  
          alert(data);  
        }  
      });
       return false;                    
     });
  })
</script>