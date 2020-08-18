<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    
<style type="text/css">
 .ombo{
  width: 600px;
 } 
</style>    
    <!-- Main content -->
    <section class="content">             
      <!-- Main row -->
      
      
        <div class="row">
        <!-- Left col -->
            <section class="col-lg-12 connectedSortable">
            <div class="portlet box grey-steel">
      <div class="portlet-title">
        <div class="caption">
          <span style="font-size: large; color: black;" class="pull-left">Bayar Personal Meja <?php echo $this->uri->segment(3); ?></span>
            <div style="margin-left: 540px;">
               <!-- <a onclick="$('#modal-pindah').modal('show')" class="btn red btn-sm"><i class="icon-share"></i> Pindah Meja</a>
               <a onclick="$('#modal-gabung').modal('show')" class="btn dark btn-sm"><i class="icon-resize-small"></i> Gabung Meja</a>
               <a onclick="print('order-list')" class="btn yellow btn-sm" <?php echo ($meja=='Take-away') ? 'style="display:none"':'' ?>>
                  <i class="icon-print"></i> Pesan
               </a> -->
               
               </div>
        </div>
        
      </div>
      <div class="portlet-body">
        <!------------------------------------------------------------------------------------------------------>
        <?php
                            $kode_meja = $this->uri->segment(3);
                            $tgl = date("Y-m-d");
                            $get_menu = $this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_meja'=>$kode_meja));
                            $hasil_menu = $get_menu->result_array();
                                        
                                        #echo $this->db->last_query();
                                    ?>
                                    
                                    <input readonly="true" type="hidden" value="<?php echo @$hasil_menu[0]['kode_penjualan']; ?>" placeholder="Kode Transaksi" name="kode_penjualan" id="kode_penjualan" />
                                    
                                    <?php
                                        $user = $this->session->userdata('astrosession');
                                        $tgl = date("Y-m-d");
                                        $no_belakang = 0;
                                        $this->db->select_max('kode_penjualan');
                                        $kode = $this->db->get_where('transaksi_penjualan',array('tanggal_penjualan'=>$tgl));
                                        $hasil_kode = $kode->row();
                                        #$pecah_kode = explode("_",$hasil_kode_pembelian->kode_pembelian);
                                        #echo $pecah_kode[0];
                                        #echo $pecah_kode[2];
                                        $this->db->select('kode_penjualan');
                                        $kode_penjualan = $this->db->get('master_setting');
                                        $hasil_kode_penjualan = $kode_penjualan->row();
                                        if(count($hasil_kode)==0){
                                            $no_belakang = 1;
                                        }
                                        else{
                                            $pecah_kode = explode("_",$hasil_kode->kode_penjualan);
                                            $no_belakang = @$pecah_kode[2]+1;
                                        }
                                        $this->db->select_max('kode_transaksi');
                                        $kasir = $this->db->get_where('transaksi_kasir',array('tanggal'=>$tgl,'status'=>"open"));
                                        $hasil_cek_kasir = $kasir->row();
                                        #echo $this->db->last_query();
                                        
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
                                        #echo $this->db->last_query();
                                    ?>
                                    <input readonly="true" type="hidden" value="<?php echo @$hasil_kode_penjualan->kode_penjualan."_".date("dmyHis")."_".$nomor_kasir."_".$user->id."_".$no_belakang ?>"  name="kode_penjualan" id="kode_penjualan_baru" />
                                    <input type="hidden" name="kode_meja" id="kode_meja" value="<?php echo @$kode_meja; ?>" />
                                    <?php
                                         $this->db->select_max('kode_transaksi');
                                        $kasir = $this->db->get_where('transaksi_kasir',array('tanggal'=>$tgl,'status'=>"open"));
                                        $hasil_cek_kasir = $kasir->row();
                                    ?>
                                    <input type="hidden" id="kode_kasir" value="<?php echo $hasil_cek_kasir->kode_transaksi; ?>" />
                                    <input type="hidden" value="<?php echo TanggalIndo(date("Y-m-d")); ?>" readonly="true"  placeholder="Tanggal Transaksi" name="tanggal_pembelian" id="tanggal_penjualan"/>
                  

        <div class="box-body">            
          
                        <div class="loading" style="z-index:9999999999999999; background:rgba(255,255,255,0.8); width:100%; height:100%; position:fixed; top:0; left:0; text-align:center; padding-top:25%; display:none" >
                          <img src="<?php echo base_url() . '/public/img/loading.gif' ?>" >
                        </div>
                        <div class="sukses"></div>
        <div class="row">
       <div class="col-md-8">
                    <table id="" class="table table-striped table-bordered table-advance table-hover">
                            <tbody>
                                <form id="panelForm">
                                <tr>
                                    <td style="background-color:#229fcd;">
                                        <input type="text" name="id_penjualan" id="id_penjualan" value="" hidden/>
                                        <?php
                                            $menu_resto = $this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_meja'=>$kode_meja,'status !='=>'personal'));
                                            $hasil_menu = $menu_resto->result();
                                        ?>
                                        <select name="menu" onchange="get_harga()" id="menu" class="form-control">
                                         <option value="" selected="true">--Pilih Menu--</option>
                                          <?php
                                            foreach($hasil_menu as $daftar){
                                         ?>
                                         <option value="<?php echo $daftar->kode_menu; ?>"><?php echo $daftar->nama_menu; ?></option>
                                         <?php } ?>
                                         </select>
                                    </td>
                                    
                                    <td width="100px" style="background-color:#229fcd;">
                                    
                                    <input type="text" name="qty" id="qty" class="form-control" placeholder="jumlah"/>
                                    <input type="hidden" id="kode_kasir" value="<?php echo $hasil_cek_kasir->kode_transaksi; ?>" />
                                    <input type="hidden" name="qty" id="qty2" class="form-control" placeholder="jumlah"></td>
                                    <td width="100px" style="background-color:#229fcd;"><input readonly="true" type="text" name="harga" id="harga" class="form-control" placeholder="harga"></td>
                                    <td width="100px" style="background-color:#229fcd;">
                                    <input type="text" name="diskon" id="diskon_item" class="form-control" placeholder="diskon" value="0">
                                    <input type="hidden" name="kode_edit_penjualan" id="kode_edit_penjualan" />
                                    </td>
                                    <td width="100px"style="background-color:#229fcd;" >
                                        <div onclick="simpan_pesanan_temp()" class="btn purple">Add</div>
                                        
                                    </td>
                                </tr>
                                </form>
                            </tbody>
                        </table>
                        </div>
                        <div class="col-md-8">
                        <table style="white-space: nowrap; font-size: 1.5em;" id="data" class="table table-bordered  table-hover">
                            <thead>
                                <tr>
                                    <th style="background-color:#229fcd; color:white" class="text-center" width="50px">No.</th>
                                    <th style="background-color:#229fcd; color:white" class="text-center">Nama Produk</th>
                                    
                                    <th style="background-color:#229fcd; color:white" class="text-center" width="50px">Qty</th>
                                    <th style="background-color:#229fcd; color:white" class="text-center" width="125px">Harga</th>
                                    <th style="background-color:#229fcd; color:white" class="text-center" width="125px">Subtotal</th>
                                    <th style="background-color:#229fcd; color:white" class="text-center" width="100px">Diskon (%)</th>
                                    <th style="background-color:#229fcd; color:white" class="text-center" width="170px">Action</th>
                                </tr>
                            </thead>
                            <tbody id="tb_pesan_temp">
                            <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            </tr>
                            </tbody>
                            <tfoot>
                            </tfoot>
                        </table>
                        <div class="form-group col-md-6">
                              <div class="input-group">
                                <span class="input-group-addon">Diskon(%)</span>
                                <span id="dibayar">
                                  <input type="text" onkeyup="diskon_persen()" class="form-control" name="persen" id="persen" />
                                </span>
                              </div>
                            </div>
                            <div class="form-group col-md-6">
                              <div class="input-group">
                                <span class="input-group-addon">Diskon(Rp)</span>
                                <span id="dibayar">
                                  <input type="text" onkeyup="diskon_rupiah()" class="form-control" name="rupiah" id="rupiah" />
                                </span>
                              </div>
                            </div>
                            
                        </div>
                        
                <div style="margin-top: -70px;" class="col-md-4">
                        <div class="bg-yellow" style="height:40px; padding: 0px 10px 0px 10px; margin-bottom:5px">
                            <span style="font-size:22px; " class="pull-right" id="total_pesanan"></span>
                            
                            <p style="font-size: 18px;">Total Pesanan</p>
                        </div>
                        <div class="bg-red" style="height:40px; padding: 0px 10px 0px 10px; margin-bottom:5px">
                            <span style="font-size:22px; " class="pull-right" id="diskon_all">Rp 0</span>
                            <i style="font-size:56px; margin-top:5px"></i>
                            <p style="font-size: 18px;">Discount</p>
                        </div>
                        <div class="bg-blue" style="height:40px; padding: 0px 10px 0px 10px; margin-bottom:5px">
                            <span style="font-size:22px; " class="pull-right" id="grand_total">Rp 0</span>
                            <i style="font-size:56px; margin-top:5px"></i>
                            <p style="font-size: 18px;">Grand Total</p>
                        </div>
                        <div style="">
                            <div class="form-group">
                              <div class="input-group">
                                <span class="input-group-addon">Kode Member</span>
                                <span>
                                  <input onkeyup="get_member()" type="text" class="form-control" name="kode_member" id="kode_member" />
                                </span>
                                
                              </div>
                            </div>
                        </div>
                        <div style="">
                            <div class="form-group">
                              <div class="input-group">
                                <span class="input-group-addon">Nama Member</span>
                                <span>
                                  <input readonly="true" type="text" class="form-control" name="nama_member" id="nama_member" />
                                </span>
                                
                              </div>
                            </div>
                        </div>
                        
                        <div style="height:60px; margin-bottom:5px">
                            <div style="height: 40px;" class="form-group">
                              <div class="input-group">
                                <span class="input-group-addon">Jenis Transaksi</span>
                                <span id="golongan">
                                  <select class="form-control" id="jenis_transaksi" name="jenis_transaksi">
                                    <option selected="true" value="tunai">Tunai</option>
                                    <option value="debet">Debet</option>
                                    <option value="kredit">Kredit</option>
                                    <option value="compliment">Compliment</option>
                                  </select>
                                </span>
                              </div>
                            </div>
                        </div>
                        <div style="height:60px; margin-top: -20px;">
                            <div class="form-group">
                              <div class="input-group">
                                <span class="input-group-addon" style="font-size: x-large;font-weight: bolder;"><strong>Dibayar</strong></span>
                                <span id="dibayar">
                                  <input type="hidden" id="total_no" />
                                  <input type="hidden" id="total2" />
                                  <input type="hidden" id="kembalian2" />
                                  <input style="font-size: 30px;" onkeyup="kembalian()" type="text" class="form-control input-lg" name="bayar" id="bayar" />
                                </span>
                              </div>
                            </div>
                        </div>
                        
                        <div class="bg-purple" style="height:40px; padding: 0px 10px 0px 10px; margin-top:-5px">
                            <span style="font-size:26px; " class="pull-right totalDiskon" id="kembalian">Rp 0</span>
                            <i style="font-size:56px; margin-top:5px"></i>
                            <p style="font-size: 18px;">Kembalian</p>
                        </div>
                        
                        
                        
            
            
            
                        
                        <!--<div class="bg-green" style="height:55px; padding: 10px 10px 0px 10px; margin-top:35px">
                            <button class="btn btn-large btn-default" style="width:100%" onClick="list_suspend()">LIST PESANAN</button>
                        </div>-->
                    </div><br />
                    <div id="rupiah_bayar" style="padding-left: 500px;margin-top:-100px;font-size:35px" class="pull-right col-md-12">
                     
                    </div>
              </div>
              <div class="row">
                
                <div class="col-md-8">
                    <input type="hidden" id="id_meja" value="<?php echo $this->uri->segment(3); ?>" />
                    
                    <a id="buka" style="width: 300px;" onclick="bukameja()" class="btn btn-lg blue" href="#">
              <i class="fa fa-sign-in"></i> Buka Meja
            </a>
            <?php $kode_meja = $this->uri->segment(3); if(!empty($kode_meja)){ ?>
            <a id="tutup" style="width: 300px;" onclick="tutupmeja()" class="btn btn-lg red" href="#">
              <i class="fa fa-eject"></i> Tutup Meja
            </a>
            <?php } ?>
            <input type="hidden" id="hasil_meja" />
            </div>
            
            
              </div>
              <br /><br />
              <div class="row">
              
            
              <div class="col-lg-12">
                <a style="text-decoration: none;" onclick="bayar()"  class="bg-green col-md-12">
                            <center><span style="font-size:35px; font-weight: bold; "><i style="font-size: 35px;" class="fa fa-money"></i> Bayar</span></center>	
                        </a>
              </div>
              
              </div><br /><br />
              <div class="row">
                <div class="col-lg-12">
                <a href="<?php echo base_url().'kasir/menu_kasir/'.$this->uri->segment(3); ?>"  class="blue-steel btn col-md-12">
                            <center><span style="font-size:35px; font-weight: bold; "><i style="font-size: 35px;" class="fa fa-arrow-left"></i> Kembali</span></center>	
                        </a>
              </div>
              </div>
                               
                        
                        
        
        <!------------------------------------------------------------------------------------------------------>

      </div>
    </div>
            
                <!-- /.row (main row) -->
    </section><!-- /.content -->
