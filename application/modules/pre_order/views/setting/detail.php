<!-- 
<div class="">
  <div class="page-content">
     -->
      <div class="row">      

        <div class="col-xs-12" id='form'>
          <!-- /.box -->
          <div class="portlet box blue">
            <div class="portlet-title">
              <div class="caption">
                Detail PO
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
        <!-- Left col -->
        <div class="col-md-12">

                <div class="box box-info">
                  <div class="box-header">
                      <!-- tools box -->
                      <div class="pull-right box-tools"></div><!-- /. tools -->
                  </div>
                    
                        <form id="data_form" action="" method="post">
                            <div class="box-body">
                              <div class="notif_nota" ></div>
                            
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label>Kode Transaksi</label>
                                    <?php
                                        $kode = $this->uri->segment(3);
                                        
                                        $transaksi_po = $this->db->get_where('transaksi_po',array('kode_po'=>$kode));
                                        $hasil_transaksi_po = $transaksi_po->row();
                                        
                                    ?>
                                    <input readonly="true" type="text" value="<?php echo @$hasil_transaksi_po->kode_transaksi; ?>" class="form-control" placeholder="Kode Transaksi" name="kode_transaksi" id="kode_transaksi" />
                                  </div>
                                </div>

                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label class="gedhi">Tanggal Transaksi</label>
                                    <input type="text" value="<?php echo TanggalIndo($hasil_transaksi_po->tanggal_input); ?>" readonly="true" class="form-control" placeholder="Tanggal Transaksi" name="tanggal_input" id="tanggal_input"/>
                                  </div>
                                </div>

                              </div>
                            </div> 


                            <div id="list_transaksi_pembelian">
                              <div class="box-body">
                                <table id="tabel_daftar" class="table table-bordered table-striped">
                                  <thead>
                                    <tr>
                                      <th>No</th>
                                      <th>Nama Produk</th>
                                      <th>QTY</th>
                                      <th>Keterangan</th>
                                    </tr>
                                  </thead>
                                  <tbody id="tabel_temp_data_transaksi">
                                      <?php
                                        $pembelian = $this->db->get_where('opsi_transaksi_po',array('kode_po'=>$kode));
                                        $list_pembelian = $pembelian->result();
                                        $nomor = 1;  $total = 0;

                                        foreach($list_pembelian as $daftar){ 
                                      ?> 
                                          <tr style="font-size:15px ">
                                            <td><?php echo $nomor; ?></td>
                                          <?php
                                            $kategori=$daftar->kategori_bahan;
                                            $kode_bahan=$daftar->kode_bahan;
                                            
                                              $query=$this->db->query("SELECT satuan_pembelian from master_bahan_baku where kode_bahan_baku='$kode_bahan'");
                                              $hasil_satuan=$query->row();
                                            
                                           
                                          ?>
                                            <td><?php echo $daftar->nama_bahan; ?></td>
                                            <td><?php echo $daftar->jumlah. " " .$hasil_satuan->satuan_pembelian; ?></td>
                                            <td><?php echo $daftar->keterangan; ?></td>
                                          </tr>
                                      <?php 
                                          $nomor++; 
                                        } 
                                      ?>
                                  </tbody>
                                  <tfoot>
                                    
                                  </tfoot>
                                </table>
                              </div>
                            </div>
                             
                        </form>

                      </div>        
                    </div> 
                    </div>
    </form>
  </div>
              <!------------------------------------------------------------------------------------------------------>

            </div>
          </div>
        </div><!-- /.col -->
      </div>
   <!--  </div>    
  </div>   -->
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
            window.location = "<?php echo base_url().'pre_order/daftar'; ?>";
          });
        </script>
<script type="text/javascript">
  $(function () {  
    $("#daftar").click(function(){
      window.location = "<?php echo base_url() . 'anggota/daftar' ?>";
    });
  });
</script>

