
                                <?php
                                  if(@$kode){
                                  $pembelian = $this->db->get_where('opsi_transaksi_pembelian_temp',array('kode_pembelian'=>$kode));
                                  $list_pembelian = $pembelian->result();
                                  $nomor = 1;  $total = 0;

                                  foreach($list_pembelian as $daftar){ 
                                    @$satuan_bahan = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>@$daftar->kode_bahan));
                                    @$hasil_satuan_bahan = $satuan_bahan->row();
                                    @$satuan_barang = $this->db->get_where('master_barang',array('kode_barang'=>@$daftar->kode_bahan));
                                    @$hasil_satuan_barang = $satuan_barang->row();
                                ?> 
                                    <tr>
                                      <td><?php echo $nomor; ?></td>
                                      <td><?php echo @$daftar->nama_bahan; ?></td>
                                      <td><?php echo @$daftar->jumlah; ?> <?php echo @$hasil_satuan_bahan->satuan_pembelian; echo @$hasil_satuan_barang->satuan_pembelian;?></td>
                                      <td><?php echo format_rupiah(@$daftar->harga_satuan); ?></td>
                                      <td><?php echo format_rupiah(@$daftar->subtotal); ?></td>
                                      <td><?php echo get_edit_del_id(@$daftar->id); ?></td>
                                    </tr>
                                <?php 
                                    @$total = $total + @$daftar->subtotal;
                                    $nomor++; 
                                  } 
                                }
                                ?>
                                
                                <tr>
                                  <td colspan="3"></td>
                                  <td style="font-weight:bold;">Total</td>
                                  <td><?php echo format_rupiah(@$total); ?></td>
                                  <td></td>
                                </tr>

                                <tr>
                                  <td colspan="3"></td>
                                  <td style="font-weight:bold;">Diskon (%)</td>
                                  <td id="tb_diskon"><?php echo @$diskon; ?></td></td>
                                  <td></td>
                                </tr>
                                
                                <tr>
                                  <td colspan="3"></td>
                                  <td style="font-weight:bold;">Diskon (Rp)</td>
                                  <td id="tb_diskon_rupiah"></td>
                                  <td></td>
                                </tr>
                                
                                <tr>
                                  <td colspan="3"></td>
                                  <td style="font-weight:bold;">Grand Total</td>
                                  <td id="tb_grand_total"><?php echo format_rupiah(@$total); ?></td>
                                  <td><input id="grand_total" value="<?php echo @$total; ?>" name="grand_total" type="hidden"/></td>
                                </tr>