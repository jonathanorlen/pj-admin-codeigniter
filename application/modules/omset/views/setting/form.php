<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Tambah Pengeluaran

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
        <input id="cek" value="0" name="cek" type="" style="display: none">
        <div class="box-body">                   
          <div class="sukses" ></div>
          <form id="data_form"  method="post">
                                <?php
                                    $uri = $this->uri->segment(4);
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
                                    $kategori = $this->db->get_where('keuangan_kategori_akun',array('kode_jenis_akun' => 2));
                                    $hasil_kategori = $kategori->result();
                                  ?>
                                  <select class="form-control select2" name="kode_kategori_keuangan" id="kode_kategori_akun" required="">
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
                                  <select class="form-control select2" name="kode_sub_kategori_keuangan" id="kode_sub_kategori_akun" required="">
                                    <option selected="true" value="">--Pilih Sub Kategori--</option>
                                    <?php foreach($hasil_kategori as $daftar){ ?>
                                    <option <?php if(@$hasil_data->kode_sub_kategori_keuangan==@$daftar->nama_sub_kategori_akun){ echo "selected"; } ?> value="<?php echo @$daftar->kode_sub_kategori_akun; ?>" ><?php echo @$daftar->nama_sub_kategori_akun; ?></option>
                                    <?php } ?>
                                  </select> 

                                  <input type="hidden" id="nama_sub_kategori_akun" name="nama_sub_kategori_keuangan" value="<?php echo @$hasil_data->nama_sub_kategori_keuangan ?>" />

                                  <input type="hidden" id="kode_jenis_akun" name="kode_jenis_keuangan" value="<?php echo @$hasil_data->kode_jenis_akun ?>" />

                                  <input type="hidden" id="nama_jenis_akun" name="nama_jenis_keuangan" value="<?php echo @$hasil_data->nama_jenis_akun ?>" />

                                </div>
                                
                                <div class="col-md-5">
                                        <label><b>Nominal</label>
                                        <input type="text" class="form-control" value="" name="nominal" id="nominal" required="">
                                </div>

                                <div class="col-md-5">
                                      <h3><div id="rupiah"></div></h3>
                                </div>

                              </div>
                              <br><br>
                              <div class="row">
                                <div class="col-md-9">
                                        <label><b>Keterangan</label>
                                        <textarea class="form-control" value="" name="keterangan" id="keterangan" required=""></textarea>
                                </div>
                              </div>
                              <br>

                              <div class="box-footer">
                                  <button type="submit" class="btn btn-primary">Submit</button>
                              </div>
                            </form>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="modal-confirm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color:grey">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title" style="color:#fff;">Konfirmasi Hapus Data</h4>
      </div>
      <div class="modal-body">
        <span style="font-weight:bold; font-size:14pt">Apakah anda yakin akan menghapus pembelian bahan tersebut ?</span>
        <input id="id-delete" type="hidden">
      </div>
      <div class="modal-footer" style="background-color:#eee">
        <button class="btn green" data-dismiss="modal" aria-hidden="true">Tidak</button>
        <button onclick="delData()" class="btn red">Ya</button>
      </div>
    </div>
  </div>
</div>
<!------------------------------------------------------------------------------------------------------>



<script type="text/javascript">

   

    $(function () {

      $("#kode_kategori_akun").change(function(){
          var kode_kategori_akun = $('#kode_kategori_akun').val();
          var url = "<?php echo base_url() . 'pengeluaran/get_kategori_akun'; ?>";
              $.ajax({
                  type: 'POST',
                  url: url,
                  data: {
                      kode_kategori_akun:kode_kategori_akun
                  },
                  success: function(msg){
                      var data = msg.split("|");
                      var nama_kategori = data[0];
                      var kode_sub_kategori_akun = data[1];

                      $('#nama_kategori_akun').val(nama_kategori);
                      $('#kode_sub_kategori_akun').html(kode_sub_kategori_akun);
                  }
              });
              return false;
      });

      $("#kode_sub_kategori_akun").change(function(){
          var kode_sub_kategori_akun = $('#kode_sub_kategori_akun').val();
          var kode_kategori_akun = $('#kode_kategori_akun').val();

          if(kode_kategori_akun==''){
              alert('Kategori harus dipilih');
              $('#kode_sub_kategori_akun').val('');
          }
          else{
              var url = "<?php echo base_url() . 'pengeluaran/get_sub_kategori_akun'; ?>";
              $.ajax({
                  type: 'POST',
                  url: url,
                  data: {
                      kode_sub_kategori_akun:kode_sub_kategori_akun
                  },
                  success: function(msg){
                      var data = msg.split("|");
                      var nama_sub = data[0];
                      var kode_jenis = data[1];
                      var nama_jenis = data[2];

                      $('#nama_sub_kategori_akun').val(nama_sub);
                      $('#kode_jenis_akun').val(kode_jenis);
                      $('#nama_jenis_akun').val(nama_jenis);
                  }
              });
              return false;
          }
      });

      $("#nominal").keyup(function(){
          var nominal = $('#nominal').val();
          var url = "<?php echo base_url() . 'pengeluaran/get_rupiah'; ?>";
              $.ajax({
                  type: 'POST',
                  url: url,
                  data: {
                      nominal:nominal
                  },
                  success: function(msg){
                      $('#rupiah').html(msg);
                  }
              });
              return false;
      });

      //jika tombol Send diklik maka kirimkan data_form ke url berikut

      $('#data_form').submit(function(){

        var url = "<?php echo base_url(). 'pengeluaran/simpan_pengeluaran'; ?>";
        $.ajax( {  
            type : "post", 
            url : url,
            data : $(this).serialize(),
            beforeSend:function(){
          $(".tunggu").show();  
        },
 success : function(data) {  
              $(".sukses").html(data);   
              setTimeout(function(){$('.sukses').html('');
                  window.location = "<?php echo base_url() . 'pengeluaran/' ?>";
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

