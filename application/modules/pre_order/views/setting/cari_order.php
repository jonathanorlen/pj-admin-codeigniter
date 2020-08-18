      
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
  
  $this->db->where('tanggal_input >=', $tgl_awal);
  $this->db->where('tanggal_input <=', $tgl_akhir);
            //$this->db->where('position =', $kode_unit);
  $this->db->where('position =', 'U001');
  $this->db->where('status =', 'menunggu');
  
}
$this->db->select('*');
$this->db->from('transaksi_po');
$transaksi = $this->db->get();
$hasil_transaksi = $transaksi->result();

$total=0;

?>
<br>
<div class="row">
       <!--  <div class="col-md-2 pull-right">
              <div class="" style="background-color: #428bca ;width:auto;">
                            <a style="padding:13px; margin-bottom:10px;color:white;margin-left:0px;" class="btn"> Total Transaksi RO : <span style="font-size:20px;"><?php echo count( $hasil_transaksi); ?></span></a>
                             
              </div>
            </div> -->
            
            <div class="col-md-4">
              
            </div>
            
          </div>
          <br>
          <div class="col-md-2 pull-right">
            <div class="" style="background-color: #428bca ;width:auto;">
              <br>
              <a style="padding:13px; margin-bottom:10px;color:white;margin-left:0px;" class="btn"> Total Transaksi PO : <span style="font-size:20px;"><?php echo count($hasil_transaksi); ?></span></a>
              
            </div>
          </div>
          <div class="col-md-12">
            <br>
            <table id="tabel_daftar" class="table table-bordered table-striped">
             
              <thead>
                <tr>
                  <th>No</th>
                  <th>Kode PO</th>
                  <th>Kode Transaksi</th>
                  <th>Tanggal Pembelian</th>
                  <th>Petugas</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $nomor = 1;

                foreach($hasil_transaksi as $daftar){ ?> 
                <tr style="font-size: 15px;">
                  <td><?php echo $nomor; ?></td>
                  <td><?php echo @$daftar->kode_po; ?></td>
                  <td><?php echo @$daftar->kode_transaksi; ?></td>
                  <td><?php echo TanggalIndo(@$daftar->tanggal_input);?></td>
                  <td><?php echo @$daftar->petugas; ?></td>
                  <td align="center"><?php echo get_detail_print($daftar->kode_po); ?></td>
                </tr>
                <?php $nomor++; } ?>
                
              </tbody>
              
            </table>
          </div>
<!-- <div class="row">
    <div class="">
       <div class="col-md-6">
       </div>
          <div class="col-md-6 text-right"  style="margin-right:0px;margin-right:0px;">
          <div style="background-color: #428bca;width:auto;">
            <a style="padding:0px; margin-bottom:5px;text-align:right;color:white;margin-right:15px;" class="btn">Total Biaya Transaksi&nbsp <span style="font-size:25px;"><?php echo format_rupiah($total); ?></span></a>
          </div>
          </div>   
    </div>
 </div> -->