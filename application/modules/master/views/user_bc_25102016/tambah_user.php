<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Data User

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
          <form id="data_form"  method="post">
            <div class="box-body">            
              <div class="row">
                <?php
                $uri = $this->uri->segment(4);
                if(!empty($uri)){
                  $data = $this->db->get_where('master_user',array('id'=>$uri));
                  $hasil_data = $data->row();
                }
                ?>
                            <!--<div class="form-group  col-xs-5">
                              <label>ID Member</label>
                              <input type="text" class="form-control" name="id_member" readonly="" />
                            </div>-->

                            <div class="form-group  col-xs-5">
                              <label class="gedhi">Username</label>
                              <input type="hidden" name="id" value="<?php echo @$hasil_data->id ?>" />
                              <input type="text" class="form-control" value="<?php echo @$hasil_data->uname; ?>" name="uname" />
                            </div>

                            <div class="form-group  col-xs-5">
                              <label class="gedhi">Password</label>
                              <input type="password" class="form-control" value="<?php echo paramDecrypt(@$hasil_data->upass); ?>" name="upass" id="upass" />
                            </div>

                            <div class="form-group  col-xs-5">
                              <label class="gedhi">Jabatan</label>
                              <?php
                              $jabatan = $this->db->get('master_jabatan');
                              $hasil_jabatan = $jabatan->result();
                              ?>
                              <select class="form-control select2" name="jabatan" id="jabatan">
                                <option selected="true" value="">--Pilih Jabatan--</option>
                                <?php foreach($hasil_jabatan as $daftar){ ?>
                                <option <?php echo (@$daftar->kode_jabatan == @$hasil_data->jabatan) ? 'selected' : '' ?> value="<?php echo $daftar->kode_jabatan ?>"><?php echo $daftar->nama_jabatan ?></option>
                                <?php } ?>
                              </select>
                            </div>

                            <!--<div class="form-group  col-xs-5">
                              <label class="gedhi">Hak Akses</label>
                              <input type="text" class="form-control" value="<?php #echo @$hasil_data->modul; ?>" name="modul" />
                            </div>-->

                            <div class="form-group  col-xs-5">
                              <label class="gedhi">Status</label>
                              <select class="form-control select2" name="status" id="status" >
                                <option selected="true" value="">--Pilih Status--</option>
                                <option <?php echo "1" == @$hasil_data->status ? 'selected' : '' ?> value="1" >Aktif</option>
                                <option <?php echo "0" == @$hasil_data->status ? 'selected' : '' ?> value="0" >Tidak Aktif</option>
                              </select>
                            </div>
                            <br>
                            <div id="modul">
                              <div class="form-group  col-xs-9">
                                <label class="gedhi"><h3><b>Hak Akses</b></h3></label>
                              </div>
                              <div class="form-group col-xs-9">
                                <table border="1" class="table table-bordered table-striped">
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
                            </div>
                          </div>

                        </div>

                        <div class="box-footer">
                          <button type="submit" class="btn btn-primary">Submit</button>
                        </div>

                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!------------------------------------------------------------------------------------------------------>

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
            window.location = "<?php echo base_url().'master/user/'; ?>";
          });
        </script>

          <script type="text/javascript">

          $(document).ready(function(){
           $(".select2").select2();       
           $('#modul').hide();
           <?php if(!empty($uri)){ ?>
            $('#modul').show();
            <?php }else{ ?>
              $('#modul').hide();
              <?php } ?>
            });

          $(function () {

            $('#jabatan').change(function(){

              var jabatan = $('#jabatan').val();
              if(jabatan == ''){
               $('#modul').hide();
             }
             else{
              $('#modul').show();
            }
          });

      //jika tombol Send diklik maka kirimkan data_form ke url berikut

      $('#data_form').submit(function(){

        <?php 
        $uri = $this->uri->segment(4);
        if(!empty($uri)){ ?>
          var url = "<?php echo base_url(). 'master/user/simpan_edit_user'; ?>";  
          <?php }else{ ?>
            var url = "<?php echo base_url(). 'master/user/simpan_tambah_user'; ?>";
            <?php } ?>

            $.ajax( {  
              type : "post", 
              url : url,
              cache : false,  
              data : $(this).serialize(),
              beforeSend:function(){
          $(".tunggu").show();  
        },
 success : function(data) {  
                $(".sukses").html(data);   
                setTimeout(function(){$('.sukses').html('');
                  window.location = "<?php echo base_url() . 'master/user/' ?>";
                },1500);      
              },  
              error : function() {  
                alert("Data gagal dimasukkan.");  
              }  
            });
            return false;
          });


    });

</script>