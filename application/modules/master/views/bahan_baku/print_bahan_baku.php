
<body style="font-size:6px;" onload="window.print()"; onfocus="window.close()">
  <table align="left" >
    <?php
    $setting = $this->db->get('master_setting');
    $hasil_setting = $setting->row();
    ?>
    <tr>
      <td><?php echo $hasil_setting->nama_resto;  ?></td>
    </tr>
    <tr>
      <td><?php echo $hasil_setting->alamat_resto;  ?></td>
    </tr>

  </table><br><br><br><br><br><br>
  <br><br><hr>

  <table >
    <th>Produk</th>
  </table>

  <br><br>
  <table class="table" border="1" style="border-collapse: collapse;" width="100%">
    <thead>
      <tr>
        <th width="20px">No</th>
        <th width="250px">Nama Produk</th>
        <th width="150px">Qty Grosir</th>
        <th width="350px">Harga 1</th>
        <th width="350px">Harga 2</th>
      </tr>
    </thead>
    <tbody id="">
      <?php
      
      $bahan_baku = $this->db->get_where('master_bahan_baku');
      $list_bahan_baku = $bahan_baku->result();

      $nomor = 1;  $total = 0;

      foreach($list_bahan_baku as $daftar){ 
        ?> 
        <tr>
          <td><?php echo $nomor; ?></td>
          <td><?php echo @$daftar->nama_bahan_baku; ?></td>
          <td align="center"><?php echo @$daftar->qty_grosir; ?></td>
          <td align="right"><?php echo @format_rupiah($daftar->harga_jual_1); ?></td>
          <td align="right"><?php echo @format_rupiah($daftar->harga_jual_2); ?></td>
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
