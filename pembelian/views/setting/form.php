<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Pendaftaran Anggota

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
        $parameter = $this->uri->segment(3);
        $ambil_data = $this->db->query(" SELECT * FROM anggota where nomor_anggota='$parameter' ");
        $hasil_ambil_data = $ambil_data->row(); 

        ?>
        <div class="box-body">                   
          <div class="sukses" ></div>
          <form method="post" id="data_form" name="data_form">  
            <div class="form-group">

              <div class="form-group">

                <div class="col-md-6">
                  <label >Nama Anggota</label>
                  <input type="hidden" name="no_transaksi" value="<?php if(!empty($hasil_ambil_data->no_transaksi)){echo $hasil_ambil_data->no_transaksi;} ?>"  />
                  <input type="hidden" name="nomor_anggota" value="<?php if(!empty($hasil_ambil_data->nomor_anggota)){echo $hasil_ambil_data->nomor_anggota;} ?>"  />
                  <input type="text" name="nama_anggota" class="form-control" placeholder="Nama Anggota" value="<?php if(!empty($hasil_ambil_data->nama)){echo $hasil_ambil_data->nama;} ?>" required />
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-6">   

                <input type="hidden" name="nomor_anggota" class="form-control" value="<?php  if(!empty($hasil_ambil_data->nomor_anggota)){echo $hasil_ambil_data->nomor_anggota;} else{echo 'PEN_'.date("Ymdhis");}?> " >
              </div>

            </div> 


            <div class="form-group">
              <div class="col-md-6">
                <label>Tempat Lahir</label>
                <input type="text" name="tempat_lahir" class="form-control" placeholder="Tempat Lahir" value="<?php if(!empty($hasil_ambil_data->tempat_lahir)){echo $hasil_ambil_data->tempat_lahir;} ?>" required>
              </div>
            </div>

            <div class="form-group">
              <div class="col-md-6">
                <label>Tanggal Lahir</label>
                <div class="input-group date date-picker" data-date-format="dd-mm-yyyy">
                  <input type="text" class="form-control" name="tanggal_lahir" value="<?php if(!empty($hasil_ambil_data->tanggal_lahir)){echo $hasil_ambil_data->tanggal_lahir;} ?>" readonly="">
                  <span class="input-group-btn">
                    <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                  </span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-6">
                <label>No KTP Anggota</label>
                <input type="text" name="no_ktp" class="form-control" placeholder="No KTP Anggota" value="<?php if(!empty($hasil_ambil_data->no_ktp)){echo $hasil_ambil_data->no_ktp;} ?>" required>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-12">
                <label>Alamat</label>
                <textarea class="form-control" name="alamat" rows="3" placeholder="Alamat"  required=""><?php if(!empty($hasil_ambil_data->alamat)){echo $hasil_ambil_data->alamat;} ?></textarea>
              </div>
            </div>

            <div class="form-group">
              <div class="col-md-12">
                <br>
                <table class="table table-striped table-hover table-bordered" id="sample_editable_1"  style="font-size:1.5em;">
                  <thead>
                    <tr>
                      <th width="50px;">No</th>
                      <th>Tipe Sapi</th>
                      <th>Milik Sendiri</th>
                      <th>Rumatan</th>
                      <th>Jumlah</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $tipe_sapi = $this->db->get('tipe_sapi');
                    $hasil_tipe_sapi = $tipe_sapi->result_array();
                    $no = 0;
                    $tipe = 0;
                    $total=0;
                    
                    //$parameter = $this->uri->segment(3);
                    $tipe_sapi_anggota = $this->db->query(" SELECT * FROM opsi_sapi_anggota where no_anggota='$parameter' ");
                    $hasil_tipe_sapi_anggota = $tipe_sapi_anggota->row();
                      
                    foreach ($hasil_tipe_sapi as $item) {                
                      
                      $item_str = str_replace(' ', '_',$item['tipe']);
                      $no++;

                      $milik_sendiri=$item_str."_milik_sendiri";
                      $rumatan=$item_str."_rumatan";
                      
                      ?>
                      <tr>
                        <td><?php echo $no;?></td>
                        <td><?php echo $item['tipe'];?></td>
                        <td width="10%">
                          <input onkeypress="return hanyaAngka(event)" placeholder="0" id="milik_sendiri<?php echo $item_str;?>" type="text" name="milik_sendiri<?php echo $item_str;?>" class="form-control" value="<?php echo @$hasil_tipe_sapi_anggota->$milik_sendiri;?>" />
                        </td>                  
                        <td width="10%">
                          <input onkeypress="return hanyaAngka(event)" placeholder="0" id="rumatan<?php echo $item_str;?>" type="text" name="rumatan<?php echo $item_str;?>" class="form-control" value="<?php echo @$hasil_tipe_sapi_anggota->$rumatan;?>" />
                        </td>
                        <td width="10%">
                          <input id="jumlah<?php echo $item_str;?>" readonly="readonly" type="text" name="jumlah<?php echo $item_str?>" class="form-control" value="<?php echo @$hasil_tipe_sapi_anggota->$rumatan + @$hasil_tipe_sapi_anggota->$milik_sendiri;?>" required />
                        </td>           
                      </tr>
                      <?php
                      $total=$total+(@$hasil_tipe_sapi_anggota->$rumatan + @$hasil_tipe_sapi_anggota->$milik_sendiri);
                      $tipe++; 
                    } ?>
                  </tbody> 
                  <thead>
                    <tr style="background-color: #7f8d47;">
                      <td colspan="4"><b>Total</b></td>
                      <td width="10%">
                        <input id="total_semua" readonly="readonly" type="text" name="total_semua" class="form-control" required value="<?php echo @$total?>"/>
                      </td>  
                    </tr>
                  </thead>              
                </table>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-12">
                <label>Kondisi Kandang</label>
                <select class="form-control" name="kondisi_kandang" required>              
                  <option <?php if(@$hasil_tipe_sapi_anggota->kondisi_kandang=='tidak_ada') {echo 'selected';} ?>
                    value="tidak_ada"    
                    >
                    Tidak ada sekat pemisah
                  </option>
                  <option <?php if(@$hasil_tipe_sapi_anggota->kondisi_kandang=='ada_sekat') {echo 'selected';} ?>
                    value="ada_sekat"    
                    >
                    ada sekat pemisah
                  </option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-6" style="width: 100%;">
                <button style="margin-top:30px" type="submit" class="pull-right btn btn-warning" id="data_form"><?php if(empty($parameter)){echo 'Save';}else{echo 'Update';} ?><i class="fa fa-arrow-circle-right"></i></button>
              </div>
            </div>
            <div class="box-footer clearfix"></div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!------------------------------------------------------------------------------------------------------>



