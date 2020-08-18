

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Data Hutang Piutang </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin').'/dasboard' ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      </ol>
    </section>
<style type="text/css">
 .ombo{
  width: 400px;
 } 

</style>    
    <!-- Main content -->
    <section class="content">             
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
            <section class="col-lg-12 connectedSortable">
                <div class="box box-info">
                    <div class="box-header">
                        <!-- tools box -->
                        <div class="pull-right box-tools"></div><!-- /. tools -->
                    </div>
                    
                    <div class="box-body">            
                        <div class="sukses" ></div>
                        
                        <div style="margin-left: 5px;" class="row">
                
                            
                              <div class="small-box bg-green menu-radius">
                                <a style="text-decoration:none" href="<?php echo base_url().'hutang_piutang/hutang/daftar_hutang'; ?>">
                                <p>&nbsp;</p>
                                <div class="inner" style="background:url(<?php echo base_url().'component/admin/img/icon/acc-pembelian.png'?>) no-repeat center center; background-size:90px 90px;">
                                  <h3>&nbsp;</h3>
                                  <p>&nbsp;</p>
                                </div>
                                <div class="icon" style="margin-top:15px">
                                  <i class="ion-ios-list-outline"></i>
                                </div>
                                <a class="small-box-footer">Hutang</a></a>
                              </div>

                            
                              <div class="small-box bg-green menu-radius">
                                <a style="text-decoration:none" href="<?php echo base_url().'hutang_piutang/piutang/daftar_piutang'; ?>">
                                <p>&nbsp;</p>
                                <div class="inner" style="background:url(<?php echo base_url().'component/admin/img/icon/acc-piutang.png'?>) no-repeat center center; background-size:90px 90px;">
                                  <h3>&nbsp;</h3>
                                  <p>&nbsp;</p>
                                </div>
                                <div class="icon" style="margin-top:15px">
                                  <i class="ion-ios-list-outline"></i>
                                </div>
                                <a class="small-box-footer">Piutang</a></a>
                              </div>
                            
                        </div>

                    </div>
                </div>
            </section><!-- /.Left col -->      
        </div><!-- /.row (main row) -->

        <div class="row">
        <!-- Left col -->
            <section class="col-lg-12 connectedSortable">
                <div class="box box-info">                 
                    <div class="box-body"> 
                      
                      <h3>Daftar Piutang</h3>                    

                        <table id="tabel_daftar" class="table table-bordered table-striped">
                            <?php
                                        $this->db->order_by('sisa', 'asc');
                              $piutang = $this->db->get('transaksi_piutang');
                              $hasil_piutang = $piutang->result();
                            ?>
                            <thead>
                              <tr>
                                <th>No</th>
                                <th>Kode Transaksi</th>
                                <th>Customer</th>
                                <th>Nominal Piutang</th>
                                <th>Sisa</th>
                                <th>Tanggal Transaksi</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $nomor = 1;
                                    foreach($hasil_piutang as $daftar){ 
                                      $tgl = ($daftar->tanggal_transaksi=='0000-00-00' || empty($daftar->tanggal_transaksi)) ? '-' : TanggalIndo(@$daftar->tanggal_transaksi) ;
                                      ?> 
                                    <tr class="<?php if(@$daftar->sisa > 0){ echo "danger"; } ?>">
                                      <td><?php echo $nomor; ?></td>
                                      <td><?php echo @$daftar->kode_transaksi; ?></td>
                                      <td><?php echo @$daftar->nama_customer; ?></td>
                                      <td><?php echo format_rupiah(@$daftar->nominal_piutang); ?></td>
                                      <td><?php echo format_rupiah(@$daftar->sisa); ?></td>
                                      <td><?php echo $tgl; ?></td>
                                      <td><?php echo get_detail_proses($daftar->kode_transaksi); ?></td>
                                    </tr>
                                <?php $nomor++; } ?>
                               
                            </tbody>
                             <tfoot>
                              <tr>
                                <th>No</th>
                                <th>Kode Transaksi</th>
                                <th>Customer</th>
                                <th>Nominal Piutang</th>
                                <th>Sisa</th>
                                <th>Tanggal Transaksi</th>
                                <th>Action</th>
                              </tr>
                             </tfoot>
                        </table>
                        
                    </div>
                </div>
            </section><!-- /.Left col -->      
        </div><!-- /.row (main row) -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

