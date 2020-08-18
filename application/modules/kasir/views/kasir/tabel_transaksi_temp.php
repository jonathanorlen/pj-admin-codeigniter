
                                <?php
                                  $pembelian = $this->db->get('opsi_transaksi_pembelian_temp');
                                  $list_pembelian = $pembelian->result();
                                  $nomor = 1;  $total = 0;

                                  foreach($list_pembelian as $daftar){ 
                                ?> 
                                    <tr>
                                      <td><?php echo $nomor; ?></td>
                                      <td><?php echo $daftar->keterangan; ?></td>
                                      
                                      <td><?php echo $daftar->jumlah; ?></td>
                                      <td><?php echo $daftar->harga_satuan; ?></td>
                                      <td><?php echo $daftar->subtotal; ?></td>
                                      <td><?php echo get_edit_del_bayar($daftar->id); ?></td>
                                    </tr>
                                <?php 
                                    $total = $total + $daftar->subtotal;
                                    $nomor++; 
                                  } 
                                ?>
                                
                                <tr>
                                  <td colspan="4"></td>
                                  <td style="font-weight:bold;">Total</td>
                                  <td><?php echo $total; ?></td>
                                  <td></td>
                                </tr>

                                <tr>
                                  <td colspan="4"></td>
                                  <td style="font-weight:bold;">Diskon (%)</td>
                                  <td id="tb_diskon"><?php echo @$diskon; ?></td></td>
                                  <td></td>
                                </tr>
                                
                                <tr>
                                  <td colspan="4"></td>
                                  <td style="font-weight:bold;">Diskon (Rp)</td>
                                  <td id="tb_diskon_rupiah"></td>
                                  <td></td>
                                </tr>
                                
                                <tr>
                                  <td colspan="4"></td>
                                  <td style="font-weight:bold;">Grand Total</td>
                                  <td id="tb_grand_total"><?php echo $total; ?></td>
                                  <td><input id="grand_total" value="<?php echo $total; ?>" name="grand_total" type="hidden"/></td>
                                </tr>