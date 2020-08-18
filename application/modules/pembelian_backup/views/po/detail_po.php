<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Data Pembelian </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin').'/dasboard' ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      </ol>
    </section>
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
            <a style="padding:13px; margin-bottom:10px" class="btn btn-app green" href="<?php echo base_url().'pembelian/pembelian/tambah'; ?>">
              <i class="fa fa-plus"></i> Tambah Pembelian
            </a>
            
            <a style="padding:13px; margin-bottom:10px" class="btn btn-app blue" href="<?php echo base_url().'pembelian/pembelian/daftar_pembelian'; ?>">
              <i class="fa fa-list"></i> Daftar Pembelian
            </a>
            
            <a style="padding:13px; margin-bottom:10px" class="btn btn-app green" href="<?php echo base_url().'pembelian/retur/tambah'; ?>">
              <i class="fa fa-plus"></i> Tambah Retur Pembelian
            </a>
            
            <a style="padding:13px; margin-bottom:10px" class="btn btn-app blue" href="<?php echo base_url().'pembelian/retur/daftar_retur_pembelian'; ?>">
              <i class="fa fa-list"></i> Daftar Retur Pembelian
            </a>

            <a style="padding:13px; margin-bottom:10px" class="btn btn-app green" href="<?php echo base_url().'pembelian/po/tambah'; ?>">
              <i class="fa fa-plus"></i> Formulir PO
            </a>
            
            <a style="padding:13px; margin-bottom:10px" class="btn btn-app blue" href="<?php echo base_url().'pembelian/po/daftar_po'; ?>">
              <i class="fa fa-list"></i> Daftar PO
            </a>

                <div class="box box-info">
                  <div class="box-header">
                      <!-- tools box -->
                      <div class="pull-right box-tools"></div><!-- /. tools -->
                  </div>
                    
                        <form id="data_form" action="" method="post">
                            <div class="box-body">
                              <div class="notif_nota" ></div>
                              <label><h3><b>Transaksi Pembelian</b></h3></label>
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label>Kode Transaksi</label>
                                    <?php
                                        $kode = $this->uri->segment(4);
                                        
                                        $transaksi_po = $this->db->get_where('transaksi_po',array('kode_po'=>$kode));
                                        $hasil_transaksi_po = $transaksi_po->row();
                                        
                                    ?>
                                    <input readonly="true" type="text" value="<?php echo @$hasil_transaksi_po->kode_po; ?>" class="form-control" placeholder="Kode Transaksi" name="kode_po" id="kode_po" />
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
                                      <th>Nama bahan</th>
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
                                          <tr>
                                            <td><?php echo $nomor; ?></td>
                                            <td><?php echo $daftar->nama_bahan; ?></td>
                                            <td><?php echo $daftar->jumlah; ?></td>
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
            </section><!-- /.Left col -->      
        </div><!-- /.row (main row) -->
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
                <span style="font-weight:bold; font-size:14pt">Apakah anda yakin akan menghapus pembelian bahan tersebut ?</span>
                <input id="id-delete" type="hidden">
            </div>
            <div class="modal-footer" style="background-color:#eee">
                <button class="btn green" data-dismiss="modal" aria-hidden="true">Tidak</button>
                <button onclick="delData()" class="btn red">Ya</button>
            </div>
        </div>
    </div>
</div>
