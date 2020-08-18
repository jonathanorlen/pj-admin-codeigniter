

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>MASTER </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin').'/dasboard' ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      </ol>
    </section>
  <style type="text/css">
      .menn{
        text-decoration: none;
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
                        <div class="loading" style="z-index:9999999999999999; background:rgba(255,255,255,0.8); width:100%; height:100%; position:fixed; top:0; left:0; text-align:center; padding-top:25%; display:none" >
                          <img src="<?php echo base_url() . '/public/img/loading.gif' ?>">
                        </div>

                        <div class="row">

                            <div class="col-lg-3 col-xs-6">
                              <div class="small-box bg-red">
                                <a style="text-decoration:none" href="<?php echo base_url() . 'master/gudang/' ?>">
                                <p>&nbsp;</p>
                                <div class="inner" style="background:url(<?php echo base_url().'component/admin/img/icon/gudang.png'?>) no-repeat center center;">
                                  <h3>&nbsp;</h3>
                                  <p>&nbsp;</p>
                                </div>
                                <div class="icon" style="margin-top:15px">
                                  <i class="ion-ios-list-outline"></i>
                                </div>
                                <a class="small-box-footer">Gudang</a></a>
                              </div>
                            </div> 

                            <div class="col-lg-3 col-xs-6">
                              <div class="small-box bg-blue">
                                <a style="text-decoration:none" href="<?php echo base_url().'master/bahan_baku/' ?>">
                                <p>&nbsp;</p>
                                <div class="inner" style="background:url(<?php echo base_url().'component/admin/img/icon/kategori.png'?>) no-repeat center center;">
                                  <h3>&nbsp;</h3>
                                  <p>&nbsp;</p>
                                </div>
                                <div class="icon" style="margin-top:15px">
                                  <i class="ion-ios-list-outline"></i>
                                </div>
                                <a class="small-box-footer">Bahan Baku</a></a>
                              </div>
                            </div>

                            <div class="col-lg-3 col-xs-6">
                              <div class="small-box bg-green">
                                <a style="text-decoration:none" href="<?php echo base_url() . 'master/bahan_jadi/daftar_bahan_jadi' ?>">
                                <p>&nbsp;</p>
                                <div class="inner" style="background:url(<?php echo base_url().'component/admin/img/icon/kategori.png'?>) no-repeat center center;">
                                  <h3>&nbsp;</h3>
                                  <p>&nbsp;</p>
                                </div>
                                <div class="icon" style="margin-top:15px">
                                  <i class="ion-ios-list-outline"></i>
                                </div>
                                <a class="small-box-footer">Bahan Jadi</a></a>
                              </div>
                            </div>

                            <div class="col-lg-3 col-xs-6">
                              <div class="small-box bg-aqua">
                                <p>&nbsp;</p>
                                <a style="text-decoration:none" href="<?php echo base_url() . 'master/kategori_menu/daftar_kategori_menu/' ?>">
                                <div class="inner" style="background:url(<?php echo base_url().'component/admin/img/icon/task.png'?>) no-repeat center center;">
                                  <h3>&nbsp;</h3>
                                  <p>&nbsp;</p>
                                </div>
                                <div class="icon" style="margin-top:15px">
                                  <i class="ion-ios-list-outline"></i>
                                </div>
                                <a class="small-box-footer">Menu</a></a>
                              </div>
                            </div>

                            <div class="col-lg-3 col-xs-6">
                              <div class="small-box bg-yellow">
                                <a style="text-decoration:none"  href="<?php echo base_url() . 'master/supplier/' ?>">
                                <p>&nbsp;</p>
                                <div class="inner" style="background:url(<?php echo base_url().'component/admin/img/icon/pemasok.png'?>) no-repeat center center;">
                                  <h3>&nbsp;</h3>
                                  <p>&nbsp;</p>
                                </div>
                                <div class="icon" style="margin-top:15px">
                                  <i class="ion-ios-list-outline"></i>
                                </div>
                                <a class="small-box-footer">Supplier</a></a>
                              </div>
                            </div>

                            <div class="col-lg-3 col-xs-6">
                              <div class="small-box bg-red">
                                <a style="text-decoration:none" href="<?php echo base_url() . 'master/meja_ruang/' ?>">
                                <p>&nbsp;</p>
                                <div class="inner" style="background:url(<?php echo base_url().'component/admin/img/icon/retail.png'?>) no-repeat center center;">
                                  <h3>&nbsp;</h3>
                                  <p>&nbsp;</p>
                                </div>
                                <div class="icon" style="margin-top:15px">
                                  <i class="ion-ios-list-outline"></i>
                                </div>
                                <a class="small-box-footer">Meja & Ruangan</a></a>
                              </div>
                            </div>

                            <div class="col-lg-3 col-xs-6">
                              <div class="small-box bg-blue">
                                <a style="text-decoration:none" href="<?php echo base_url() . 'master/member/' ?>">
                                <p>&nbsp;</p>
                                <div class="inner" style="background:url(<?php echo base_url().'component/admin/img/icon/user.png'?>) no-repeat center center;">
                                  <h3>&nbsp;</h3>
                                  <p>&nbsp;</p>
                                </div>
                                <div class="icon" style="margin-top:15px">
                                  <i class="ion-ios-list-outline"></i>
                                </div>
                                <a class="small-box-footer">Member</a></a>
                              </div>
                            </div>

                            <div class="col-lg-3 col-xs-6">
                              <div class="small-box bg-green">
                                <a style="text-decoration:none" href="<?php echo base_url() . 'master/hak_akses/' ?>">
                                <p>&nbsp;</p>
                                <div class="inner" style="background:url(<?php echo base_url().'component/admin/img/icon/signout.png'?>) no-repeat center center;">
                                  <h3>&nbsp;</h3>
                                  <p>&nbsp;</p>
                                </div>
                                <div class="icon" style="margin-top:15px">
                                  <i class="ion-ios-list-outline"></i>
                                </div>
                                <a class="small-box-footer">Hak Akses</a></a>
                              </div>
                            </div>

                            <div class="col-lg-3 col-xs-6">
                              <div class="small-box bg-aqua">
                                <a style="text-decoration:none" href="<?php echo base_url() . 'master/jabatan/' ?>">
                                <p>&nbsp;</p>
                                <div class="inner" style="background:url(<?php echo base_url().'component/admin/img/icon/userguide.png'?>) no-repeat center center;">
                                  <h3>&nbsp;</h3>
                                  <p>&nbsp;</p>
                                </div>
                                <div class="icon" style="margin-top:15px">
                                  <i class="ion-ios-list-outline"></i>
                                </div>
                                <a class="small-box-footer">Jabatan</a></a>
                              </div>
                            </div>

                            <div class="col-lg-3 col-xs-6">
                              <div class="small-box bg-yellow">
                                <a style="text-decoration:none" href="<?php echo base_url() . 'master/karyawan/' ?>">
                                <p>&nbsp;</p>
                                <div class="inner" style="background:url(<?php echo base_url().'component/admin/img/icon/user.png'?>) no-repeat center center;">
                                <h3>&nbsp;</h3>
                                <p>&nbsp;</p>
                                </div>
                                <div class="icon" style="margin-top:15px">
                                  <i class="ion-ios-list-outline"></i>
                                </div>
                                <a class="small-box-footer">Karyawan</a></a>
                              </div>
                            </div> 
                            
                            <div class="col-lg-3 col-xs-6">
                              <div class="small-box bg-red">
                                <a style="text-decoration:none" href="<?php echo base_url() . 'master/user/' ?>">
                                <p>&nbsp;</p>
                                <div class="inner" style="background:url(<?php echo base_url().'component/admin/img/icon/userguide.png'?>) no-repeat center center;">
                                  <h3>&nbsp;</h3>
                                  <p>&nbsp;</p>
                                </div>
                                <div class="icon" style="margin-top:15px">
                                  <i class="ion-ios-list-outline"></i>
                                </div>
                                <a class="small-box-footer">User</a></a>
                              </div>
                            </div>

                        </div>

                    </div>
                </div>
            </section><!-- /.Left col -->      
        </div><!-- /.row (main row) -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->