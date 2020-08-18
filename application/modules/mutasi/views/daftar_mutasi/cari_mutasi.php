      
<?php
             

             $param = $this->input->post();
              // $kode = $this->input->post('kode_transaksi');

            // if(@$param['tgl_awal'] && @$param['tgl_akhir'] && @$param['nama']){
            //   $nama = $param['nama'];
            //   $tgl_awal = $param['tgl_awal'];
            //   $tgl_akhir = $param['tgl_akhir'];
            // $this->db->where('nama', $nama);
            // $this->db->where('tanggal_order >=', $tgl_awal);
            // $this->db->where('tanggal_order <=', $tgl_akhir);
            // }

           if(@$param['tgl_awal'] && @$param['tgl_akhir']){
              
              $tgl_awal = $param['tgl_awal'];
              $tgl_akhir = $param['tgl_akhir'];
              $kode_unit = $param['kode_unit'];
              
           
            $this->db->where('tanggal_transaksi >=', $tgl_awal);
            $this->db->where('tanggal_transaksi <=', $tgl_akhir);
            $this->db->where('kode_unit_asal =', $kode_unit);
            
            }
            $this->db->select('*');
            $this->db->from('transaksi_mutasi');
            $transaksi = $this->db->get();
            $hasil_transaksi = $transaksi->result();

              $total=0;

?>
     <br>
     <div class="row">
      
         
          <div class="col-md-4">
          
          </div>
         
      </div>         
          <div class="">
          <br>
         <table class="table table-striped table-hover table-bordered" id="tabel_daftar"  style="font-size:1.5em;">
            
            <thead>
              <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Tanggal Mutasi</th>
                <th>Petugas</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $nomor = 1;
              foreach($hasil_transaksi as $daftar){ 
               $query = $this->db->query(" SELECT * FROM transaksi_stok where kode_transaksi= '$daftar->kode_mutasi' and kode_unit_asal='$kode_unit' ");
               $cek=$query->num_rows();
               $petugas=$query->row();
               if($cek>0){
                            //echo "$kode_unit";

                ?> 
                <tr>
                  <td><?php echo $nomor; ?></td>
                  <td><?php echo @$daftar->kode_mutasi; ?></td>
                  <td><?php echo @$daftar->tanggal_update; ?></td>
                  <td><?php echo @$petugas->nama_petugas; ?></td>
                  <td><?php echo get_detail_mutasi_gudang($daftar->kode_mutasi); ?></td>
                </tr>
                <?php $nomor++; }} ?>

              </tbody>
              <tfoot>
                <tr>
                  <th>No</th>
                  <th>Kode</th>
                  <th>Tanggal Mutasi</th>
                  <th>Petugas</th>
                  <th>Action</th>
                </tr>
              </tfoot>
            </table>
      </div>


 <script type="text/javascript">
   $("#tabel_daftar").dataTable({
      "paging":   false,
      "ordering": false,
      "info":     false
    });
 </script>