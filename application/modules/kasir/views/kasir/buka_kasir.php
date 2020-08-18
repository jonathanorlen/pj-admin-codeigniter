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
            Buka Kasir
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
              <img src="<?php echo base_url() . 'public/images/loading1.gif' ?>" >
            </div>
            <?php
            $user = $this->session->userdata('astrosession');
            $id_kasir = $user->id;
            $tgl = date("Y-m-d");
            $no_belakang = 0;
            $this->db->select_max('kode_transaksi');
            $kode = $this->db->get_where('transaksi_kasir',array('tanggal'=>$tgl));
            $hasil_kode = $kode->row();
                                        #$pecah_kode = explode("_",$hasil_kode_pembelian->kode_pembelian);
                                        #echo $pecah_kode[0];
                                        #echo $pecah_kode[2];
            $this->db->select('kode_kasir');
            $kode_penjualan = $this->db->get('master_setting');
            $hasil_kode_penjualan = $kode_penjualan->row();
            if(count($hasil_kode)==0){
              $no_belakang = 1;
            }
            else{
              $pecah_kode = explode("_",$hasil_kode->kode_transaksi);
              $no_belakang = @$pecah_kode[2]+1;
            }
            $ipaddress = '';
            if (getenv('HTTP_CLIENT_IP'))
              $ipaddress = getenv('HTTP_CLIENT_IP');
            else if(getenv('HTTP_X_FORWARDED_FOR'))
              $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
            else if(getenv('HTTP_X_FORWARDED'))
              $ipaddress = getenv('HTTP_X_FORWARDED');
            else if(getenv('HTTP_FORWARDED_FOR'))
              $ipaddress = getenv('HTTP_FORWARDED_FOR');
            else if(getenv('HTTP_FORWARDED'))
             $ipaddress = getenv('HTTP_FORWARDED');
           else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
          else
            $ipaddress = 'UNKNOWN';

                                       # echo $ipaddress;

          $get_kasir = $this->db->get_where('master_kasir',array('ip'=>$ipaddress));
          $hasil_kasir = $get_kasir->row();
                                      #echo $this->db->last_query();
          $nomor_kasir = $hasil_kasir->kode_kasir;
                                      #  echo $this->db->last_query();
          $this->db->select_max('id');
          $get_max_po = $this->db->get('transaksi_kasir');
          $max_po = $get_max_po->row();

          $this->db->where('id', $max_po->id);
          $get_po = $this->db->get('transaksi_kasir');
          $po = $get_po->row();
          $tahun = substr(@$po->kode_transaksi, 4,4);
          if(date('Y')==$tahun){
            $nomor = substr(@$po->kode_transaksi, 9);
            $nomor = $nomor + 1;
            $string = strlen($nomor);
            if($string == 1){
              $kode_trans = 'KAS_'.date('Y').'_00000'.$nomor;
            } else if($string == 2){
              $kode_trans = 'KAS_'.date('Y').'_0000'.$nomor;
            } else if($string == 3){
              $kode_trans = 'KAS_'.date('Y').'_000'.$nomor;
            } else if($string == 4){
              $kode_trans = 'KAS_'.date('Y').'_00'.$nomor;
            } else if($string == 5){
              $kode_trans = 'KAS_'.date('Y').'_0'.$nomor;
            } else if($string == 6){
              $kode_trans = 'KAS_'.date('Y').'_'.$nomor;
            }
          } else {
            $kode_trans = 'KAS_'.date('Y').'_000001';
          }
          ?> 
          <?php @$hasil_kode_penjualan->kode_kasir."_".date("dmyHis")."_".$nomor_kasir."_".$id_kasir."_".$no_belakang ?>              
          <form id="data_form" method="post">  
            <div class="box-body">            
              <div class="row">
                <div class="form-group  col-xs-5">
                  <label>Kode Kasir</label>
                  <input readonly="true" value="<?php echo $kode_trans ?>" type="text" class="form-control" name="kode_transaksi" />

                </div>

                <div class="form-group col-xs-5">
                  <label>Saldo Awal</label>
                  <div class="input-group">
                    <span id="dibayar">
                      <input onkeyup="rupiah()" type="text" value="" class="form-control" name="saldo_awal" id="dp" />
                    </span>
                    <span id="rupiah" class="input-group-addon">Rp.</span>
                  </div>
                </div>

                <div class="form-group ombo" style="margin-left: 18px;">
                  <input type="hidden" value="" class="form-control" name="petugas" />
                  <input type="hidden" value="<?php echo date("Y-m-d"); ?>" class="form-control" name="tanggal" />
                  <input type="hidden" value="<?php echo date("H:i:s"); ?>" class="form-control" name="check_in" />
                  <input type="hidden" value="open" class="form-control" name="status" />
                </div>
              </div>
              <div class="box-footer">
                <a id="buka_kasir" class="btn btn-primary">Buka Kasir</a>
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
              $("#buka_kasir").click( function() {
                var vv = $(this).serialize();
      // alert(vv);
      var url = "<?php echo base_url(). 'kasir/kasir/buka_kasir'; ?>";  
      $.ajax( {
       type:"POST", 
       url : url,  
       cache :false,  
       data :$("#data_form").serialize(),
       beforeSend : function(){
        $(".loading").show();
      },
      success : function(hasil) {
        $(".loading").hide();
        $(".sukses").html(hasil);
        setTimeout(function(){$('.sukses').html('');
          window.location = "<?php echo base_url() . 'kasir/' ?>";},2000);              
      },  
      error : function(data) {  
        alert(data);  
      }  
    });
      return false;                    
    });
            })
          </script>