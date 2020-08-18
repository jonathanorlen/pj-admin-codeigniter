
<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Daftar Ritase Kendaraan
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
          <form id="data_form" method="post">
            <div class="box-body">            
              <div class="row">
                <div class="col-md-4">
                  <label>Tanggal Awal</label>
                  <input type="date" name="tgl_awal" id="tgl_awal" class="form-control tgl">
                </div>
                <div class="col-md-4">
                  <label>Tanggal Akhir</label>
                  <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control tgl">
                </div>
                <div class="col-md-4">
                  <br><br>
                  <button style="width: 100px" type="button" class="btn btn-warning " id="cari"><i class="fa fa-search"></i> Cari</button>  </div>    
                </div> 

              </div>
            </div>
          </form>
          <br><br>
        <div class="box-body">            
          <div class="sukses" ></div>
          <div id="cari_transaksi" >
          <table class="table table-striped table-hover table-bordered" id="tabel_daftar"  style="font-size:1.5em;">
            <thead>
              <tr>
                <th width="50px;">No</th>
                <th>Tanggal Pengiriman</th>
                <th>No. Kendaraan</th>
                <th>Jumlah</th>
                <th width="220px">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $month=date('Y-m');
              // $this->db->group_by('tanggal_kirim');
              // $this->db->group_by('no_kendaraan');

              $get_pengiriman =  $this->db->query("SELECT * FROM (`opsi_transaksi_pengiriman`) WHERE tanggal_kirim LIKE '%$month%' GROUP BY `tanggal_kirim`, `no_kendaraan` ORDER BY tanggal_kirim DESC");
              //$get_pengiriman = $this->db->get('opsi_transaksi_pengiriman');
              $hasil_pengiriman = $get_pengiriman->result();
              //echo $this->db->last_query();
              $no = 1;
              foreach($hasil_pengiriman as $item){
                ?>
                <td><?php echo $no;?></td>
                <td><?php echo tanggalIndo($item->tanggal_kirim); ?></td>                  
                <td><?php echo $item->no_kendaraan; ?></td> 
                <?php 
            
                $get_total = $this->db->query("SELECT count(no_kendaraan) as nomor from opsi_transaksi_pengiriman where tanggal_kirim='$item->tanggal_kirim' and no_kendaraan='$item->no_kendaraan'");
                $hasil_total = $get_total->row();
                ?>                 
                <td><?php echo  $hasil_total->nomor." "."Kali"; ?></td>
                <td align="center"><a href="<?php echo base_url().'laporan/detail_laporan_ritase/'.$item->tanggal_kirim.'/'.$item->kode_kendaraan ?>" class="btn btn-primary"><i class="fa fa-search"></i> Detail</a></td>
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

<div id="modal-confirm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color:grey">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title" style="color:#fff;">Konfirmasi Hapus Data</h4>
      </div>
      <div class="modal-body">
        <span style="font-weight:bold; font-size:12pt">Apakah anda yakin akan menghapus data bahan baku tersebut ?</span>
        <input id="id-delete" type="hidden">
      </div>
      <div class="modal-footer" style="background-color:#eee">
        <button class="btn green" data-dismiss="modal" aria-hidden="true">Tidak</button>
        <button onclick="delData()" class="btn red">Ya</button>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
  $(document).ready(function(){
    $('#cari').click(function(){

      var tgl_awal =$("#tgl_awal").val();
      var tgl_akhir =$("#tgl_akhir").val();
     

      $.ajax( {  
        type :"post",  
        url : "<?php echo base_url().'laporan/cari_laporan_ritase'; ?>",  
        cache :false,

        data : {tgl_awal:tgl_awal,tgl_akhir:tgl_akhir},
        beforeSend:function(){
          $(".tunggu").show();  
        },
        success : function(data) {
         $(".tunggu").hide();  
         $("#cari_transaksi").html(data);
       },  
       error : function(data) {  

       }  
     });

    });
  });
</script>
