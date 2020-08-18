<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Tambah Data Proyek
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
        //echo $param;
        if(!empty($param)){
          $proyek = $this->db->get_where('master_proyek',array('id'=>$param));
          $hasil_proyek = $proyek->row();
          //echo $hasil_bahan_baku->kode_barang;
        }    
        $this->db->select_max('id');
        $get_max_proyek = $this->db->get('master_proyek');
        $max_proyek = $get_max_proyek->row();

        $this->db->where('id', $max_proyek->id);
        $get_proyek = $this->db->get('master_proyek');
        $proyek = $get_proyek->row();
        $nomor = substr(@$proyek->kode_proyek, 4);
        $nomor = $nomor + 1;
        $string = strlen($nomor);
        if($string == 1){
          $kode_proyek ='000'.$nomor;
        } else if($string == 2){
          $kode_proyek ='00'.$nomor;
        } else if($string == 3){
          $kode_proyek ='0'.$nomor;
        } else if($string == 4){
          $kode_proyek =''.$nomor;
        } 
        // else if($string == 5){
        //   $kode_proyek ='0'.$nomor;
        // } else if($string == 6){
        //   $kode_proyek =''.$nomor;
        // }

        ?>
        <div class="box-body">                   
          <div class="sukses" ></div>
          <form id="data_form" method="post">
            <div class="box-body">            
              <div class="row">


                <div class="form-group  col-xs-6">
                  <label><b>Kode Proyek</label>
                  <div class="">
                    <input readonly name="kode_proyek" value="<?php if(!empty($param)){echo @$hasil_proyek->kode_proyek; }else{ echo "CST_".$kode_proyek;} ?>"   type="text" class="form-control" id="kode_proyek" />
                  </div>
                </div>

               


                  <div class="input_nama_proyek form-group  col-xs-6">
                    <label><b>Nama Proyek</label>
                    <div class="">
                      <input readonly="" name="nama_proyek" value="<?php echo @$hasil_proyek->nama_proyek ?>"  type="text" class="form-control" id="nama_proyek" />
                    </div>
                  </div>


            
                  <div class="input_no_ktp form-group  col-xs-6">
                    <label><b>Nama Manajer</label>
                    <div class="">
                      <input readonly="" name="nama_manajer" value="<?php echo @$hasil_proyek->nama_manajer ?>"  type="text" class="form-control" id="nama_manajer" />
                    </div>
                  </div>


                  <div class="input_alamat form-group  col-xs-6">
                    <label><b>Alamat</label>
                    <div class="">
                      <input readonly="" name="alamat_proyek" value="<?php echo @$hasil_proyek->alamat_proyek ?>"   type="text" class="form-control" id="alamat_proyek" />
                    </div>
                  </div>


                  
                  <div class="input_nama_bank form-group  col-xs-6">
                    <label><b>Nama Bank</label>
                    <div class="">
                      <input readonly="" name="nama_bank" value="<?php echo @$hasil_proyek->nama_bank ?>"  type="text" class="form-control" id="nama_bank" />
                    </div>
                  </div>

                  <div class="input_no_rekening form-group  col-xs-6">
                    <label><b>No. Rekening</label>
                    <div class="">
                      <input readonly="" name="no_rekening" value="<?php echo @$hasil_proyek->no_rekening ?>"  type="text" class="form-control" id="no_rekening" />
                    </div>
                  </div>
                  <div class="input_telp form-group  col-xs-6">
                    <label><b>Telepon</label>
                    <div class="">
                      <input readonly="" name="telp_proyek" value="<?php echo @$hasil_proyek->telp_proyek ?>"  type="text" class="form-control" id="telp_proyek" />
                    </div>
                  </div>

                  <div class="input_keterangan form-group  col-xs-6">
                    <label><b>Keterangan</label>
                    <div class="">
                      <input readonly="" name="keterangan" value="<?php echo @$hasil_proyek->keterangan ?>"  type="text" class="form-control" id="keterangan" />
                    </div>
                  </div>


                  <div class="input_status_proyek form-group  col-xs-6">
                    <label><b>Status Proyek</label>
                    <div class="">
                     <select class="form-control" id="status" name="status_proyek" disabled="">
                       <option <?php if(@$hasil_proyek->status_proyek==''){ echo 'selected'; } ?> value="" >Pilih</option>
                       <option <?php if(@$hasil_proyek->status_proyek=='1'){ echo 'selected'; } ?> value="1">Aktif</option>
                       <option <?php if(@$hasil_proyek->status_proyek=='0'){ echo 'selected'; } ?> value="0">Tidak Aktif</option>
                     </select>
                   </div>
                 </div>

                 <br>
                 <br>
                 <br>


                 <!--  -->



               </div>
               <div class="box-footer">
                <a onclick="history.go(-1)" class="btn btn-primary">Kembali</a>
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
    window.location = "<?php echo base_url().'master/proyek/daftar'; ?>";
  });
</script>
<script type="text/javascript">
  $(function(){

    $("#data_form").submit( function() {
     <?php if(!empty($param)){ ?>
      var url = "<?php echo base_url(). 'master/proyek/simpan_ubah'; ?>";  
      <?php }else{ ?>
        var url = "<?php echo base_url(). 'master/proyek/simpan_tambah'; ?>";
        <?php } ?>
        $.ajax( {
         type:"POST", 
         url : url,  
         cache :false,  
         data :$(this).serialize(),
         beforeSend: function(){
           $(".loading").show(); 
         },
         beforeSend:function(){
          $(".tunggu").show();  
        },
        success : function(data) {
        //if(data=="sukses"){
         $(".sukses").html('<div class="alert alert-success">Data Berhasil Disimpan</div>');
         setTimeout(function(){$('.sukses').html('');window.location = "<?php echo base_url() . 'master/proyek/daftar' ?>";},1000);  
        // }
        // else{
        //     $(".sukses").html(data);
        // }
        $(".loading").hide();   

      },  
      error : function(data) {  
        alert(data);  
      }  
    });
        return false;                    
      }); 
  })
</script>
<script type="text/javascript">
  $(document).ready(function(){

    

  });
</script>