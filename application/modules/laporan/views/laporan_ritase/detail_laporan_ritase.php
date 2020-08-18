<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Detail Ritase Kendaraan

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
          <form id="data_form" action="" method="post">
            <div class="box-body">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>No. Kendaraan</label>
                    <?php
                    $tanggal_kirim = $this->uri->segment(3);
                    $kode_kendaraan = $this->uri->segment(4);
                    
                    $this->db->where('tanggal_kirim',$tanggal_kirim);
                    $this->db->where('kode_kendaraan',$kode_kendaraan);
                    $pengiriman = $this->db->get('opsi_transaksi_pengiriman');
                    $hasil_pengiriman = $pengiriman->row();
                   // echo $this->db->last_query();
                    ?>
                    
                    <input readonly="true" type="text" value="<?php echo @$hasil_pengiriman->no_kendaraan; ?>" class="form-control" placeholder="Kode Transaksi" name="kode_pembelian" id="kode_pembelian" />
                  </div>

                </div>
                <div class="col-md-4">

                  <div class="form-group">
                    <label class="gedhi">Nama Sopir</label>
                    <input type="text" value="<?php echo ($hasil_pengiriman->nama_sopir); ?>" readonly="true" class="form-control" placeholder="Tanggal Transaksi" name="tanggal_pembelian" id="tanggal_pembelian"/>
                  </div>
                </div>


               <!--  <div class="col-md-4">

                  <div class="form-group">
                    <label class="gedhi">Nama Sopir</label>
                    <input type="text" value="<?php #echo ($hasil_pengiriman->nama_sopir); ?>" readonly="true" class="form-control" placeholder="Tanggal Transaksi" name="tanggal_pembelian" id="tanggal_pembelian"/>
                  </div>
                </div> -->
              </div>
            </div> 

            <div id="list_transaksi_pembelian">
              <br><br><br><br>
              <div class="box-body">
                <table id="tabel_daftar" class="table table-bordered table-striped" style="font-size:1.5em;">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Kode Penjualan</th>
                      <th>Kode Surat Jalan</th>
                      <th>Nama Member</th>
                      <th>Nama Penerima</th>
                      <th>Jam Berangkat</th>
                      <th>Jam Pulang</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody id="tabel_temp_data_transaksi">

                    <?php
                    $this->db->where('tanggal_kirim',$tanggal_kirim);
                    $this->db->where('kode_kendaraan',$kode_kendaraan);
                    $list = $this->db->get('opsi_transaksi_pengiriman');
                    $hasil_list = $list->result();
                    $nomor = 1;  $total = 0;

                    foreach($hasil_list as $daftar){ 
                      ?> 
                      <tr>
                        <td><?php echo $nomor; ?></td>
                        <td><?php echo $daftar->kode_penjualan; ?></td>
                        <td><?php echo $daftar->kode_surat_jalan; ?> </td>
                        <td><?php 
                          $this->db->where('kode_penjualan', $daftar->kode_penjualan);
                          $member = $this->db->get('transaksi_penjualan');
                          $hasil_member = $member->row();
                          echo $hasil_member->nama_member;
                          ?> </td>
                        <td><?php echo $hasil_member->nama_penerima;?> </td>
                          <td><?php echo $daftar->jam?></td>
                          <td><?php echo $daftar->jam_kembali?></td>
                          <td align="center"><a href="<?php echo base_url().'laporan/detail_laporan_per_ritase/'.$daftar->kode_penjualan.'/'.$daftar->kode_surat_jalan ?>" class="btn btn-primary"><i class="fa fa-search"></i> Detail</a></td>
                        </tr>
                        <?php 
                        $nomor++; 
                      } 
                      ?>
                    </tbody>
                    <tfoot>

                    </tfoot>
                  </table>
                  <br>

                </div>
              </div>
            </form>
          </div>
        </div>
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
      window.location = "<?php echo base_url().'laporan/laporan_ritase'; ?>";
    });
  </script>

