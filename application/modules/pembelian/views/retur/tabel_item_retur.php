                                <?php
                                if($kode){
                                  $pembelian = $this->db->get_where('opsi_transaksi_retur_temp',array('kode_retur'=>$kode));
                                  $list_pembelian = $pembelian->result();
                                  $nomor = 1;  $total = 0;
                                  foreach($list_pembelian as $daftar){ 
                                    $cek_opsi_transaksi = $this->db->get_where('opsi_transaksi_pembelian',array('kode_pembelian'=>$daftar->kode_pembelian,'kode_bahan'=>$daftar->kode_bahan));
                                    $hasil_cek_opsi_transaksi = $cek_opsi_transaksi->row();
                                    
                                    @$satuan_bahan = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>@$daftar->kode_bahan));
                                    @$hasil_satuan_bahan = $satuan_bahan->row();
                                    @$satuan_barang = $this->db->get_where('master_barang',array('kode_barang'=>@$daftar->kode_bahan));
                                    @$hasil_satuan_barang = $satuan_barang->row();
                                    ?>
                                    <tr>
                                      <td><?php echo $nomor; ?></td>
                                      <td><?php echo $daftar->nama_bahan; ?></td>
                                      <td><?php echo @$hasil_cek_opsi_transaksi->jumlah - $daftar->jumlah ; ?> <?php echo @$hasil_satuan_bahan->satuan_pembelian; echo @$hasil_satuan_barang->satuan_pembelian;?></td>
                                      <td><?php echo $daftar->jumlah + @$hasil_cek_opsi_transaksi->jumlah_retur; ?> <?php echo @$hasil_satuan_bahan->satuan_pembelian; echo @$hasil_satuan_barang->satuan_pembelian;?></td>
                                      <td><?php echo format_rupiah($daftar->harga_satuan); ?></td>
                                      <td><?php echo format_rupiah($hasil_cek_opsi_transaksi->subtotal - $daftar->subtotal); ?></td>
                                      <td><?php echo format_rupiah($daftar->subtotal + @$hasil_cek_opsi_transaksi->subtotal_retur); ?></td>
                                      <td><?php echo get_edit_del_id($daftar->id); ?></td>
                                    </tr>
                                    <?php 
                                    @$total = $total + $daftar->subtotal + @$hasil_cek_opsi_transaksi->subtotal_retur;
                                    $nomor++; 
                                  } 
                                }
                                else{
                                  ?>
                                  <tr>
                                    <td><?php echo @$nomor; ?></td>
                                    <td><?php echo @$daftar->nama_bahan; ?></td>
                                    <td><?php echo @$daftar->jumlah; ?> <?php echo @$hasil_satuan_bahan->satuan_pembelian; echo @$hasil_satuan_barang->satuan_pembelian;?></td>
                                    <td><?php echo format_rupiah(@$daftar->harga_satuan); ?></td>
                                    <td><?php echo format_rupiah(@$daftar->subtotal); ?></td>
                                    <td><?php echo get_edit_del_id($daftar->id); ?></td>
                                  </tr>
                                  <?php
                                }
                                ?>
                                
                                <tr>
                                  <td colspan="5"></td>
                                  <td style="font-weight:bold;">Total</td>
                                  <td><?php echo format_rupiah(@$total); ?></td>
                                  <td></td>
                                </tr>

                                <tr>
                                  <td colspan="5"></td>
                                  <td style="font-weight:bold;">Grand Total</td>
                                  <td><?php echo format_rupiah(@$total); ?></td>
                                  <td></td>
                                </tr>

                                