<script type="text/javascript">
  $(document).ready(function(){  

    $("#data_form").submit( function() {    
      $.ajax( {  
        type :"post",  
        <?php
    if(empty($hasil_ambil_data)){
        ?>
        url : "<?php echo base_url() . 'anggota/simpan_tambah' ?>",  
        <?php
    }else{
        ?>
        url : "<?php echo base_url() . 'anggota/simpan_ubah' ?>",  
      <?php
    }
      ?>
      cache :false,  
      data :$(this).serialize(),
      beforeSend:function(){
          $(".tunggu").show();  
        },
 success : function(data) {  
        $(".sukses").html(data);   
        setTimeout(function(){$('.sukses').html('');window.location = "<?php echo base_url() . 'anggota/daftar' ?>";},1500);              
      }  

    });
      return false;                          
    });
    <?php
    foreach ($hasil_tipe_sapi as $item1) {
      $item1_str = str_replace(' ', '_',$item1['tipe']);
      ?>
      $("#milik_sendiri<?php echo $item1_str;?>").keyup( function() { 
        if(document.getElementById("rumatan<?php echo $item_str;?>").value == ""){
          rumatan<?php echo $item1_str;?> =  parseInt(document.getElementById("rumatan<?php echo $item1_str;?>").placeholder);
        } else {
          rumatan<?php echo $item1_str;?> =  parseInt(document.getElementById("rumatan<?php echo $item1_str;?>").value);
        }
        milik_sendiri<?php echo $item1_str?> = parseInt(document.getElementById("milik_sendiri<?php echo $item1_str;?>").value);

        if(document.getElementById("milik_sendiri<?php echo $item1_str;?>").value != ""){
          $("#jumlah<?php echo $item1_str;?>").val(milik_sendiri<?php echo $item1_str;?> + rumatan<?php echo $item1_str;?>);
        }
        
        var nol = 0;
        $("#total_semua").val(nol);
        <?php
        foreach ($hasil_tipe_sapi as $item2) {
          $item2_str = str_replace(' ', '_',$item2['tipe']);
          ?>
          if(document.getElementById("milik_sendiri<?php echo $item2_str;?>").value != ""){
            var total = parseInt($("#jumlah<?php echo $item2_str;?>").val()) + parseInt($("#total_semua").val());
            $("#total_semua").val(total);
          }
          <?php
        }
        ?>

      });

      $("#rumatan<?php echo $item1_str;?>").keyup( function() {   
        if(document.getElementById("milik_sendiri<?php echo $item1_str;?>").value == ""){
          milik_sendiri<?php echo $item1_str;?> = parseInt(document.getElementById("milik_sendiri<?php echo $item1_str;?>").placeholder);
        } else {
          milik_sendiri<?php echo $item1_str;?> = parseInt(document.getElementById("milik_sendiri<?php echo $item1_str;?>").value);
        }

        rumatan<?php echo $item1_str;?> =  parseInt(document.getElementById("rumatan<?php echo $item1_str;?>").value);

        if(document.getElementById("rumatan<?php echo $item1_str;?>").value != ""){
          $("#jumlah<?php echo $item1_str;?>").val(milik_sendiri<?php echo $item1_str;?> + rumatan<?php echo $item1_str;?>);
        }

        var nol = 0;
        $("#total_semua").val(nol);
        <?php
        foreach ($hasil_tipe_sapi as $item3) {
           $item3_str = str_replace(' ', '_',$item3['tipe']);
          ?>
          if(document.getElementById("rumatan<?php echo $item3_str;?>").value != ""){
            var total = parseInt($("#jumlah<?php echo $item3_str;?>").val()) + parseInt($("#total_semua").val());
            $("#total_semua").val(total);
          }
          <?php
        }
        ?>

      });
      <?php
    }
    ?>
  });
  function hanyaAngka(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))

      return false;
    return true;
  }
</script>

