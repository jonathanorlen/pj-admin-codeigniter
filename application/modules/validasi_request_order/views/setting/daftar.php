
<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Validasi Request Order
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
          <table class="table table-striped table-hover table-bordered" id="tabel_daftar"  style="font-size:1.5em;">
            <thead>

              <tr>
                <th width="50px;">No</th>
                <th>Tanggal</th>
                <th>Kode Request Order</th>
                <th>Petugas</th>
                <th>Unit</th>
                

                <th width="133px;">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              
              
                $this->db->group_by('kode_ro');
                $po = $this->db->get_where('opsi_transaksi_ro',array('jenis_bahan'=>'langsung'));
                $hasil_po = $po->result_array();
                $no=0;
                foreach ($hasil_po as $list) {
                $no++;
               
              ?>

              <tr>
                <td><?php echo $no; ?></td>
               <?php
                $get_transaksi = $this->db->get_where('transaksi_ro',array('kode_ro'=>$list['kode_ro']));
                $hasil_get = $get_transaksi->row();
               ?>
                <td><?php echo TanggalIndo($hasil_get->tanggal_input);?></td>
                 <td><?php echo $list['kode_ro']; ?></td>
              <?php 
                $kode_unit=$hasil_get->position;
                $unit = $this->db->query("SELECT nama_unit from master_unit where kode_unit='$kode_unit'");
                $nama = $unit->row();
              ?>
                <td><?php echo $hasil_get->petugas; ?></td>
                <td><?php echo $nama->nama_unit; ?></td>
               <?php
                    $get_ro = $this->db->query("SELECT * FROM (`opsi_transaksi_ro`) WHERE `jenis_bahan` = 'langsung' 
                    AND `status_validasi` = '' AND `kode_ro` = '$list[kode_ro]' 
                    OR `status_validasi` = 'proses' AND `jenis_bahan` = 'langsung' AND `kode_ro` = '$list[kode_ro]'");
                    #echo $this->db->last_query(); 
                    $hasil_ro = $get_ro->result();
                    $jml_ro = count($hasil_ro);

                ?>  
                  
                <td><?php if($jml_ro<1){ echo detail_tervalidasi($list['kode_ro']); }else{
                  echo get_detail_validasi($list['kode_ro']);
                }  ?></td>
              </tr>
              <?php  } ?>
            </tbody>                
          </table>
          </div>
        </div>
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
      url : "<?php echo base_url().'validasi_request_order/cari_validasi_request_order'; ?>",  
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
  $(document).ready(function() {


   $("#tabel_daftar").dataTable({
    "paging":   false,
    "ordering": false,
    "info":     false
  });   

   setTimeout(function(){
    $("#lalal").fadeIn('slow');
  }, 1000);
   $("a#hapus").click( function() {    
      var r =confirm("Anda yakin ingin menghapus data ini ?");
      if (r==true)  
      {
        $.ajax( {  
          type :"post",  
          url :"<?php echo base_url() . 'anggota/hapus' ?>",  
          cache :false,  
          data :({key:$(this).attr('key')}),
          beforeSend:function(){
          $(".tunggu").show();  
        },
 success : function(data) { 
            $(".sukses").html(data);   
            setTimeout(function(){$('.sukses').html('');window.location = "<?php echo base_url() . 'anggota/daftar' ?>";},1500);              
          },  
          error : function() {  
            alert("Data gagal dimasukkan.");  
          }  
        });
        return false;
      }
      else {}        
    });

    $('#tabel_daftar').dataTable();
  } );
  setTimeout(function(){
    $("#lalal").css("background-color", "white");
    $("#lalal").css("transition", "all 3000ms linear");
  }, 3000);

</script>


