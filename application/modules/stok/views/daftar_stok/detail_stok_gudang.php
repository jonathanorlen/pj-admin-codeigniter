<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Detail Stok Gudang

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
        $param = $this->uri->segment(3);
                     //echo $param;
        if(!empty($param)){
          $bahan_baku = $this->db->get_where('master_bahan_baku',array('id'=>$param));
          $hasil_bahan_baku = $bahan_baku->row();
        }    

        ?>
        <div class="box-body">                   
          <div class="sukses" ></div>
          <form id="data_form" method="post">
            <div class="box-body">            
              <div class="row">
                <div class="form-group  col-xs-5">
                  <label><b>Kode Bahan Baku</label>
                  <input type="hidden" name="id" value="<?php echo @$hasil_bahan_baku->id; ?>" />
                  <input readonly="true" value="<?php echo @$hasil_bahan_baku->kode_bahan_baku ?>" type="text" class="form-control" name="kode_bahan_baku" />
                </div>
                <div class="form-group  col-xs-5">
                  <label class="gedhi"><b>Nama Bahan Baku</label>
                  <input readonly="true" value="<?php echo @$hasil_bahan_baku->nama_bahan_baku; ?>" type="text" class="form-control" name="nama_bahan_baku" />
                </div>
                <div class="form-group  col-xs-5">
                  <label class="gedhi"><b>Unit</label>
                  <?php
                  $unit = $this->db->get('master_unit');
                  $hasil_unit = $unit->result();
                  ?>
                  <select disabled="true" class="form-control select2" style="width: 100%;" name="kode_unit">
                    <option selected="true" value="">--Pilih Unit--</option>
                    <?php foreach($hasil_unit as $item){ ?>
                    <option <?php if(@$hasil_bahan_baku->kode_unit==$item->kode_unit){ echo "selected"; } ?> value="<?php echo $item->kode_unit ?>"><?php echo $item->nama_unit ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group  col-xs-5">
                  <label class="gedhi"><b>Rak</label>
                  <?php
                  $rak = $this->db->get('master_rak');
                  $hasil_rak = $rak->result();
                  ?>
                  <select disabled="true" class="form-control select2" style="width: 100%;" name="kode_rak">
                    <option selected="true" value="">--Pilih Rak--</option>
                    <?php foreach($hasil_rak as $item){ ?>
                    <option <?php if(@$hasil_bahan_baku->kode_rak==$item->kode_rak){ echo "selected"; } ?> value="<?php echo $item->kode_rak ?>"><?php echo $item->nama_rak ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group  col-xs-5">
                  <label class="gedhi"><b>Satuan Pembelian</label>
                  <?php
                  $pembelian = $this->db->get('master_satuan');
                  $hasil_pembelian = $pembelian->result();
                  ?>
                  <select disabled="true" class="form-control select2 pembelian" name="id_satuan_pembelian">
                    <option selected="true" value="">--Pilih satuan pembelian--</option>
                    <?php foreach($hasil_pembelian as $daftar){ ?>
                    <option <?php if(@$hasil_bahan_baku->id_satuan_pembelian==$daftar->kode){ echo "selected"; } ?> value="<?php echo $daftar->kode; ?>" ><?php echo $daftar->nama; ?></option>
                    <?php } ?>
                  </select> 
                </div>
                <div class="form-group  col-xs-5">
                  <?php
                  if(!empty($param)){
                    $satuan_stok = $this->db->get_where('master_satuan',array('kode'=>@$hasil_bahan_baku->id_satuan_stok));
                    $hasil_satuan_stok = $satuan_stok->row();
                    $dft_satuan = $this->db->get_where('master_satuan',array('kategori'=>$hasil_satuan_stok->kategori,'kode !='=>$hasil_bahan_baku->id_satuan_pembelian));
                    $hasil_dft_satuan = $dft_satuan->result();
                  }
                  ?>
                  <label class="gedhi"><b>Satuan Stok</label>
                  <select disabled="true" class="form-control stok select2" name="id_satuan_stok">
                    <option selected="true" value="">--Pilih satuan stok--</option>
                    <?php if(!empty($param)){ 
                      foreach($hasil_dft_satuan as $daftar){    
                        ?>
                        <option <?php if(@$hasil_bahan_baku->id_satuan_stok==$daftar->kode){ echo "selected"; } ?> value="<?php echo $daftar->kode; ?>"><?php echo $daftar->nama; ?></option>
                        <?php } } ?>
                      </select> 
                    </div>
                    <div class="form-group  col-xs-5">
                      <label class="gedhi"><b>Isi Dalam 1 (Satuan Pembelian)</label>
                      <input readonly="true" value="<?php echo @$hasil_bahan_baku->jumlah_dalam_satuan_pembelian; ?>" type="text" class="form-control" name="jumlah_dalam_satuan_pembelian" />
                    </div>
                    <div class="form-group  col-xs-5">
                      <label class="gedhi"><b>Stok Minimal</label>
                      <input readonly="true" type="text" class="form-control" name="stok_minimal" value="<?php echo @$hasil_bahan_baku->stok_minimal ?>" />
                    </div>

                  </div>
                  <div class="box-footer">

                  </div>
                </div>
              </form>

              <table class="table table-striped table-hover table-bordered" id="tabel_daftar"  style="font-size:1.5em;">

                <thead>
                  <tr>
                    <th>Tanggal Transaksi</th>
                    <th>Jenis Transaksi</th>
                    <th>Kode Transaksi</th>
                    <th>Stok Keluar</th>
                    <th>Stok Masuk</th>
                  </tr>
                </thead>
                <tbody>

                  <?php
                  $kode_default = $this->db->get('setting_gudang');
                  $hasil_unit =$kode_default->row();
                 // $param=$hasil_unit->kode_unit;
                  $kode_unit = $hasil_unit->kode_unit; //$this->uri->segment(3);
                  //echo 'kode_unit '.$kode_unit;
                  //$kode_rak = $this->uri->segment(4);
                          $kode_bahan = $hasil_bahan_baku->kode_bahan_baku;//$this->uri->segment(5);
                          $get_transaksi_stok = $this->db->query("SELECT  *
                            FROM transaksi_stok
                            WHERE kode_bahan = '$kode_bahan' AND (kode_unit_asal = '$kode_unit' OR kode_unit_tujuan = '$kode_unit' )"
                            );
                          $hasil_transaksi_stok = $get_transaksi_stok->result_array();
                          foreach ($hasil_transaksi_stok as $item) {
                           if((!empty($item['stok_masuk']) and $item['kode_unit_tujuan']==$kode_unit) or (!empty($item['stok_keluar']) and $item['kode_unit_asal']==$kode_unit)){


                            ?>   
                            <tr>
                              <td><?php echo tanggalIndo(@$item['tanggal_transaksi']);?></td>
                              <td><?php echo @$item['jenis_transaksi'];?></td>
                              <td><?php echo @$item['kode_transaksi'];?></td>
                              <td align="center">
                                <?php 
                                if (empty($item['stok_keluar'])) {
                                  echo '-';
                                } else {
                                  echo @$item['stok_keluar']." ".$hasil_satuan_stok->nama;
                                }
                                ?>
                              </td>
                              <td align="center">
                                <?php 
                                if (empty($item['stok_masuk'])) {
                                  echo '-';
                                } else {
                                  echo @$item['stok_masuk']." ".$hasil_satuan_stok->nama;
                                }
                                ?>
                              </td>
                            </tr>

                            <?php 
                            }
                          } 
                          ?>

                        </tbody>
                        <tfoot>
                          <tr>
                            <th>Tanggal Transaksi</th>
                            <th>Jenis Transaksi</th>
                            <th>Kode Transaksi</th>
                            <th>Stok Keluar</th>
                            <th>Stok Masuk</th>
                          </tr>
                        </tfoot>
                      </table>
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
            window.location = "<?php echo base_url().'stok/gudang'; ?>";
          });
        </script>
            <!------------------------------------------------------------------------------------------------------>

            <script>
            $(document).ready(function(){
              $("#tabel_daftar").dataTable({
                "paging":   false,
                "ordering": false,
                "info":     false
              });
            });
            </script>