</div>
            
                       
                    </div>  
                </div>
            </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<div id="modal-confirm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color:grey">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title" style="color:#fff;">Konfirmasi Hapus Data</h4>
            </div>
            <div class="modal-body">
                <span style="font-weight:bold; font-size:12pt">Apakah anda yakin akan menghapus pembayaran personal pesanan tersebut ?</span>
                <input id="id-delete" type="hidden">
            </div>
            <div class="modal-footer" style="background-color:#eee">
                <button class="btn green" data-dismiss="modal" aria-hidden="true">Tidak</button>
                <button onclick="delData()" class="btn red">Ya</button>
            </div>
        </div>
    </div>
</div>

<div id="modal-confirm-bayar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color:grey">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title" style="color:#fff;">Konfirmasi Pembayaran</h4>
            </div>
            <div class="modal-body">
                <span style="font-weight:bold; font-size:12pt">Apakah anda yakin akan dengan nominal pembayaran tersebut ?</span>
                <input id="no" type="hidden">
            </div>
            <div class="modal-footer" style="background-color:#eee">
                <button id="tidak" class="btn green" data-dismiss="modal" aria-hidden="true">Tidak</button>
                <button id="ya" onclick="bayar()" class="btn red">Ya</button>
            </div>
        </div>
    </div>
