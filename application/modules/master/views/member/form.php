<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Tambah Data Member
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
          $member = $this->db->get_where('master_member',array('id'=>$param));
          $hasil_member = $member->row();
          //echo $hasil_bahan_baku->kode_barang;
        }    
        $this->db->select_max('id');
        $get_max_member = $this->db->get('master_member');
        $max_member = $get_max_member->row();

        $this->db->where('id', $max_member->id);
        $get_member = $this->db->get('master_member');
        $member = $get_member->row();
        $nomor = substr(@$member->kode_member, 4);
        $nomor = $nomor + 1;
        $string = strlen($nomor);
        if($string == 1){
          $kode_member ='000'.$nomor;
        } else if($string == 2){
          $kode_member ='00'.$nomor;
        } else if($string == 3){
          $kode_member ='0'.$nomor;
        } else if($string == 4){
          $kode_member =''.$nomor;
        } 
        // else if($string == 5){
        //   $kode_member ='0'.$nomor;
        // } else if($string == 6){
        //   $kode_member =''.$nomor;
        // }

        ?>
        <div class="box-body">                   
          <div class="sukses" ></div>
          <form id="data_form" method="post">
            <div class="box-body">            
              <div class="row">


                <div class="form-group  col-xs-6">
                  <label><b>Kode Member</label>
                  <div class="">
                    <input readonly name="kode_member" value="<?php if(!empty($param)){echo @$hasil_member->kode_member; }else{ echo "CST_".$kode_member;} ?>"   type="text" class="form-control" id="kode_member" />
                  </div>
                </div>

                <!--<?php if (!empty($param)){ ?>

                  <div class="form-group  col-xs-6">
                    <label><b>Kategori Member</label>
                    <div class="">
                     <select class="form-control " id="kategori_member" name="kategori_member">
                       <option <?php if(@$hasil_member->kategori_member==''){ echo 'selected'; } ?> value="">Pilih</option>
                       <option <?php if(@$hasil_member->kategori_member=='perseorangan'){ echo 'selected'; } ?> value="perseorangan" id="kategori_perseorangan">Perseorangan</option>
                       <option <?php if(@$hasil_member->kategori_member=='lembaga'){ echo 'selected'; } ?> value="lembaga"
                         id="kategori_lembaga">Lembaga</option>
                       </select>
                     </div>
                   </div>

                   <?php }else{ ?>

                   <div class="form-group  col-xs-6">
                    <label><b>Kategori Member</label>
                    <div class="">
                     <select class="form-control kategori_member" id="kategori_member" name="kategori_member">
                       <option <?php if(@$hasil_member->kategori_member==''){ echo 'selected'; } ?> value="">Pilih</option>
                       <option <?php if(@$hasil_member->kategori_member=='perseorangan'){ echo 'selected'; } ?> value="perseorangan" id="kategori_perseorangan">Perseorangan</option>
                       <option <?php if(@$hasil_member->kategori_member=='lembaga'){ echo 'selected'; } ?> value="lembaga"
                         id="kategori_lembaga">Lembaga</option>
                       </select>
                     </div>
                   </div>
                   
                   <?php } ?>-->

                   <div class="form-group  col-xs-6">
                    <label><b>Kategori Member</label>
                    <div class="">
                      <select class="form-control kategori_member" id="kategori_member" name="kategori_member">
                        <option value="" selected="">--Pilih Kategori Member--</option>
                        <option value="perseorangan">Perseorangan</option>
                        <option value="lembaga">Lembaga</option>
                      </select>
                    </div>
                  </div>

                  <br>
                  <div id="div-data-lembaga" class="col-xs-12 form-group data_lembaga"><label><b>DATA LEMBAGA</label></div>
                  <div id="div-data-member" class="col-xs-12 form-group data_member"><label><b>DATA PERSEORANGAN</label></div>
                  <br>

                  <div id="div-nama-lembaga" class="input_nama_lembaga form-group  col-xs-6">
                    <label><b>Nama Lembaga</label>
                    <div class="">
                      <input name="nama_lembaga" value="<?php echo @$hasil_member->nama_lembaga ?>"  type="text" class="form-control" id="nama_lembaga" />
                    </div>
                  </div>

                  <div id="div-alamat-lembaga" class="input_alamat_lembaga form-group  col-xs-6">
                    <label><b>Alamat Lembaga</label>
                    <div class="">
                      <input name="alamat_lembaga" value="<?php echo @$hasil_member->alamat_lembaga ?>"   type="text" class="form-control" id="alamat_lembaga" />
                    </div>
                  </div>

                  <div id="div-telp-lembaga" class="input_telp_lembaga form-group  col-xs-6">
                    <label><b>Telepon Lembaga</label>
                    <div class="">
                      <input name="telp_lembaga" value="<?php echo @$hasil_member->telp_lembaga ?>"  type="text" class="form-control" id="telp_lembaga" />
                    </div>
                  </div>


                  <!--LEMBAGA-->

                  <br>
                  <div id="div-data-pic" class="data_pic col-xs-12 form-group"><label><b>DATA PIC</label></div>
                 <!--  <div class="input_nama_pic form-group  col-xs-6">
                    <label><b>Nama PIC</label>
                    <div class="">
                      <input name="nama_member" value="<?php echo @$hasil_member->nama_member ?>"  type="text" class="form-control" id="nama_member" />
                    </div>
                  </div> -->

                  <div id="div-no-ktp" class="input_no_ktp form-group  col-xs-6">
                    <label><b>No.KTP</label>
                    <div class="">
                      <input name="no_ktp" value="<?php echo @$hasil_member->no_ktp ?>"  type="text" class="form-control" id="no_ktp" />
                    </div>
                  </div>

                  <div id="div-nama-member" class="input_nama_member form-group  col-xs-6">
                    <label><b>Nama Member</label>
                    <div class="">
                      <input name="nama_member" value="<?php echo @$hasil_member->nama_member ?>"  type="text" class="form-control" id="nama_member" />
                    </div>
                  </div>

                  <div id="div-tempat-lahir" class="input_nama_member form-group  col-xs-6">
                    <label><b>Tempat Lahir</label>
                    <div class="">
                      <input name="tempat_lahir" value="<?php echo @$hasil_member->tempat_lahir ?>"  type="text" class="form-control" id="tempat_lahir" />
                    </div>
                  </div>

                  <div id="div-tanggal-lahir" class="input_nama_member form-group  col-xs-6">
                    <label><b>Tanggal Lahir</label>
                    <div class="">
                      <input type="date" value="<?php echo @$hasil_member->tanggal_lahir ?>" class="form-control" placeholder="Tanggal Lahir" name="tanggal_lahir" id="tanggal_lahir"/>
                    </div>
                  </div>

                  <div id="div-jenis-kelamin" class="input_nama_member form-group  col-xs-6">
                    <label><b>Jenis Kelamin</label>
                    <div class="">
                      <select class="form-control kategori_member" id="jenis_kelamin" name="jenis_kelamin">
                        <option value="" selected="">--Pilih Jenis Kelamin--</option>
                        <option value="Laki - Laki">Laki - Laki</option>
                        <option value="Perempuan">Perempuan</option>
                      </select>
                    </div>
                  </div>


                  <div id="div-alamat-member" class="input_alamat form-group  col-xs-6">
                    <label><b>Alamat</label>
                    <div class="">
                      <input name="alamat_member" value="<?php echo @$hasil_member->alamat_member ?>"   type="text" class="form-control" id="alamat_member" />
                    </div>
                  </div>


                  <div id="div-keterangan" class="input_keterangan form-group  col-xs-6">
                    <label><b>Keterangan</label>
                    <div class="">
                      <input name="keterangan" value="<?php echo @$hasil_member->keterangan ?>"  type="text" class="form-control" id="keterangan" />
                    </div>
                  </div>

                  <div id="div-nama-bank" class="input_nama_bank_2 form-group  col-xs-6">
                    <label><b>Nama Bank</label>
                    <div class="">
                      <input name="nama_bank" value="<?php echo @$hasil_member->nama_bank ?>"  type="text" class="form-control" id="nama_bank" />
                    </div>
                  </div>

                  <div id="div-no-rekening" class="input_no_rekening_2 form-group  col-xs-6">
                    <label><b>No. Rekening</label>
                    <div class="">
                      <input name="no_rekening" value="<?php echo @$hasil_member->no_rekening ?>"  type="text" class="form-control" id="no_rekening" />
                    </div>
                  </div>
                  <!--<div class="input_nama_bank form-group  col-xs-6">
                    <label><b>Nama Bank</label>
                    <div class="">
                      <input name="nama_bank" value="<?php echo @$hasil_member->nama_bank ?>"  type="text" class="form-control" id="nama_bank" />
                    </div>
                  </div>

                  <div class="input_no_rekening form-group  col-xs-6">
                    <label><b>No. Rekening</label>
                    <div class="">
                      <input name="no_rekening" value="<?php echo @$hasil_member->no_rekening ?>"  type="text" class="form-control" id="no_rekening" />
                    </div>
                  </div>-->
                  <div id="div-telp" class="input_telp form-group  col-xs-6">
                    <label><b>Telepon</label>
                    <div class="">
                      <input name="telp_member" value="<?php echo @$hasil_member->telp_member ?>"  type="text" class="form-control" id="telp_member" />
                    </div>
                  </div>

                  <div id="div-status-member" class="input_status_member form-group  col-xs-6">
                    <label><b>Status Member</label>
                    <div class="">
                     <select class="form-control" id="status" name="status_member">
                       <option <?php if(@$hasil_member->status_member==''){ echo 'selected'; } ?> value="" >Pilih</option>
                       <option <?php if(@$hasil_member->status_member=='1'){ echo 'selected'; } ?> value="1">Aktif</option>
                       <option <?php if(@$hasil_member->status_member=='0'){ echo 'selected'; } ?> value="0">Tidak Aktif</option>
                     </select>
                   </div>
                 </div>

                 <br>
                 <br>
                 <br>


                 <!--  -->



               </div>
               <div class="box-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
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
    window.location = "<?php echo base_url().'master/member/daftar'; ?>";
  });
