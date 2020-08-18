<div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
         Daftar Opname
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
      <!--  <a href="<?php echo base_url().'laporan_aktifitas/daftar' ?>" style="margin-left: 17px; padding: 15px; height: 75px;width: auto;" class="icon-btn btn red-flamingo">
													<i class="fa fa-arrow-left"></i>
													<div style="color: white;">
														 Kembali
													</div>
       </a> -->
      <div class="double bg-blue pull-right" style="cursor:default">
        <div class="tile-object">
          <div  style="padding-right:10px; padding-left:10px;  padding-top:10px; font-size:17px; font-family:arial; font-weight:bold">
            Total Transaksi Opname
          </div>
        </div>

        
        <div  style="padding-right:10px; padding-top:0px; font-size:48px; font-family:arial; font-weight:bold">
          <?php
          $tgl_awal = $this->uri->segment(3);
          $tgl_akhir = $this->uri->segment(4);
          if($tgl_awal!=""&&$tgl_akhir!=""){
            $this->db->where('tanggal_opname >=', $tgl_awal);
            $this->db->where('tanggal_opname <=', $tgl_akhir);
          }          
           
           $total = $this->db->get('transaksi_opname');
           $hasil_total = $total->num_rows();

          ?>
          <i class="total_transaksi"><?php echo $hasil_total; ?></i>
        </div>
      </div>
<br><br><br><br><br>
      <div class="box-body">            

        <div class="sukses"></div>
        <table class="table table-striped table-hover table-bordered" id="tabel_daftar"  style="font-size:1.5em;">
            <thead>
              <tr>
                <th>No</th>
                <th>Kode Opname</th>
                <th>Tanggal Opname</th>
                <th>Petugas</th>
                <th>Status Validasi</th>
                
              </tr>
            </thead>
            <tbody>
              <?php
              if($tgl_awal!=""&&$tgl_akhir!=""){
                $this->db->where('tanggal_opname >=', $tgl_awal);
                $this->db->where('tanggal_opname <=', $tgl_akhir);
              }   
              $opname = $this->db->get('transaksi_opname');
              $list_opname = $opname->result();
              $nomor = 1;  

              foreach($list_opname as $daftar){ 
                ?> 
                <tr>
                  <td><?php echo @$nomor; ?></td>
                  <td><?php echo @$daftar->kode_opname; ?></td>
                  <td><?php echo @TanggalIndo($daftar->tanggal_opname); ?></td>
                  <td><?php echo @$daftar->petugas; ?></td>
                  <td><?php echo @$daftar->validasi; ?></td>
                  
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
                
              </tr>
            </tfoot>                
          </table>
     

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
