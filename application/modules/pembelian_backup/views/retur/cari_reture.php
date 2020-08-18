      
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
              //$kode_unit = $param['kode_unit'];
           
            $this->db->where('tanggal_retur_keluar >=', $tgl_awal);
            $this->db->where('tanggal_retur_keluar <=', $tgl_akhir);
            

            
            }
            $this->db->select('*');
            $this->db->from('transaksi_retur');
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
         
         <table id="tabel_daftar" class="table table-bordered table-striped" style="font-size:1.5em;">
         
          <thead>
            <tr>
              <th>No</th>
              <th>Tanggal Retur</th>
              <th>Kode Retur</th>
              <th>Nota Ref</th>
              <th>Supplier</th>
              <th>Total</th>
              <th>Status</th>
              <th>Action</th> 
            </tr>
          </thead>
          <tbody>
            <?php
            $nomor = 1;

            foreach($hasil_transaksi as $daftar){ 
              ?> 
              <tr>
                <td><?php echo $nomor; ?></td>
                <td><?php echo @$daftar->tanggal_retur_keluar; ?></td>
                <td><?php echo @$daftar->kode_retur; ?></td>
                <td><?php echo @$daftar->nomor_nota; ?></td>
                <td><?php echo @$daftar->nama_supplier; ?></td>
                <td><?php echo @$daftar->grand_total; ?></td>
                <td><?php echo cek_status_retur($daftar->status_retur); ?></td>
                <td><?php echo get_detail($daftar->kode_retur); ?></td>
              </tr>
              <?php $nomor++; } ?>

            </tbody>
            <tfoot>
              <tr>
                <th>No</th>
                <th>Tanggal Retur</th>
                <th>Kode Retur</th>
                <th>Nota Ref</th>
                <th>Supplier</th>
                <th>Total</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </tfoot>
          </table>
      </div>


 <script type="text/javascript">
   $("#tabel_daftar").dataTable({
      "paging":   false,
      "ordering": true,
      "searching": false,
      "info":     false
    });
 </script>