</script>
<script type="text/javascript">
  $(function(){

    $("#data_form").submit( function() {
     <?php if(!empty($param)){ ?>
      var url = "<?php echo base_url(). 'master/member/simpan_ubah'; ?>";  
      <?php }else{ ?>
        var url = "<?php echo base_url(). 'master/member/simpan_tambah'; ?>";
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
         setTimeout(function(){$('.sukses').html('');window.location = "<?php echo base_url() . 'master/member/daftar' ?>";},1000);  
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

    $('#div-data-lembaga').hide();
    $('#div-data-member').hide();
    $('#div-nama-lembaga').hide();
    $('#div-alamat-lembaga').hide();
    $('#div-telp-lembaga').hide();
    $('#div-data-pic').hide();
    $('#div-no-ktp').hide();
    $('#div-nama-member').hide();
    $('#div-tempat-lahir').hide();
    $('#div-tanggal-lahir').hide();
    $('#div-jenis-kelamin').hide();
    $('#div-alamat-member').hide();
    $('#div-keterangan').hide();
    $('#div-nama-bank').hide();
    $('#div-no-rekening').hide();
    $('#div-telp').hide();
    $('#div-status-member').hide();



    $('#kategori_member').change(function() {
      var kategori_member = $('#kategori_member').val();
      if (kategori_member == "perseorangan") {
        $('#div-data-lembaga').hide();
        $('#div-data-member').show();
        $('#div-nama-lembaga').hide();
        $('#div-alamat-lembaga').hide();
        $('#div-telp-lembaga').hide();
        $('#div-data-pic').hide();
        $('#div-no-ktp').show();
        $('#div-nama-member').show();
        $('#div-tempat-lahir').show();
        $('#div-tanggal-lahir').show();
        $('#div-jenis-kelamin').show();
        $('#div-alamat-member').show();
        $('#div-keterangan').show();
        $('#div-nama-bank').show();
        $('#div-no-rekening').show();
        $('#div-telp').show();
        $('#div-status-member').show();
      }
      else {
        $('#div-data-lembaga').show();
        $('#div-data-member').hide();
        $('#div-nama-lembaga').show();
        $('#div-alamat-lembaga').show();
        $('#div-telp-lembaga').show();
        $('#div-data-pic').show();
        $('#div-no-ktp').show();
        $('#div-nama-member').show();
        $('#div-tempat-lahir').show();
        $('#div-tanggal-lahir').show();
        $('#div-jenis-kelamin').show();
        $('#div-alamat-member').show();
        $('#div-keterangan').show();
        $('#div-nama-bank').show();
        $('#div-no-rekening').show();
        $('#div-telp').show();
        $('#div-status-member').show();
      }

    });
    /*$(".input_nama_member").hide();
    $(".input_keterangan").hide();
    $(".input_alamat").hide();
    $(".input_telp").hide();
    $(".input_no_ktp").hide();
    $(".input_status_member").hide();
    $(".input_telp_lembaga").hide();
    $(".input_nama_bank").hide();
    $(".input_no_rekening").hide();
    $(".input_nama_bank_2").hide();
    $(".input_no_rekening_2").hide();
    $(".input_nama_lembaga").hide();
    $(".input_nama_pic").hide();
    $(".input_alamat_lembaga").hide();
    $(".data_lembaga").hide();
    $(".data_member").hide();
    $(".data_pic").hide();*/


  //   $('.kategori_member').on('change', function() {
  //     if ( this.value == 'perseorangan')
  //     //.....................^.......
  //   {

  //     $(".data_member").show();
  //     $(".input_nama_member").show();
  //     $(".input_keterangan").show();
  //     $(".input_alamat").show();
  //     $(".input_telp").show();
  //     $(".input_no_ktp").show();
  //     $(".input_status_member").show();
  //     $(".input_nama_bank").show();
  //     $(".input_no_rekening").show();

  //   }
  //   else
  //   {
  //     $(".data_member").hide();
  //     $(".input_nama_member").hide();
  //     $(".input_keterangan").hide();
  //     $(".input_alamat").hide();
  //     $(".input_telp").hide();
  //     $(".input_no_ktp").hide();
  //     $(".input_status_member").hide();
  //     $(".input_nama_bank").hide();
  //     $(".input_no_rekening").hide();
  //   };
  // });

/*$('.kategori_member').on('click', function() {
  if ( this.value == 'lembaga')
      //.....................^.......
    {
      $(".data_lembaga").show();
      $(".input_nama_member").show();
      $(".input_keterangan").show();
      $(".input_alamat").show();
      $(".input_telp").show();
      $(".input_no_ktp").show();
      $(".input_status_member").show();
      $(".input_nama_lembaga").show();
      $(".input_nama_pic").show();
      $(".input_alamat_lembaga").show();
      $(".input_telp_lembaga").show();
      $(".data_pic").show();
      $(".input_nama_bank_2").show();
      $(".input_no_rekening_2").show();

      $(".data_member").hide();
      $(".input_nama_bank").hide();
      $(".input_no_rekening").hide();

    }

    else if ( this.value == 'perseorangan')
      //.....................^.......
    {

      $(".data_member").show();
      $(".input_nama_member").show();
      $(".input_keterangan").show();
      $(".input_alamat").show();
      $(".input_telp").show();
      $(".input_no_ktp").show();
      $(".input_status_member").show();
      $(".input_nama_bank").show();
      $(".input_no_rekening").show();

      $(".input_nama_bank_2").hide();
      $(".input_no_rekening_2").hide();
      $(".input_nama_lembaga").hide();
      $(".input_nama_pic").hide();
      $(".input_alamat_lembaga").hide();
      $(".input_telp_lembaga").hide();
      $(".data_pic").hide();
      $(".data_lembaga").hide();

    }
    else{
     $(".data_member").hide();
     $(".input_nama_member").hide();
     $(".input_keterangan").hide();
     $(".input_alamat").hide();
     $(".input_telp").hide();
     $(".input_no_ktp").hide();
     $(".input_status_member").hide();
     $(".input_nama_lembaga").hide();
     $(".input_nama_pic").hide();
     $(".input_alamat_lembaga").hide();
     $(".input_telp_lembaga").hide();
     $(".data_pic").hide();
     $(".input_nama_bank").hide();
     $(".input_no_rekening").hide();
     $(".input_nama_bank_2").hide();
     $(".input_no_rekening_2").hide();
   };
 });*/

});

$(function() {

 <?php 
 $param = $this->uri->segment(4);
        //echo $param;
 if(!empty($param)){
  $member = $this->db->get_where('master_member',array('id' =>$param));
  $hasil_member = $member->row();
  $baru=$hasil_member->kategori_member;
}    
?>
var member_kategori = "$baru";

if (member_kategori == 'lembaga')
      //.....................^.......
    {
      $(".data_lembaga").show();
      $(".input_nama_member").show();
      $(".input_keterangan").show();
      $(".input_alamat").show();
      $(".input_telp").show();
      $(".input_no_ktp").show();
      $(".input_status_member").show();
      $(".input_nama_lembaga").show();
      $(".input_nama_pic").show();
      $(".input_alamat_lembaga").show();
      $(".input_telp_lembaga").show();
      $(".data_pic").show();
      // $(".input_nama_bank_2").show();
      // $(".input_no_rekening_2")show();

      $(".data_member").hide();
      $(".input_nama_bank").hide();
      $(".input_no_rekening").hide();

    }

    else if ( member_kategori == 'perseorangan')
      //.....................^.......
    {

      $(".data_member").show();
      $(".input_nama_member").show();
      $(".input_keterangan").show();
      $(".input_alamat").show();
      $(".input_telp").show();
      $(".input_no_ktp").show();
      $(".input_status_member").show();
      $(".input_nama_bank").show();
      $(".input_no_rekening").show();

      $(".input_nama_bank_2").hide();
      $(".input_no_rekening_2").hide();
      $(".input_nama_lembaga").hide();
      $(".input_nama_pic").hide();
      $(".input_alamat_lembaga").hide();
      $(".input_telp_lembaga").hide();
      $(".data_pic").hide();
      $(".data_lembaga").hide();

    }
    else{
     $(".data_member").hide();
     $(".input_nama_member").hide();
     $(".input_keterangan").hide();
     $(".input_alamat").hide();
     $(".input_telp").hide();
     $(".input_no_ktp").hide();
     $(".input_status_member").hide();
     $(".input_nama_lembaga").hide();
     $(".input_nama_pic").hide();
     $(".input_alamat_lembaga").hide();
     $(".input_telp_lembaga").hide();
     $(".data_pic").hide();
     $(".input_nama_bank").hide();
     $(".input_no_rekening").hide();
     $(".input_nama_bank_2").hide();
     $(".input_no_rekening_2").hide();
   };
 });
</script>