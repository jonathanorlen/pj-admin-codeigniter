      
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
           
            $this->db->where('tanggal_pembelian >=', $tgl_awal);
            $this->db->where('tanggal_pembelian <=', $tgl_akhir);
            $this->db->where('position =', 'gudang');
            
            }
            $this->db->select('*');
            $this->db->from('transaksi_pembelian');
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
         <table class="table table-striped table-hover table-bordered" id="daftar_pembelian"  style="font-size:1.5em;">
         <thead>
          <tr>
            <th>No</th>
            <th>Tanggal Pembelian</th>
            <th>Kode Pembelian</th>
            <th>Nota Ref</th>
            <th>Supplier</th>
            <th>Total</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $nomor = 1;

          foreach($hasil_transaksi as $daftar){ ?> 
          <tr>
            <td><?php echo $nomor; ?></td>
            <td><?php echo TanggalIndo(@$daftar->tanggal_pembelian);?></td>
            <td><?php echo @$daftar->kode_pembelian; ?></td>
            <td><?php echo @$daftar->nomor_nota; ?></td>
            <td><?php echo @$daftar->nama_supplier; ?></td>
            <td><?php echo format_rupiah(@$daftar->grand_total); ?></td>
            <td><?php echo get_detail($daftar->kode_pembelian); ?></td>
          </tr>
          <?php $nomor++; } ?>

        </tbody>
        <tfoot>
          <tr>
            <th>No</th>
            <th>Tanggal Pembelian</th>
            <th>Kode Pembelian</th>
            <th>Nota Ref</th>
            <th>Supplier</th>
            <th>Total</th>
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