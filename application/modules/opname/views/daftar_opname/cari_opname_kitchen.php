      
<?php
  $param = $this->input->post();
    if(@$param['tgl_awal'] && @$param['tgl_akhir']){
      $tgl_awal = $param['tgl_awal'];
      $tgl_akhir = $param['tgl_akhir'];
      $kode_unit = $param['kode_unit'];
      $this->db->where('tanggal_opname >=', $tgl_awal);
      $this->db->where('tanggal_opname <=', $tgl_akhir);
      $this->db->where('kode_unit =', $kode_unit);
    }


    $this->db->select('*');
    $this->db->from('transaksi_opname');
    $transaksi = $this->db->get();
    $hasil_transaksi = $transaksi->result();
    $total=0;
?>
    
      <div class="row">
          <div class="col-md-4"></div>
          <div class="col-md-12">
         
          <table class="table table-striped table-hover table-bordered" id="tabel_daftar"  style="font-size:1.5em;">
            <thead>
              <tr>
                <th>No</th>
                <th>Kode Opname</th>
                <th>Tanggal Opname</th>
                <th>Petugas</th>
                <th>Status Validasi</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $nomor = 1;  
              foreach($hasil_transaksi as $daftar){ 
                ?> 
                <tr>
                  <td><?php echo @$nomor; ?></td>
                  <td><?php echo @$daftar->kode_opname; ?></td>
                  <td><?php echo @$daftar->tanggal_opname; ?></td>
                  <td><?php echo @$daftar->petugas; ?></td>
                  <td><?php echo @$daftar->validasi; ?></td>
                  <td align="center">
                    <?php 
                    if (@$daftar->validasi == 'confirmed') {
                      echo '-';
                    } else {
                      echo get_validasi_opname_gudang($kode_unit,@$daftar->kode_opname);
                    }
                    ?>
                  </td>
                </tr>
                <?php 
                $nomor++; 
              } 
              ?>

            </tbody>
            <tfoot>
              <tr>
                <th>No</th>
                <th>Kode Opname</th>
                <th>Tanggal Opname</th>
                <th>Petugas</th>
                <th>Status Validasi</th>
                <th>Action</th>
              </tr>
            </tfoot>                
          </table>
        </div>
        </div>

 <script type="text/javascript">
   $("#tabel_daftar").dataTable({
      "paging":   false,
      "ordering": false,
      "info":     false
    });
 </script>