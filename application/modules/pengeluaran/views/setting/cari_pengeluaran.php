      
<?php
  $param = $this->input->post();
    if(@$param['tgl_awal'] && @$param['tgl_akhir']){
      $tgl_awal = $param['tgl_awal'];
      $tgl_akhir = $param['tgl_akhir'];
      
      $this->db->where('tanggal_transaksi >=', $tgl_awal);
      $this->db->where('tanggal_transaksi <=', $tgl_akhir);
      
    }


    $this->db->select('*');
    $this->db->from('keuangan_keluar');
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
                <th width="50px;">No</th>
                <th>Kategori</th>
                <th>Sub Kategori</th>
                <th>Nominal</th>
                <th>Tanggal</th>
                <th>Petugas</th>

                <th width="133px;">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              foreach($hasil_transaksi as $item){
                $total +=$item->nominal;
                if($this->session->flashdata('message')==$item->id){

                  echo '<tr id="warna" style="background: #88cc99; display: none;">';
                }
                else{
                  echo '<tr>';
                }
                ?>
                <td><?php echo $no; ?></td>
                <td><?php echo $item->nama_kategori_keuangan; ?></td>
                <td><?php echo $item->nama_sub_kategori_keuangan; ?></td>                  
                <td><?php echo format_rupiah($item->nominal); ?></td>                  
                <td><?php echo tanggalIndo($item->tanggal_transaksi); ?></td>
                <td><?php echo $item->petugas; ?></td>
                <td><?php echo get_detail($item->id); ?></td>
              </tr>
              <?php 
              $no++;
            } $hasil_total=$total;
              //echo $hasil_total;?>
        </tbody>                
      </table>
      <div class="row">
       <div class="col-md-10" align="right">
              <label style="font-size: 20px"><b>Total :</label>
        </div>
        <div class="col-md-2 pull-right">
              <span><button style="width: 147px" type="button" class="btn btn-warning pull-right" id="cari"><i class=""></i><?php  echo format_rupiah($hasil_total); ?></button></span>
        </div>
        </div>
        </div>
        </div>

 <script type="text/javascript">
   $("#tabel_daftar").dataTable({
      "paging":   false,
      "ordering": false,
      "info":     false
    });
 </script>