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
                Detail Anggota
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
          <form method="post" id="data_form1"> 
            <div class="form-group">
              <div class="col-md-4">
                  <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                      <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="">
                  </div> 
                </div>
              </div>

            <div class="form-group">
             <div class="col-md-6">   

              <input type="hidden" name="nomor_anggota" class="form-control"  value="<?php  if(!empty($hasil_ambil_data->nomor_anggota)){echo $hasil_ambil_data->nomor_anggota;} else{echo 'PEN_'.date("Ymdhis");}?> " >
            </div>
          </div>  

            <div class="form-group">
              <div class="col-md-8">
                <label>Nama Anggota</label>
                <input type="text" name="nama_anggota" class="form-control" value="<?php if(!empty($hasil_ambil_data->nama)){echo $hasil_ambil_data->nama;} ?>" disabled>
              </div>
           </div>
        </div>
        
          <div class="form-group">
             <div class="col-md-8">   
              <label>No Transaksi Anggota</label>
              <input type="text" name="no_transaksi_anggota" class="form-control" disabled placeholder="No Transaksi Anggota Kelompok" value="<?php  if(!empty($hasil_ambil_data->no_transaksi)){echo $hasil_ambil_data->no_transaksi;} else{echo $hasil_ambil_data->no_transaksi;}?> " >
            </div>
          </div> 
        
           <div class="form-group">
            <div class="col-md-8">
              <label>Alamat Anggota</label>
              <input type="text" name="alamat_anggota" class="form-control" disabled placeholder="Alamat" value="<?php if(!empty($hasil_ambil_data->alamat)){echo $hasil_ambil_data->alamat;} ?>" >
            </div>
          </div>

          <div class="form-group">
            <div class="col-md-4">
              <label>No KTP Anggota</label>
              <input type="text" name="no_ktp_anggota" class="form-control" disabled placeholder="No KTP Anggota" value="<?php if(!empty($hasil_ambil_data->no_ktp)){echo $hasil_ambil_data->no_ktp;} ?>" >
            </div>
          </div>

          <div class="form-group">
            <div class="col-md-4">
            <label>Jenis Anggota</label>
              <select class="form-control" name="kode_jenis_anggota" disabled>
                 
                
                 <?php 
                 $get = $this->db->get('jenis_anggota');
                 $hasil_get = $get->result_array();

                 foreach ($hasil_get as $item) {                
                  ?>                
                  <option 
                  <?php if(@$hasil_ambil_data->kode_jenis_anggota==$item['kode_jenis_anggota']) {echo 'selected';} ?>
                  value="<?php echo $item['kode_jenis_anggota'];?>"                  
                  >
                  <?php echo $item['nama_jenis_anggota'];?>
                </option>


                <?php } ?>

              </select>

              </div>
          </div>

          <div class="form-group">
            <div class="col-md-4">
            <label>Kelompok</label>
              <select class="form-control" name="kode_kelompok" disabled>
                 <?php 
                 $get = $this->db->get('kelompok_anggota');
                 $hasil_get = $get->result_array();

                 foreach ($hasil_get as $item) {                
                  ?>                
                  <option 
                  <?php if(@$hasil_ambil_data->kode_kelompok==$item['kode_kelompok']) {echo 'selected';} ?>
                  value="<?php echo $item['kode_kelompok'];?>"                  
                  >
                  <?php echo $item['nama_kelompok'];?>
                </option>


                <?php } ?>


  
              </select>
              </div>
          </div>
            <div class="form-group">
            <div class="col-md-4">
            <label>jabatan Anggota</label>
              <select class="form-control" name="jabatan_anggota" disabled >
                 <option>Ketua</option>
                 <option>Anggota</option>                 
              </select>
              </div>
          </div>
           
           <div class="form-group">
            <div class="col-md-4">
              <label>Status</label>
              <select class="form-control" name="status" disabled>              
                <option 
                <?php if(@$hasil_ambil_data->status=1) {echo 'selected';} ?>
                value="1"    
                >
                Aktif
              </option>
              <option 
              <?php if(@$hasil_ambil_data->status=0) {echo 'selected';} ?>
              value="0"    
              >
              Tidak Aktif
            </option>
            </select>
          </div>
        </div>
     
       
        <div class="box-footer clearfix">
                         
 <button style="margin-top:30px; left-margin:70px;" type="button" class="pull-right btn btn-default" id="daftar">Ok<i class="fa fa-arrow-circle-right"></i></button>
   
        </div>  

        <div class="form-group">     
        

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

<script type="text/javascript">
  $(function () {  
    $("#daftar").click(function(){
      window.location = "<?php echo base_url() . 'anggota/daftar' ?>";
    });
  });
</script>

