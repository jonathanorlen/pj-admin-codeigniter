<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Detail Per Ritase Kendaraan

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
                    $kode_penjualan = $this->uri->segment(3);
                    $kode_surat_jalan = $this->uri->segment(4);
                    
                    $this->db->where('kode_penjualan',$kode_penjualan);
                    $this->db->where('kode_surat_jalan',$kode_surat_jalan);
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


                <!-- <div class="col-md-4">

                  <div class="form-group">
                    <label class="gedhi">Nama Sopir</label>
                    <input type="text" value="<?php #echo ($hasil_pengiriman->nama_sopir); ?>" readonly="true" class="form-control" placeholder="Tanggal Transaksi" name="tanggal_pembelian" id="tanggal_pembelian"/>
                  </div>
                </div> -->
              </div>
              <div class="row">
                <div class="col-md-4">

                  <div class="form-group">
                    <label class="gedhi">Kode Penjualan</label>
                    <input type="text" value="<?php echo ($hasil_pengiriman->kode_penjualan); ?>" readonly="true" class="form-control" placeholder="Tanggal Transaksi" name="tanggal_pembelian" id="tanggal_pembelian"/>
                  </div>
                </div>


                <div class="col-md-4">

                  <div class="form-group">
                    <label class="gedhi">Kode Surat Jalan</label>
                    <input type="text" value="<?php echo ($hasil_pengiriman->kode_surat_jalan); ?>" readonly="true" class="form-control" placeholder="Tanggal Transaksi" name="tanggal_pembelian" id="tanggal_pembelian"/>
                  </div>
                </div>
              </div>
            </div> 

            <div id="list_transaksi_pembelian">
              <br><br><br><br>
              <div class="box-body">
                <table id="tabel_daftar" class="table table-bordered table-striped" style="font-size:1.5em;">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Produk</th>
                      <th>Jumlah</th>
                    </tr>
                  </thead>
                  <tbody id="tabel_temp_data_transaksi">

                    <?php
                    $this->db->where('kode_penjualan',$kode_penjualan);
                    $this->db->where('kode_surat_jalan',$kode_surat_jalan);
                    $list = $this->db->get('opsi_transaksi_pengiriman');
                    $hasil_list = $list->result();
                    $nomor = 1;  $total = 0;

                    foreach($hasil_list as $daftar){ 
                      ?> 
                      <tr>
                        <td><?php echo $nomor; ?></td>
                        <td><?php echo $daftar->nama_produk; ?></td>
                        <td><?php echo $daftar->jumlah; ?> </td>

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
      history.go(-1);
    });
  </script>

