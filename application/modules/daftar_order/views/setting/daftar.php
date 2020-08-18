
<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Daftar PO
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
                  <div class="row">
        <!-- Left col -->
            <section class="col-md-12">
              <?php
                      $this->db->select('*');
                      $total = $this->db->get_where('transaksi_po',array('position' => 'U001'));
                      $hasil_total = $total->num_rows();
                      
                  ?>
                  <div class="row">
              <div class="col-md-2 pull-right">
              <div class="" style="background-color: #428bca ;width:auto;">
                            <a style="padding:13px; margin-bottom:10px;color:white;margin-left:0px;" class="btn"> Total PO : <span style="font-size:20px;"><?php echo $hasil_total; ?></span></a>
                             
              </div>
              </div>
            </div>
              <br>
                <div class="box box-info">
                    <div class="box-header">
                        <!-- tools box -->
                        <div class="pull-right box-tools"></div><!-- /. tools -->
                    </div>
                    <?php 
                                $user = $this->session->userdata('astrosession');
                               //print_r($user);
                                $modul = $user->uname;
                                
                              ?>
                             
                              
                    <div class="box-body">            
                        <div class="sukses" ></div>
                        <table id="tabel_daftar" class="table table-bordered table-striped">
                            <?php
                              $po = $this->db->query("SELECT * from transaksi_po where position='U001'");
                              $hasil_po = $po->result();
                            ?>
                            <thead>
                              <tr>
                                <th>No</th>
                                <th>Kode Pembelian</th>
                                <th>Tanggal Pembelian</th>
                                <th>Petugas</th>
                                <th>Unit</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $nomor = 1;

                                    foreach($hasil_po as $daftar){ ?> 
                                    <tr style="font-size: 15px;">
                                      <td><?php echo $nomor; ?></td>
                                      <td><?php echo @$daftar->kode_po; ?></td>
                                      <td><?php echo TanggalIndo(@$daftar->tanggal_input);?></td>
                                      <td><?php echo @$daftar->petugas; ?></td>
                                      <?php
                                        $kode_unit=$daftar->position;
                                        $query=$this->db->query("SELECT nama_unit from master_unit where kode_unit='$kode_unit' ");
                                        $nama_unit=$query->row();
                                       ?>
                                      <td><?php echo @$nama_unit->nama_unit; ?></td>
                                      <td><?php echo get_detail_print($daftar->kode_po); ?></td>
                                    </tr>
                                <?php $nomor++; } ?>
                               
                            </tbody>
                             
                        </table>

            </section><!-- /.Left col -->      
        </div><!-- /.row (main row) -->
        </div>
         
          <!------------------------------------------------------------------------------------------------------>

        </div>
      </div>
    </div><!-- /.col -->
  </div>
</div>    
</div>  

