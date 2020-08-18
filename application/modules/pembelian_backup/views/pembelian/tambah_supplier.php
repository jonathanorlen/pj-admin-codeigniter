<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
         Data Supplier
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
                $data = $this->db->get_where('master_supplier',array('id'=>$uri));
                $hasil_data = $data->row();
              }

              $this->db->select_max('id');
              $get_supplier = $this->db->get('master_supplier');
              $max_supllier = $get_supplier->row();

              $this->db->where('id', $max_supllier->id);
              $get_po = $this->db->get('master_supplier');
              $po = $get_po->row();
              $nomor = substr(@$po->kode_supplier, 4);
              $nomor = $nomor + 1;
              $string = strlen($nomor);
              if($string == 1){
                $kode_supplier ='000'.$nomor;
              } else if($string == 2){
                $kode_supplier ='00'.$nomor;
              } else if($string == 2){
                $kode_supplier ='0'.$nomor;
              } else if($string == 3){
                $kode_supplier =''.$nomor;
              }
              ?>
                            <!--<div class="form-group  col-xs-5">
                              <label>Id Supplier</label>
                              <input type="text" class="form-control" name="id_supplier" id="id_supplier" />
                            </div>-->
                            <div class="form-group  col-xs-6">
                              <label>Kode Supplier</label>
                              <input type="hidden" name="id" value="<?php echo @$hasil_data->id ?>" />
                              <input readonly <?php if(!empty($uri)){ echo "readonly='true'"; } ?> type="text" class="form-control" value="<?php if(!empty($uri)){echo @$hasil_data->kode_supplier;}else{ echo 'SP_'. $kode_supplier;} ?>"  name="kode_supplier" id="kode_supplier"  />
                            </div>

                            <div class="form-group  col-xs-6">
                              <label class="gedhi">Kategori Supplier</label>
                              <select class="form-control select2"  name="kategori_supplier" id="kategori_supplier" >
                                <option selected="" value="">--Pilih Kategori Supplier--</option>
                                <option <?php echo "1" == @$hasil_data->kategori_supplier ? 'selected' : '' ?> value="1" >UD</option>
                                <option <?php echo "2" == @$hasil_data->kategori_supplier ? 'selected' : '' ?> value="2" >CV</option>
                                <option <?php echo "3" == @$hasil_data->kategori_supplier ? 'selected' : '' ?> value="3" >Perseorangan</option>
                              </select> 
                            </div>
                          </div>
                          <div class="row">
                            <div class="form-group  col-xs-6">
                              <label class="gedhi">Nama Supplier</label>
                              <input type="text" class="form-control" value="<?php echo @$hasil_data->nama_supplier; ?>" name="nama_supplier" />
                            </div>

                            <div class="form-group  col-xs-6">
                              <label class="gedhi">Alamat Supplier</label>
                              <textarea class="form-control" name="alamat_supplier"><?php echo @$hasil_data->alamat_supplier; ?></textarea>
                              
                            </div>

                            <div class="form-group  col-xs-6">
                              <label class="gedhi">No.Telp</label>
                              <input type="text" class="form-control" value="<?php echo @$hasil_data->telp_supplier; ?>" name="telp_supplier" />
                            </div>

                            <div class="form-group  col-xs-6">
                              <label class="gedhi">Nama Bank</label>
                              <input type="text" class="form-control" value="<?php echo @$hasil_data->nama_bank; ?>" name="nama_bank" />
                            </div>

                            <div class="form-group  col-xs-3">
                              <label class="gedhi">No.Rekening</label>
                              <input type="text" class="form-control" value="<?php echo @$hasil_data->no_rek; ?>" name="no_rek" />
                            </div>

                            <div class="form-group  col-xs-3">
                              <label class="gedhi">Nama PIC</label>
                              <input type="text" class="form-control" value="<?php echo @$hasil_data->nama_pic; ?>" name="nama_pic" />
                            </div>

                            <div class="form-group  col-xs-3">
                              <label class="gedhi">Jabatan PIC</label>
                              <input type="text" class="form-control" value="<?php echo @$hasil_data->jabatan_pic; ?>" name="jabatan_pic" />
                            </div>

                            <div class="form-group  col-xs-3">
                              <label class="gedhi">No.HP PIC</label>
                              <input type=
                              "text" class="form-control" value="<?php echo @$hasil_data->telp_pic; ?>" name="telp_pic" />
                            </div>

                            <div class="form-group  col-xs-6">
                             <label class="gedhi">Termin</label>
                             <div class="input-group">

                               <input type="number" class="form-control" value="<?php echo @$hasil_data->termin; ?>" name="termin" />
                               <span class="input-group-addon">Hari</span>
                             </div>
                           </div>

                           <div class="form-group  col-xs-6">
                            <label class="gedhi">Status</label>
                            <select class="form-control select2" name="status_supplier">
                              <option selected="" value="">--Pilih Status--</option>
                              <option <?php echo "1" == @$hasil_data->status_supplier ? 'selected' : '' ?> value="1" >Aktif</option>
                              <option <?php echo "0" == @$hasil_data->status_supplier ? 'selected' : '' ?> value="0" >Tidak Aktif</option>
                            </select> 
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
              window.location = "<?php echo base_url().'master/supplier/'; ?>";
            });
          </script>


          <script type="text/javascript">
            $(document).ready(function(){
              $(".select2").select2();
            });

            $(function () {

              $('#kode_supplier').on('change',function(){
                var kode_supplier = $('#kode_supplier').val();
                var url = "<?php echo base_url() . 'master/supplier/get_kode' ?>";
                $.ajax({
                  type: 'POST',
                  url: url,
                  data: {kode_supplier:kode_supplier},
                  success: function(msg){
                    if(msg == 1){
                      $(".sukses").html('<div class="alert alert-warning">Kode_Telah_dipakai</div>');
                      setTimeout(function(){
                        $('.sukses').html('');
                      },1700);              
                      $('#kode_supplier').val('');
                    }
                    else{

                    }
                  }
                });
              });

  //jika tombol Send diklik maka kirimkan data_form ke url berikut
  $("#data_form").submit( function() { 

    $.ajax( {  
      type :"post", 
      <?php 
      if (empty($uri)) {
        ?>
    //jika tidak terdapat segmen maka simpan di url berikut
    url : "<?php echo base_url() . 'master/supplier/simpan_tambah_supplier'; ?>",
    <?php }
    else { ?>
    //jika terdapat segmen maka simpan di url berikut
    url : "<?php echo base_url() . 'master/supplier/simpan_edit_supplier'; ?>",
    <?php }
    ?>  
    cache :false,  
    data :$(this).serialize(),
    beforeSend:function(){
      $(".tunggu").show();  
    },
    success : function(data) {  
      if(data==1){
       $(".sukses").html('<div class="alert alert-success">Data Berhasil Disimpan</div>');
       setTimeout(function(){$('.sukses').html('');window.location = "<?php echo base_url() . 'pembelian/tambah/' ?>";},1000);  
     }
     else{
      $(".sukses").html(data);
      
    }
    $(".tunggu").hide();                 
  },  
  error : function() {  
    alert("Data gagal dimasukkan.");  
  }  
});
    return false;                          
  });   

});

</script>