</div>


<script>
function tutupmeja(){
    var url = "<?php echo base_url().'kasir/tutup_meja'; ?>";
    var id_meja = $("#id_meja").val();
    $.ajax( {
       type:"POST", 
        url : url,  
        cache :false,  
        data :{id_meja:id_meja},
        beforeSend:function(){
          $(".tunggu").show();  
        },
 success : function(data) {  
  $(".tunggu").hide(); 
             setTimeout(function(){$('.sukses').html('');window.location = "<?php echo base_url() .'kasir/' ?>";},1000);
        },  
      error : function(data) {  
        alert(data);  
      }  
    });
}
function bukameja(){
    var url = "<?php echo base_url().'kasir/buka_meja'; ?>";
    var id_meja = $("#id_meja").val();
    $.ajax( {
       type:"POST", 
        url : url,  
        cache :false,  
        data :{id_meja:id_meja},
        beforeSend:function(){
          $(".tunggu").show();  
        },
 success : function(data) {  
  $(".tunggu").hide(); 
            window.location.reload();
        },  
      error : function(data) {  
        alert(data);  
      }  
    });
}
function simpan_pesanan_temp(){
    var url = "<?php echo base_url().'kasir/simpan_pesanan_personal_temp'; ?>";
    var kode_penjualan = $("#kode_penjualan").val();
    var tanggal_penjualan = $("#tanggal_penjualan").val();
    var nomor_nota =$("#nomor_nota").val();
    var kode_meja = $("#kode_meja").val();
    var menu = $("#menu").val();
    var jumlah = $("#qty").val();
     var qty = $("#qty2").val();
    var harga = $("#harga").val();
    var keterangan = $("#keterangan").val();
    var diskon = $("#diskon_item").val();
    //alert(jumlah+"-"+qty);
    if(jumlah < 1){
        $(".sukses").html("<div class='alert alert-warning'>Jumlah Kurang</div>");
          setTimeout(function(){$('.sukses').html('');},1000); 
        
    }/*else if(qty < jumlah){
        
        $(".sukses").html("<div class='alert alert-warning'>Jumlah Melebihi Pesanan</div>");
          setTimeout(function(){$('.sukses').html('');},1000);
           
    }*/else{
            $.ajax( {
       type:"POST", 
        url : url,  
        cache :false,  
        data :{kode_penjualan:kode_penjualan,kode_meja:kode_meja,kode_menu:menu,jumlah:jumlah,
        diskon_item:diskon,harga_satuan:harga,qty:qty,keterangan:keterangan
        },
        
        beforeSend:function(){
          $(".tunggu").show();  
        },
 success : function(data) {
  $(".tunggu").hide(); 
         $(".sukses").html(data);
          setTimeout(function(){$('.sukses').html('');},1500);
             $("#tb_pesan_temp").load('<?php echo base_url().'kasir/pesanan_personal_temp/'.$this->uri->segment(3); ?>');
            $("#menu").val('');
            $("#qty").val('');
            $("#diskon_item").val('');
            $("#harga").val('');
            totalan();
            grand_total();
            cek_status();
        
           
            
        },  
      error : function(data) {  
        alert(data);  
      }  
    });
    }
    
}
function get_harga(){
    var url = "<?php echo base_url().'kasir/get_harga_personal'; ?>";
    var id_menu = $("#menu").val();
    var kode_meja = $("#kode_meja").val();
    $.ajax( {
       type:"POST", 
        url : url,  
        cache :false,
        dataType:'json',  
        data :{id_menu:id_menu,kode_meja:kode_meja},
        
        beforeSend:function(){
          $(".tunggu").show();  
        },
 success : function(data) {  
  $(".tunggu").hide(); 
            $("#harga").val(data.harga_satuan);
            $("#qty").val(data.jumlah);
            $("#qty2").val(data.jumlah);
            //$("#diskon_item").val(data.diskon_item);
            $("#keterangan").val(data.keterangan);
            
        },  
      error : function(data) {  
        alert(data);  
      }  
    });
}
function actEdit(id) {
  var id = id;
  var url = "<?php echo base_url().'kasir/get_pesanan_personal_temp'; ?>";
  $.ajax({
          type: 'POST',
          url: url,
          dataType: 'json',
          data: {id:id},
          success: function(kasir){
            $("#menu").val(kasir.kode_menu);
            $("#qty").val(kasir.jumlah);
            $("#diskon_item").val(kasir.diskon_item);
            $("#harga").val(kasir.harga_satuan);
            $("#tb_pesan_temp").load('<?php echo base_url().'kasir/pesanan_personal_temp/'.$this->uri->segment(3); ?>');
          }
      });
}
function actDelete(Object) {
    $('#id-delete').val(Object);
    $('#modal-confirm').modal('show');
}
function delData() {
    var id = $('#id-delete').val();
    var url = '<?php echo base_url().'kasir/hapus_pesanan_personal_temp'; ?>/delete';
    $.ajax({
        type: "POST",
        url: url,
        data: {
            id:id
        },
        success: function(msg) {
            $('#modal-confirm').modal('hide');
            $("#tb_pesan_temp").load('<?php echo base_url().'kasir/pesanan_personal_temp/'.$this->uri->segment(3); ?>');
            totalan();
            grand_total();
        }
    });
    return false;
}
function diskon_persen(){
    var no_meja = $("#kode_meja").val();
    var diskon_persen = $("#persen").val();
    var url = "<?php echo base_url().'kasir/diskon_persen_personal'; ?>";
  $.ajax({
          type: 'POST',
          url: url,
          data: {no_meja:no_meja,diskon_persen:diskon_persen},
          success: function(total){
            var rupiah = Math.round((diskon_persen/100 )*total);
            $("#rupiah").val(rupiah);
            diskon_all();
            grand_total();
          }
      });
}
function diskon_rupiah(){
    var no_meja = $("#kode_meja").val();
    var diskon_rupiah = $("#rupiah").val();
    var url = "<?php echo base_url().'kasir/diskon_persen'; ?>";
  $.ajax({
          type: 'POST',
          url: url,
          data: {no_meja:no_meja,diskon_rupiah:diskon_rupiah},
          success: function(total){
            var persen = Math.round(diskon_rupiah/total*100);
            $("#persen").val(persen);
            diskon_all();
            grand_total();
          }
      });
}
function totalan() {
  var no_meja = $("#kode_meja").val();
  var url = "<?php echo base_url().'kasir/get_total_personal_temp'; ?>";
  $.ajax({
          type: 'POST',
          url: url,
          dataType:'json',
          data: {no_meja:no_meja},
          success: function(kasir){
            $("#total_pesanan").text(kasir.total);
            $("#grand_total").text(kasir.total);
            $("#total2").val(kasir.total2);
          }
      });
}
function diskon_all(){
    var url = "<?php echo base_url().'kasir/diskon_all'; ?>";
    var rupiah = $("#rupiah").val();
     $.ajax({
          type: 'POST',
          url: url,
          data: {rupiah:rupiah},
          success: function(rupiah){
            $("#diskon_all").text(rupiah);
          }
      });
}
function grand_total(){
     var url = "<?php echo base_url().'kasir/grand_total_personal'; ?>";
    var rupiah = $("#rupiah").val();
    var no_meja = $("#kode_meja").val();
     $.ajax({
          type: 'POST',
          url: url,
          dataType:'json',
          data: {rupiah:rupiah,no_meja:no_meja},
          success: function(rupiah){
            $("#grand_total").text(rupiah.total_grand);
            $("#total_no").val(rupiah.total_no);
          }
      });
}
function kembalian(){
    var url = "<?php echo base_url().'kasir/kembalian'; ?>";
    var dibayar = $("#bayar").val();
    var total = $("#total_no").val();
     $.ajax({
          type: 'POST',
          url: url,
          dataType:'json',
          data: {total:total,dibayar:dibayar},
          success: function(rupiah){
            $("#kembalian").text(rupiah.kembalian1);
            $("#kembalian2").val(rupiah.kembalian2);
            $("#rupiah_bayar").text(rupiah.dibayar);
          }
      });
}
function bayar(){
    var url = "<?php echo base_url().'kasir/simpan_pembayaran_personal'; ?>";
    var kode_meja = $("#kode_meja").val();
    var kode_penjualan = $("#kode_penjualan").val();
    var total_pesanan = $("#total2").val();
    var persen = $("#persen").val();
    var rupiah = $("#rupiah").val();
    var grand_total = $("#total_no").val();
    var jenis_transaksi = $("#jenis_transaksi").val();
    var kembalian = $("#kembalian2").val();
    var bayar = $("#bayar").val();
    var kode_kasir = $("#kode_kasir").val();
    var waiter  = $("#waiter").val();
    var kode_member = $("#kode_member").val();
    var nama_member = $("#nama_member").val();
    var kode_penjualan_baru = $("#kode_penjualan_baru").val();
    
     $.ajax({
          type: 'POST',
          url: url,
          data: {kode_meja:kode_meja,kode_penjualan:kode_penjualan,bayar:bayar,kembalian:kembalian,kode_kasir:kode_kasir,waiter:waiter,
          total_pesanan:total_pesanan,persen:persen,rupiah:rupiah,grand_total:grand_total,jenis_transaksi:jenis_transaksi,
          kode_member:kode_member,nama_member:nama_member,kode_penjualan_baru:kode_penjualan_baru},
          success: function(hasil){
            $("#modal-confirm-bayar").modal('hide');
            $(".sukses").html('<div style="font-size:1.5em" class="alert alert-info">Pembayaran Personal Berhasil</div>');
            var link = "<?php echo base_url('kasir/cetak_pembayaran_personal'); ?>";
                  
                  $.ajax({
                     type: "POST",
                     url: link,
                     data:{
                        kode_meja:kode_meja,kode_penjualan_baru:kode_penjualan_baru,jenis_transaksi:jenis_transaksi
                     },
                     success: function(msg)
                     {
                       //alert(msg);
                        
                     }
                  });
            setTimeout(function(){$('.sukses').html('');window.location = "<?php echo base_url() . 'kasir/menu_kasir/' ?>"+kode_meja;},1000);  
          }
      });
}
function pindah_meja(){
    $('#modal-regular').modal('show'); 
}

