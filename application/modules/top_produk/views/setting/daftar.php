<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Daftar Top Produk
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

        $get_pemasukan = $this->db->get('keuangan_masuk');
        $hasil_pemasukan = $get_pemasukan->result();
        ?>

        <div class="box-body">            
          <div class="sukses" ></div>
           
        <div id="aktifitas">
          <table class="table table-hover table-bordered" id="tabel_daftar"  style="font-size:1.5em;">
            <thead>
            
            <th>Nama Produk</th>
            <th>Jumlah Terjual</th>
            
            </thead>
                
                    <tbody>
                <?php
                $no = 1;
                    $this->db->group_by('kode_menu');
                    $this->db->order_by('nama_menu','asc');
                    $this->db->select('kode_menu,nama_menu,jumlah');
                    $this->db->like('tanggal_transaksi', date('Y-m'), 'both');
                    //$this->db->limit('10');
                    $top_produk = $this->db->get('opsi_transaksi_penjualan');
                    #echo $this->db->last_query();
                    $hasil_top_produk = $top_produk->result();
                    foreach($hasil_top_produk as $daftar){
                ?>
                <tr>
                
                <td><?php echo $daftar->nama_menu; ?></td>
                <?php
                    $this->db->select_sum('jumlah');
                    $jumlah_terjual = $this->db->get_where('opsi_transaksi_penjualan',array('kode_menu'=>$daftar->kode_menu));
                    $hasil_terjual = $jumlah_terjual->row();
                ?>
                <td><?php echo $hasil_terjual->jumlah; ?></td>
                </tr>
            <?php $no++; } ?>
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
            window.location = "<?php echo base_url().'analisa'; ?>";
          });
        </script>


<script>
  $(document).ready(function() {
    
      $('#tabel_daftar').DataTable( {
        "order": [[ 1, "desc" ]]
    } );

    //$('#tabel_daftar').dataTable();
  } );
  
function cari_transaksi(){
    var tgl_awal =$("#tgl_awal").val();
    var tgl_akhir =$("#tgl_akhir").val();
    $.ajax( {  
        type :"post",  
        url : "<?php echo base_url().'laporan_aktifitas/search_aktifitas'; ?>",  
        cache :false,
        data : {tgl_awal:tgl_awal,tgl_akhir:tgl_akhir},
        beforeSend:function(){
          $(".tunggu").show();  
        },
 success : function(data) {
             $("#aktifitas").html(data);
        },  
        error : function(data) {  
          alert("das");  
        }  
      });
}

</script>

