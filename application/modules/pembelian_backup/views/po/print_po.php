<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<?php

?>

<link href="<?php echo base_url() . 'component/admin/bootstrap/css/bootstrap.min.css '?>" rel="stylesheet" type="text/css" />
<body style="font-size:6px;" onload=print(); onfocus="window.close()">

 <table border="0" align="center">
    <tr>
        <td colspan="5" align="center" rowspan="1"><br></td>
    </tr>
    <tr>
        <td colspan="3" rowspan="4" align="center" ><img src="<?php echo base_url() . 'component/upload/foto/uploads/'.@$setting->logo_resto; ?>" height="80" width="180"></td>
    </tr>
    <tr>
        <td colspan="2" align="center" ><b>DATA PO</b></td>
    </tr>
    <tr>
        <td colspan="2" align="center" ><b><?php echo @$setting->nama_resto; ?></b></td>
    </tr>
    <tr>
        <td colspan="2" align="center" ><b><?php echo @$setting->alamat_resto ;?> / <?php echo @$setting->telp_resto; ?></b></td>
    </tr>
    <tr>
        <td colspan="5" align="center" ><br></td>
    </tr>
    <tr>
        <td ></td>
        <td ></td>
        <td width="250px" align="left"></td>
        <td ></td>
        <td ></td>
    </tr>
    <tr>
        <td ></td>
        <td ></td>
        <td width="250px" align="left"></td>
        <td ></td>
        <td ></td>
    </tr>
    
 </table>
<br><br>

<table >
    <tr>
        <td width="20px">Kode</td>
        <td width="45px">&nbsp:&nbsp</td>
        <td width="170px" align="left"><?php echo @$po->kode_po;  ?></td>
    </tr>
    <tr>
        <td width="20px">Tanggal</td>
        <td width="45px">&nbsp:&nbsp</td>
        <td width="170px" align="left"><?php echo tanggalIndo(@$po->tanggal_input); ?></td>
    </tr>
</table>

<br><br>
<table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                      <th width="20px">No</th>
                                      <th width="250px">Nama bahan</th>
                                      <th width="150px">QTY</th>
                                      <th width="350px">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody id="tabel_temp_data_transaksi">
                                      <?php
                                        $pembelian = $this->db->get_where('opsi_transaksi_po',array('kode_po'=>$kode));
                                        $list_pembelian = $pembelian->result();
                                        $nomor = 1;  $total = 0;

                                        foreach($list_pembelian as $daftar){ 
                                      ?> 
                                          <tr>
                                            <td><?php echo $nomor; ?></td>
                                            <td><?php echo @$daftar->nama_bahan; ?></td>
                                            <td><?php echo @$daftar->jumlah; ?></td>
                                            <td><?php echo @$daftar->keterangan; ?></td>
                                          </tr>
                                      <?php 
                                          $nomor++; 
                                        } 
                                      ?>
                                </tbody>
                                <tfoot>
                                    
                                </tfoot>
  
</table>

</body>
</html>
