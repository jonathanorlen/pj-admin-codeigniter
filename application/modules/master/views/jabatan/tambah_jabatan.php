

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
                            ?>
                              <input type="hidden" name="kode_jabatan_uri" value="<?php echo @$hasil_data->kode_jabatan ?>" />
                            <?php
                                }
                            ?>

                            <div class="form-group  col-xs-5">
                              <label class="gedhi">Kode Jabatan</label>
                              <input type="hidden" name="id" value="<?php echo @$hasil_data->id ?>" />
                              <input <?php if(!empty($uri)){ echo "readonly='true'"; } ?> type="text" class="form-control" value="<?php echo @$hasil_data->kode_jabatan; ?>" name="kode_jabatan" id="kode_jabatan"/>
                            </div>

                            <div class="form-group  col-xs-5">
                              <label class="gedhi">Nama Jabatan</label>
                              <input type="text" class="form-control" value="<?php echo @$hasil_data->nama_jabatan; ?>" name="nama_jabatan" id="nama_jabatan"/>
                            </div>
                            
                            <div class="form-group  col-xs-5">
                              <label class="gedhi">Keterangan</label>
                              <input type="text" class="form-control" value="<?php echo @$hasil_data->keterangan; ?>" name="keterangan" id="keterangan"/>
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
                                                          <td><center><input type="checkbox" name="modul[]" value="<?php echo $value->modul;?>" <?php echo (in_array($value->modul, $arr_modul)) ? 'checked':'';?> ></center></td>
                                                      </tr>                            
                                                      <?php $no++; 
                                                  } 
                                              }
                                              else{
                                                  echo '<tr><td colspan="3">Modul Tidak ada yang aktif</td></tr>';
                                              }
                                          ?>
                                      </table> 
                                      
                                      <div class="form-group  col-xs-3">
                           
                            <button type="submit" class="btn btn-lg btn-primary"><i class="fa fa-save"></i> Simpan</button>
                          </div>
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
<div id="modal-confirm-temp" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color:grey">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title" style="color:#fff;">Konfirmasi Hapus Data</h4>
            </div>
            <div class="modal-body">
                <span style="font-weight:bold; font-size:14pt">Apakah anda yakin akan menghapus data komposisi tersebut ?</span>
                <input id="id-delete" type="hidden">
            </div>
            <div class="modal-footer" style="background-color:#eee">
                <button class="btn green" data-dismiss="modal" aria-hidden="true">Tidak</button>
                <button onclick="delDataTemp()" class="btn red">Ya</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function(){

        $('#kode_jabatan').on('change',function(){
          var kode_jabatan = $('#kode_jabatan').val();
          var url = "<?php echo base_url() . 'master/jabatan/get_kode' ?>";
          $.ajax({
              type: 'POST',
              url: url,
              data: {kode_jabatan:kode_jabatan},
              success: function(msg){
                  if(msg == 1){
                    $(".sukses").html('<div class="alert alert-warning">Kode_Telah_dipakai</div>');
                      setTimeout(function(){
                        $('.sukses').html('');
                    },1700);              
                    $('#kode_jabatan').val('');
                  }
                  else{

                  }
              }
          });
        });

          $(".select2").select2();
          $("#tabel_daftar").dataTable();
    });

    $(function () {
      //jika tombol Send diklik maka kirimkan data_form ke url berikut
      $("#data_jabatan").submit( function() { 

          $.ajax( {  
            type :"post", 
            <?php 
              if (empty($uri)) {
            ?>
            //jika tidak terdapat segmen maka simpan di url berikut
              url : "<?php echo base_url() . 'master/jabatan/simpan_tambah_jabatan'; ?>",
            <?php }
              else { ?>
            //jika terdapat segmen maka simpan di url berikut
              url : "<?php echo base_url() . 'master/jabatan/simpan_edit_jabatan'; ?>",
            <?php }
            ?>  
            cache :false,  
            data :$(this).serialize(),
            beforeSend:function(){
          $(".tunggu").show();  
        },
 success : function(data) {  
              $(".sukses").html(data);   
              setTimeout(function(){$('.sukses').html('');
                window.location = "<?php echo base_url() . 'master/jabatan/' ?>";},1500);              
            },  
            error : function() {  
              alert("Data gagal dimasukkan.");  
            }  
          });
          return false;                          
        });   

      
    });

</script>