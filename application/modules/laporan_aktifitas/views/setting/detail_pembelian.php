<div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
         Daftar Pembelian
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
     <!--   <a href="<?php echo base_url().'laporan_aktifitas/daftar' ?>" style="margin-left: 17px; padding: 15px; height: 75px;width: auto;" class="icon-btn btn red-flamingo">
													<i class="fa fa-arrow-left"></i>
													<div style="color: white;">
														 Kembali
													</div>
       </a> -->
      <div class="double bg-blue pull-right" style="cursor:default">
        <div class="tile-object">
          <div  style="padding-right:10px; padding-left:10px;  padding-top:10px; font-size:17px; font-family:arial; font-weight:bold">
            Total Transaksi Pembelian
          </div>
        </div>

        
        <div  style="padding-right:10px; padding-top:0px; font-size:48px; font-family:arial; font-weight:bold">
          <?php
          $tgl_awal = $this->uri->segment(3);
          $tgl_akhir = $this->uri->segment(4);
          if($tgl_awal!=""&&$tgl_akhir!=""){
            $this->db->where('tanggal_pembelian >=', $tgl_awal);
            $this->db->where('tanggal_pembelian <=', $tgl_akhir);
          }          
          $total = $this->db->get('transaksi_pembelian');
          $hasil_total = $total->num_rows();

          ?>
          <i class="total_transaksi"><?php echo $hasil_total; ?></i>
        </div>
      </div>
<br><br><br><br><br>
<br><br><br>
      <div class="box-body">            

        <div class="sukses" ></div>
        <br>
        <table class="table table-striped table-hover table-bordered" id="tabel_daftar"  style="font-size:1.5em;">
         <?php
         $tgl_awal = $this->uri->segment(3);
          $tgl_akhir = $this->uri->segment(4);
          if($tgl_awal!=""&&$tgl_akhir!=""){
            $this->db->where('tanggal_pembelian >=', $tgl_awal);
            $this->db->where('tanggal_pembelian <=', $tgl_akhir);
          }
         
         $pembelian = $this->db->get('transaksi_pembelian');
         $hasil_pembelian = $pembelian->result();
         ?>
         <thead>
          <tr>
            <th>No</th>
            <th>Tanggal Pembelian</th>
            <th>Kode Pembelian</th>
            <th>Nota Ref</th>
            <th>Supplier</th>
            <th>Total</th>
            
          </tr>
        </thead>
        <tbody>
          <?php
          $nomor = 1;

          foreach($hasil_pembelian as $daftar){ ?> 
          <tr>
            <td><?php echo $nomor; ?></td>
            <td><?php echo TanggalIndo(@$daftar->tanggal_pembelian);?></td>
            <td><?php echo @$daftar->kode_pembelian; ?></td>
            <td><?php echo @$daftar->nomor_nota; ?></td>
            <td><?php echo @$daftar->nama_supplier; ?></td>
            <td><?php echo format_rupiah(@$daftar->grand_total); ?></td>
            
          </tr>
          <?php $nomor++; } ?>

        </tbody>
        <tfoot>
          <tr>
            <th>No</th>
            <th>Tanggal Pembelian</th>
            <th>Kode Pembelian</th>
            <th>Nota Ref</th>
            <th>Supplier</th>
            <th>Total</th>
            
          </tr>
        </tfoot>
      </table>
     
      </div>

      <!------------------------------------------------------------------------------------------------------>

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
            window.location = "<?php echo base_url().'laporan_aktifitas/daftar' ?>";
          });
        </script>