function gabung_meja(){
    $('#modal-gabung').modal('show'); 
}

function simpan_pindah_meja(){
    var url = "<?php echo base_url().'kasir/pindah_meja'; ?>";
    var meja_asal = $("#meja_asal").val();
    var meja_akhir = $("#meja_akhir").val();
     $.ajax({
          type: 'POST',
          url: url,
          data: {meja_asal:meja_asal,meja_akhir:meja_akhir},
          success: function(data){
            $(".sukses").html('<div class="alert alert-success">Berhasil Pindah Meja</div>');
            setTimeout(function(){$('.sukses').html('');window.location = "<?php echo base_url() . 'kasir/menu_kasir/' ?>"+meja_akhir;},1000);  
          }
      });
}
function simpan_gabung_meja(){
    var url = "<?php echo base_url().'kasir/gabung_meja'; ?>";
     var kode_meja = $("#kode_meja").val();
     var gabungan = [];
    $("input[name='digabung']:checked").each(function(){
       gabungan.push($(this).val()); 
    });
    $.ajax({
          type: 'POST',
          url: url,
          data: {kode_meja:kode_meja,gabungan:gabungan},
          success: function(data){
            if(data=='belum pesan'){
                $(".sukses_gabung").html('<div class="alert alert-warning">Menu Belum Dipesan Silakan Pesan Menu</div>');
                setTimeout(function(){$(".sukses_gabung").html(''); },2000);
            }else{
                $(".sukses_gabung").html('<div class="alert alert-success">Berhasil Gabung Meja</div>');
                setTimeout(function(){$('#modal-gabung').modal('hide'); },1500);
                cek_status(); 
            }
            
              
          }
      });
}

