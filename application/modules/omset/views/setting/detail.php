<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Detail Pengeluaran

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
                                <?php
                                    $uri = $this->uri->segment(3);
                                    if(!empty($uri)){
                                        $data = $this->db->get_where('keuangan_keluar',array('id'=>$uri));
                                        $hasil_data = $data->row();
                                    }
                                ?>
                                <!--<div class="form-group  col-xs-5">
                                  <label>ID Member</label>
                                  <input type="text" class="form-control" name="id_member" readonly="" />
                                </div>-->
                              <div class="row">
                                <input type="hidden" name="id" value="<?php echo @$hasil_data->id ?>" />

                                <div class="form-group  col-xs-5">
                                  <label class="gedhi"><b>Kategori</label>
                                  <?php
                                    $kategori = $this->db->get('keuangan_kategori_akun');
                                    $hasil_kategori = $kategori->result();
                                  ?>
                                  <select class="form-control select2" name="kode_kategori_keuangan" id="kode_kategori_akun" required="" disabled="">
                                    <option selected="true" value="">--Pilih Kategori--</option>
                                    <?php foreach($hasil_kategori as $daftar){ ?>
                                    <option <?php if(@$hasil_data->kode_kategori_keuangan==@$daftar->kode_kategori_akun){ echo "selected"; } ?> value="<?php echo @$daftar->kode_kategori_akun; ?>" ><?php echo @$daftar->nama_kategori_akun; ?></option>
                                    <?php } ?>
                                  </select> 

                                  <input type="hidden" id="nama_kategori_akun" name="nama_kategori_keuangan" value="<?php echo @$hasil_data->nama_kategori_akun ?>" />
                                </div>

                                <div class="form-group  col-xs-5">
                                  <label class="gedhi"><b>Sub Kategori</label>
                                  <?php
                                    $kategori = $this->db->get('keuangan_sub_kategori_akun');
                                    $hasil_kategori = $kategori->result();
                                  ?>
                                  <select class="form-control select2" name="kode_sub_kategori_keuangan" id="kode_sub_kategori_akun" required="" disabled="">
                                    <option selected="true" value="">--Pilih Sub Kategori--</option>
                                    <?php foreach($hasil_kategori as $daftar){ ?>
                                    <option <?php if(@$hasil_data->kode_sub_kategori_keuangan==@$daftar->kode_sub_kategori_akun){ echo "selected"; } ?> value="<?php echo @$daftar->kode_sub_kategori_akun; ?>" ><?php echo @$daftar->nama_sub_kategori_akun; ?></option>
                                    <?php } ?>
                                  </select> 

                                  <input type="hidden" id="nama_sub_kategori_akun" name="nama_sub_kategori_keuangan" value="<?php echo @$hasil_data->nama_sub_kategori_keuangan ?>" />

                                  <input type="hidden" id="kode_jenis_akun" name="kode_jenis_keuangan" value="<?php echo @$hasil_data->kode_jenis_akun ?>" />

                                  <input type="hidden" id="nama_jenis_akun" name="nama_jenis_keuangan" value="<?php echo @$hasil_data->nama_jenis_akun ?>" />

                                </div>
                                
                                <div class="col-md-5">
                                        <label><b>Nominal</label>
                                        <input type="text"  class="form-control" value="<?php echo format_rupiah(@$hasil_data->nominal) ?>" name="nominal" id="nominal" readonly required="">
                                </div>

                                <div class="col-md-5">
                                      <h3><div id="rupiah"></div></h3>
                                </div>

                              </div>
                              <br><br>
                              <div class="row">
                                <div class="col-md-9">
                                        <label><b>Keterangan</label>
                                        <input class="form-control" value="<?php echo @$hasil_data->keterangan ;?>" name="keterangan" id="keterangan" required="" readonly></input>
                                </div>
                              </div>
                              <br>
                            </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!------------------------------------------------------------------------------------------------------>





