
<body style="font-size:6px;" onload="window.print()"; onfocus="window.close()">
<table align="right" >
    <tr>
        <td>Cafe - Resto </td>
    </tr>
     <tr>
        <td>Jl. Oro - Oro Dowo, Ijen - Malang </td>
    </tr>
  
</table><br><br><br><br><br><br>
<br><br><hr>

<table >
    <tr>
        <?php $kode=$this->uri->segment(3);
        $tanggal = $this->db->get_where('transaksi_po',array('kode_po'=>$kode));
        $hasil_tanggal = $tanggal->row();

         ?>
        <td width="20px">Kode</td>
        <td width="45px">&nbsp:&nbsp</td>
        <td width="170px" align="left"><?php echo $kode;  ?></td>
    </tr>
    <tr>
        <td width="20px">Tanggal</td>
        <td width="45px">&nbsp:&nbsp</td>

        <td width="170px" align="left"><?php echo $hasil_tanggal->tanggal_input;  ?></td>
    </tr>
</table>

<br><br>
<table class="table" border="1" style="border-collapse: collapse;" width="100%">
                                <thead>
                                    <tr>
                                      <th width="20px">No</th>
                                      <th width="250px">Nama bahan</th>
                                      <th width="150px">QTY</th>
                                      <th width="350px">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody id="">
                                      <?php
                                        $kode=$this->uri->segment(3);
                                        $pembelian = $this->db->get_where('opsi_transaksi_po',array('kode_po'=>$kode));
                                        $list_pembelian = $pembelian->result();
                                       
                                        $nomor = 1;  $total = 0;

                                        foreach($list_pembelian as $daftar){ 
                                      ?> 
                                          <tr>
                                            <td><?php echo $nomor; ?></td>
                                            <td><?php echo $daftar->nama_bahan; ?></td>
                                            <td><?php echo $daftar->jumlah; ?></td>
                                            <td><?php echo $daftar->keterangan; ?></td>
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