function cek_status(){
    var kode_meja = $("#id_meja").val();
    var url = "<?php echo base_url().'kasir/kasir/cek_status'; ?>";
     $.ajax({
          type: 'POST',
          url: url,
          data: {kode_meja:kode_meja},
          success: function(hasil){
            var data = $("#hasil_meja").val(hasil);
            if($("#hasil_meja").val(hasil)=="aktif"){
                //alert("oke");
                $("#buka").show();
                $("#tutup").hide();
            }else{
               // alert("jos");
                $("#buka").hide();
                $("#tutup").show();
            }
          }
      });
}

function get_member(){
    var kode_member = $("#kode_member").val();
    var url = "<?php echo base_url().'kasir/kasir/get_member'; ?>"
    $.ajax( {
       type:"POST", 
        url : url,  
        cache :false,
        dataType:'json',  
        data :{kode_member:kode_member},
        
        beforeSend:function(){
          $(".tunggu").show();  
        },
 success : function(data) {  
  $(".tunggu").hide(); 
            $("#nama_member").val(data.nama_member);
            $("#member").text(data.nama_member);
            },  
      error : function(data) {  
        alert(data);  
      }  
    });
}

function print() {
      var url = "<?php echo base_url('kasir/cetak_bill'); ?>";
      var kode_meja = $("#kode_meja").val();
      $.ajax({
         type: "POST",
         url: url,
         data:{
            kode_meja:kode_meja
         },
         success: function(msg)
         {
           alert(msg);
            
         }
      });
   }
