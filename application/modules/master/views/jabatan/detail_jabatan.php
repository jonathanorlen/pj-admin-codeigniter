

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    
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
            
            <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
        Data Jabatan
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
        $param = $this->uri->segment(4);
        if(!empty($param)){
          $bahan_baku = $this->db->get_where('master_bahan_baku',array('id'=>$param));
          $hasil_bahan_baku = $bahan_baku->row();
        }    

        ?>
        <div class="box-body">                   
          <div class="sukses" ></div>
          <form id="data_jabatan"  method="post">         
                          <div class="row">  
                            
                            <?php
                                $uri = $this->uri->segment(4);
                                if(!empty($uri)){
                                    $data = $this->db->get_where('master_jabatan',array('kode_jabatan'=>$uri));
                                    $hasil_data = $data->row();
                                }
                            ?>

                            <div class="form-group  col-xs-5">
                              <label class="gedhi">Kode Jabatan</label>
                              <input type="hidden" name="id" value="<?php echo @$hasil_data->id ?>" />
                              <input type="text" class="form-control" value="<?php echo @$hasil_data->kode_jabatan; ?>" name="kode_jabatan" id="kode_jabatan" readonly/>
                            </div>

                            <div class="form-group  col-xs-5">
                              <label class="gedhi">Nama Jabatan</label>
                              <input type="text" class="form-control" value="<?php echo @$hasil_data->nama_jabatan; ?>" name="nama_jabatan" id="nama_jabatan" readonly/>
                            </div>

                            <div class="form-group  col-xs-5">
                              <label class="gedhi">Keterangan</label>
                              <input type="text" class="form-control" value="<?php echo @$hasil_data->keterangan; ?>" name="keterangan" id="keterangan" readonly/>
                            </div>

                            <div id="modul">
                                <div class="form-group  col-xs-9">
                                    <label class="gedhi"><h3><b>Hak Akses</b></h3></label>
                                </div>
                                <div class="form-group col-xs-9">
                                      <table style="font-size: 1.5em;" border="1" class="table table-bordered table-striped">
                                          <thead >
                                              <tr>
                                                  <th width="35px" ><center>No</center></th>
                                                  <th width="250px"><center>Nama Modul</center></th>
                                                  <th width="300px"><center>Checklist Modul yang Dipilih</center></th>
                                              </tr>
                                          </thead>
                                          <?php 

                                              $arr_modul = array();
                                              if(!empty($data))
                                              {
                                                  $arr_modul = explode('|', $hasil_data->modul);
                                              }

                                              $modul = $this->db->get_where('master_modul', array('status' => 1));
                                              $hasil_modul = $modul->result();
                                              if(!empty($hasil_modul)){
                                                  $no=1;
                                                  foreach ($hasil_modul as $key => $value){ ?>
                                                      <tr>
                                                          <td align="center"><?php echo $no;?></td>
                                                          <td align="center"><?php echo $value->modul;?></td>
                                                          <td><center><input type="checkbox" name="modul[]" disabled="true" value="<?php echo $value->modul;?>" <?php echo (in_array($value->modul, $arr_modul)) ? 'checked':'';?> ></center></td>
                                                      </tr>                            
                                                      <?php $no++; 
                                                  } 
                                              }
                                              else{
                                                  echo '<tr><td colspan="3">Modul Tidak ada yang aktif</td></tr>';
                                              }
                                          ?>
                                      </table> 
                                  </div>
                            </div>
                            

                          </div>
                        </form>
                </div>
              </div>
            </div>
                <!-- /.row (main row) -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

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
            window.location = "<?php echo base_url().'master/jabatan/'; ?>";
          });
        </script>

