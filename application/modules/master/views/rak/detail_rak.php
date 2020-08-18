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
                <input type="hidden" name="id" value="<?php echo @$hasil_rak->id ?>" />
                <input readonly="true" type="text" class="form-control" value="<?php echo @$hasil_rak->kode_rak; ?>" name="kode_rak" />
              </div>

              <div class="form-group col-xs-5">
                <label class="gedhi"><b>Nama Block</label>
                <input readonly="true" type="text" value="<?php echo @$hasil_rak->nama_rak; ?>" class="form-control" name="nama_rak" />
              </div>
              <div class="form-group  col-xs-5">
                <label class="gedhi">Unit</label>
                <?php
                $unit = $this->db->get('master_unit');
                $hasil_unit = $unit->result();
                ?>
                <select disabled="" class="form-control select2" name="kode_unit" id="kode_unit" required>
                  <option selected="true" value="">--Pilih Unit--</option>
                  <?php foreach($hasil_unit as $item){ ?>
                  <option <?php if($item->kode_unit==$hasil_rak->kode_unit){ echo "selected"; } ?> value="<?php echo $item->kode_unit ?>" <?php if (@$hasil_rak->kode_unit == $item->kode_unit){echo'selected="true"';} ?> ><?php echo $item->nama_unit ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group  col-xs-5">
                <label class="gedhi">Status</label>
                
                <select disabled="" class="form-control select2" name="status" id="status">
                  <option selected="true" value="">--Pilih Status--</option>
                  <option value="1" <?php if(@$hasil_rak->status ==1){echo'selected="true"';} ?> >Aktif</option>
                  <option value="0" <?php if(@$hasil_rak->status ==0){echo'selected="true"';} ?> >Tidak Aktif</option>
                </select>
              </div>
              <div class="form-group col-xs-5">
                <label class="gedhi"><b>Keterangan</label>
                <input readonly="true" type="text" value="<?php echo @$hasil_rak->keterangan; ?>" class="form-control" name="keterangan" />
              </div>
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
