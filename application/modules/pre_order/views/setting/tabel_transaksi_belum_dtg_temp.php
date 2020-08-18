<?php

if(@$kode){
  $po=$this->db->get_where('transaksi_po',array('kode_transaksi' => $kode));
  $hasil_po=$po->row();

  //$opsi_po=$this->db->get_where('opsi_transaksi_po',array('kode_po' => $hasil_po->kode_po,'status' =>'Belum Datang'));
  // $opsi_po=$this->db->get_where('opsi_transaksi_po',array('kode_po' => $hasil_po->kode_po,'status_sesuai' =>null));
  $opsi_po=$this->db->query("SELECT * FROM opsi_transaksi_po
WHERE kode_po='$hasil_po->kode_po' AND (status_sesuai IS NULL OR status_sesuai='')  
");
  $hasil_opsi_po=$opsi_po->result();
 
  foreach ($hasil_opsi_po as $belum_datang) {
    $data_opsi['kode_po'] = $kode;
    $data_opsi['kategori_bahan'] = $belum_datang->kategori_bahan;
    $data_opsi['kode_bahan'] = $belum_datang->kode_bahan;
    $data_opsi['nama_bahan'] = $belum_datang->nama_bahan;
    $nama_bahan = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku' => $belum_datang->kode_bahan));
    $hasil_bahan = $nama_bahan->row();


    $data_opsi['nama_bahan'] = $belum_datang->nama_bahan;
    $data_opsi['jumlah'] = $belum_datang->jumlah;
    $data_opsi['keterangan'] = $belum_datang->keterangan;
    $data_opsi['position'] = $belum_datang->position;

    $cek_temp=$this->db->get_where('opsi_transaksi_po_temp',array('kode_po' => $kode,'kode_bahan' =>$belum_datang->kode_bahan));
    $hasil_cek_temp=$cek_temp->row();
    $jml_temp=count($hasil_cek_temp);
    if($jml_temp > 0){
       // $this->db->update("opsi_transaksi_po_temp", $data_opsi,array('kode_po' => $kode,'kode_bahan' =>$belum_datang->kode_bahan));  
    }else{
      $tabel_opsi_transaksi_pembelian = $this->db->insert("opsi_transaksi_po_temp", $data_opsi);  
    }
    
    //echo $this->db->last_query();
  }

  $pembelian = $this->db->get_where('opsi_transaksi_po_temp',array('kode_po'=>$kode));
  $list_pembelian = $pembelian->result();
  $nomor = 1;  $total = 0;

  foreach($list_pembelian as $daftar){ 
    //echo $daftar->kode_bahan;
    ?> 
    <tr style="font-size: 15px;">
      <td><?php echo $nomor; ?></td>
      <td><?php echo @$daftar->nama_bahan; ?></td>
      <?php
      $kategori=$daftar->kategori_bahan;
      $kode_bahan=$daftar->kode_bahan;
      if($kategori=='stok'){
        $query=$this->db->query("SELECT satuan_pembelian from master_bahan_baku where kode_bahan_baku='$kode_bahan'");
        $hasil_satuan=$query->row();
      }else{
       $query=$this->db->query("SELECT satuan_pembelian from master_barang where kode_barang='$kode_bahan'");
       $hasil_satuan=$query->row();
     }

     ?>
     <td><?php echo @$daftar->jumlah. " " . @$hasil_satuan->satuan_pembelian; ?></td>
     <td><?php echo @$daftar->keterangan; ?></td>
     <td align="center"><?php echo get_edit_del_id(@$daftar->id); ?></td>
   </tr>

   <?php 

   $nomor++; 
 } 
}
?>