$(document).ready(function(){
    totalan();
    grand_total();
    cek_status();
    $("#tb_pesan_temp").load('<?php echo base_url().'kasir/pesanan_personal_temp/'.$this->uri->segment(3); ?>');
    
    $('#menu').on('keydown', function(event) {

             if (event.which == 13) {
               // alert("siap");
              $("#qty").focus();
            }
          });
    
    $('#qty').on('keydown', function(event) {

             if (event.which == 13) {
                //alert("siap");
              $("#diskon_item").focus();
            }
          });
    
    $('#diskon_item').on('keydown', function(event) {

             if (event.which == 13) {
                //alert("siap");
              simpan_pesanan_temp();
              $("#menu").focus();
            }
          });
    
    $('#persen').on('keydown', function(event) {

             if (event.which == 13) {
                //alert("siap");
             
              $("#kode_member").focus();
            }
          });
    
    $('#rupiah').on('keydown', function(event) {

             if (event.which == 13) {
                //alert("siap");
             
              $("#kode_member").focus();
            }
          });
    
    $('#kode_member').on('keydown', function(event) {

             if (event.which == 13) {
                //alert("siap");
             
              $("#jenis_transaksi").focus();
            }
          });
    
    $('#jenis_transaksi').on('keydown', function(event) {

             if (event.which == 13) {
                //alert("siap");
             
              $("#bayar").focus();
            }
          });
    
    $('#bayar').on('keydown', function(event) {

             if (event.which == 13) {
                //alert("siap");
             $("#modal-confirm-bayar").modal('show');
              // bayar();
            }
          });
   
});
</script>
