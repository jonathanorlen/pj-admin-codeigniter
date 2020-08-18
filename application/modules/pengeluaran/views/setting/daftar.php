<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Daftar Pengeluaran
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
        <?php
        $this->db->like('tanggal_transaksi',date('Y-m'),'both');
        $get_pemasukan = $this->db->get('keuangan_keluar');
        $hasil_pemasukan = $get_pemasukan->result();
        ?>

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
                  <th>Kategori</th>
                  <th>Sub Kategori</th>
                  <th>Nominal</th>
                  <th>Nama Supplier</th>
                  <th>Tanggal</th>
                  <th>Petugas</th>
                  <th>Keterangan</th>

                  <th width="133px;">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                foreach($hasil_pemasukan as $item){
                  if($this->session->flashdata('message')==$item->id){

                    echo '<tr id="warna" style="background: #88cc99; display: none;">';
                  }
                  else{
                    echo '<tr>';
                  }
                  ?>
                  <td><?php echo $no; ?></td>
                  <td><?php echo $item->nama_kategori_keuangan; ?></td>
                  <td><?php echo $item->nama_sub_kategori_keuangan; ?></td>                  
                  <td><?php echo format_rupiah($item->nominal); ?></td>  


                  <?php 
                  $get_supplier=$this->db->get_where('transaksi_pembelian',array('kode_pembelian'=>$item->kode_referensi));
                  $hasil_supplier=$get_supplier->row();
                  ?>
                  <td><?php if ($item->kode_sub_kategori_keuangan=='2.1.3') {
                    echo ($hasil_supplier->nama_supplier);
                  }?></td>                  
                  <td><?php echo tanggalIndo($item->tanggal_transaksi); ?></td>
                  <td><?php echo $item->petugas; ?></td>
                  <td><?php echo $item->keterangan; ?></td>
                  <td align="center"><?php echo get_detail($item->id); ?></td>
                </tr>
                <?php 
                $no++;
              } ?>
            </tbody>                
          </table>
        </div>

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
        url : "<?php echo base_url().'pengeluaran/cari_pengeluaran'; ?>",  
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
    window.location = "<?php echo base_url().'transaksional'; ?>";
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
    $("#warna").fadeIn('slow');
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

   
 } );
  setTimeout(function(){
    $("#warna").css("background-color", "white");
    $("#warna").css("transition", "all 3000ms linear");
  }, 3000);

</script>

