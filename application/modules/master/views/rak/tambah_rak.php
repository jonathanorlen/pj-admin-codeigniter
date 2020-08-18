<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
         Data Block

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
      $kode_default = $this->db->get('setting_gudang');
      $hasil_unit =$kode_default->row();
      $kode_unit=$hasil_unit->kode_unit;
      $param = $this->uri->segment(4);
      if(!empty($param)){
        $rak = $this->db->get_where('master_rak',array('kode_rak'=>$param));
        $hasil_rak = $rak->row();
      }
      ?>
      <div class="box-body">                   
        <div class="sukses" ></div>
        <form id="data_form" action="<?php echo base_url('admin/master/simpan_rak'); ?>" method="post">
          <div class="box-body">            
            <div class="row">
              <div class="form-group  col-xs-5">
                <label><b>Kode Block</label>
                <input type="hidden" name="id" value="<?php echo @$hasil_rak->id; ?>" />
                <input <?php if(!empty($param)){ echo "readonly='true'"; } ?> type="text" class="form-control" value="<?php echo @$hasil_rak->kode_rak; ?>" name="kode_rak" id="kode_rak"/>
              </div>

              <div class="form-group col-xs-5">
                <label class="gedhi"><b>Nama Block</label>
                <input type="text" value="<?php echo @$hasil_rak->nama_rak; ?>" class="form-control" name="nama_rak" />
              </div>

              <div class="form-group  col-xs-5">
                <label class="gedhi">Unit</label>
                <?php
                //echo "$kode_unit";
                $unit =$this->db->get_where('master_unit',array('kode_unit'=>$kode_unit));
                $hasil_unit = $unit->row();
                ?>
                <!-- <select class="form-control select2" name="kode_unit" id="kode_unit" required>
                  <option selected="true"  value="">--Pilih Unit--</option>
                  <?php foreach($hasil_unit as $item){ ?>
                  <option value="<?php //echo $item->kode_unit ?>" <?php if (@$hasil_rak->kode_unit == $item->kode_unit){echo'selected="true"';} ?> ><?php echo $item->nama_unit ?></option>
                  <?php } ?>
                </select> -->
                <input type="hidden" id="kode_unit" name="kode_unit" value="<?php echo @$hasil_unit->kode_unit; ?>" />
                <input type="text" readonly value="<?php echo @$hasil_unit->nama_unit; ?>" class="form-control"  />
              </div>
              <?php if(!empty($param)){ ?>
              <div class="form-group  col-xs-5">
                <label class="gedhi">Status</label>

                <select class="form-control select2" name="status" id="status">
                  <option selected="true" value="">--Pilih Status--</option>
                  <option value="1" <?php if(@$hasil_rak->status ==1){echo'selected="true"';} ?> >Aktif</option>
                  <option value="0" <?php if(@$hasil_rak->status ==0){echo'selected="true"';} ?> >Tidak Aktif</option>
                </select>
              </div>
              <?php } ?>
              <div class="form-group col-xs-5">
                <label class="gedhi"><b>Keterangan</label>
                <input type="text" value="<?php echo @$hasil_rak->keterangan; ?>" class="form-control" name="keterangan" />
              </div>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary">Simpan</button>
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
            window.location = "<?php echo base_url().'master/rak/'; ?>";
          });
        </script>



<script>
$(function(){

  $('#kode_rak').on('change',function(){
    var kode_rak = $('#kode_rak').val();
    var url = "<?php echo base_url() . 'master/rak/get_kode' ?>";
    $.ajax({
      type: 'POST',
      url: url,
      data: {kode_rak:kode_rak},
      success: function(msg){
        if(msg == 1){
          $(".sukses").html('<div class="alert alert-warning">Kode_Telah_dipakai</div>');
          setTimeout(function(){
            $('.sukses').html('');
          },1700);              
          $('#kode_rak').val('');

        }
        else{

        }
      }
    });
  });

  $("#data_form").submit( function() {
       /* var vv = $(this).serialize();
       alert(vv);*/
       <?php if(!empty($param)){ ?>
        var url = "<?php echo base_url(). 'master/rak/simpan_edit_rak'; ?>";  
        <?php }else{ ?>
          var url = "<?php echo base_url(). 'master/rak/simpan_rak'; ?>";
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

             $(".sukses").html('<div class="alert alert-success">Data Berhasil Disimpan</div>');
             setTimeout(function(){$('.sukses').html('');window.location = "<?php echo base_url() . 'master/rak/' ?>";},1000);  


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