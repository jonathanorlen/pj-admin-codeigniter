
<body style="font-size:6px;" onload="window.print()"; onfocus="window.close()">
 <?php
 $setting = $this->db->get('master_setting');
 $hasil_setting = $setting->row();
 ?>
 <table align="center" >
  <tr>
    <td><img src="<?php echo base_url() . 'component/img/logo_pj.png '?> " width="75px" rel="stylesheet" type="text/css"/></td>
      <td></td>
      <td></td>
      <td></td>
      <td align="center" width="450px">
        <b style="font-size:20px">TOKO BANGUNAN <?php echo strtoupper($hasil_setting->nama_resto); ?></b><br>
        <?php echo $hasil_setting->alamat_resto;  ?> Telp.<?php echo $hasil_setting->telp_resto;  ?> 
      </td>
    </tr>
    

  </table><br><br><br>
  <table align="center" >
  <tr>
    <td>
      <td align="center" width="450px">
       <b style="font-size:12px">Dokumen 7</b ><br>
        <b style="font-size:20px">DOKUMEN PURCHASE ORDER</b ><br>
        <b style="font-size:15px">No Dok: &nbsp; &nbsp; &nbsp;</a>/OPS-PO/PJ/XI/2016</b ><br>
        
      </td>
    </tr>
    

  </table>
  <br><br><br><br><br><br>
  <table >
     <?php $kode=$this->uri->segment(3);
      $tanggal = $this->db->get_where('transaksi_po',array('kode_transaksi'=>$kode));
      $hasil_tanggal = $tanggal->row();

      ?>
    <tr>
      <td width="180px">Hari Tanggal</td>
      <td width="45px">&nbsp:&nbsp</td>
      <td  align="left"><?php echo TanggalIndo($hasil_tanggal->tanggal_input); ?></td>
    </tr>
    <tr>

      <td width="180px">Kode PO</td>
      <td width="45px">&nbsp:&nbsp</td>
      <td  align="left"><?php echo $hasil_tanggal->kode_transaksi; ?></td>
    </tr>
    <tr>
      <td width="180px">Suplier/Marketing Sales</td>
      <td width="45px">&nbsp:&nbsp</td>
      <td  align="left"><?php echo $hasil_tanggal->nama_supplier;  ?></td>
    </tr>
    <tr>
      <td width="180px">Perusahaan</td>
      <td width="45px">&nbsp:&nbsp</td>
      <td  align="left"><?php #echo $hasil_tanggal->nama_supplier;  ?></td>
    </tr>
    <tr>
      <td width="180px">Kontak</td>
      <td width="45px">&nbsp:&nbsp</td>
      <td align="left"><?php #echo $hasil_tanggal->nama_supplier;  ?></td>
    </tr>
    <tr>
      <td width="180px">Status Order</td>
      <td width="45px">&nbsp:&nbsp</td>
      <td  align="left">Biasa/ Segera /Mendesak*</td>
    </tr>
    <tr>
      <td width="180px">Jadwal Kedatangan</td>
      <td width="45px">&nbsp:&nbsp</td>
      <td  align="left"></td>
    </tr>
  </table>

  <br><br>
  <table class="table" border="1" style="border-collapse: collapse;" width="100%">
    <thead>
      <tr>
        <th width="20px">No</th>
        <th width="600px">NAMA BARANG</th>
        <th width="150px">SPESIFIKASI/MERK </th>
        <th width="50px">JUMLAH</th>
        <th width="200px">VALIDASI PENERIMAAN</th>
      </tr>
    </thead>
    <tbody id="">
      <?php
      $kode=$hasil_tanggal->kode_po;
      $pembelian = $this->db->get_where('opsi_transaksi_po',array('kode_po'=>$kode));
      $list_pembelian = $pembelian->result();

      $nomor = 1;  $total = 0;

      foreach($list_pembelian as $daftar){ 
        ?> 
        <tr>
          <td><?php echo $nomor; ?></td>
          <td><?php echo $daftar->nama_bahan; ?></td>
          <td></td>
          <td align="center"><?php echo $daftar->jumlah; ?></td>
          <td></td>
        </tr>
        <?php 
        $nomor++; 
      } 
      ?>
    </tbody>
    <tfoot>

    </tfoot>

  </table>
 <table >
     <?php $kode=$this->uri->segment(3);
      $tanggal = $this->db->get_where('transaksi_po',array('kode_po'=>$kode));
      $hasil_tanggal = $tanggal->row();

      ?>
    <tr>
      <td width="500px">*Coret Tidak Perlu</td>
      <td width="45px"></td>
      
    </tr>
    <tr>

      <td width="500px">Nomor PO harap dicantumkan dalam Faktur dan Surat Pengiriman</td>
      <td width="45px"></td>
      
    </tr>
    <tr>

      <td width="500px">CATATAN :</td>
      <td width="45px"></td>
      
    </tr>
    
  </table>
 
  <table align="center" cellspacing="100">
     <?php 
     $get_ses = $this->session->userdata('astrosession');

      ?>
    <tr>
      <td align="center">&nbsp; &nbsp;&nbsp;ADMIN STAF <br><br><br><br><?php if ($get_ses->nama!='' or !empty($get_ses->nama)){echo "( ".$get_ses->nama." )";}else{ echo "(...............................)";} ?></td>
      <td align="center">CAO  PATRIOT JAYA <br><br><br><br>(...............................)</td>
      
    </tr>
    
    
  </table>
</body>
</html>
