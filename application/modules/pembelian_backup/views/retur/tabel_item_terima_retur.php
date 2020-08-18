                                <?php
                                    if($kode){
                                      $pembelian = $this->db->get_where('opsi_transaksi_retur',array('kode_retur'=>$kode));
                                      $list_pembelian = $pembelian->result();
                                      $nomor = 1;  $total = 0;
                                      foreach($list_pembelian as $daftar){ 
                                ?>
                                <tr>
                                    <td><?php echo $nomor; ?></td>
                                    <td><?php echo $daftar->nama_bahan; ?></td>
                                    <td><?php echo $daftar->jumlah; ?></td>
                                    <td><?php echo $daftar->harga_satuan; ?></td>
                                    <td><?php echo $daftar->subtotal; ?></td>
                                    <td><?php echo get_edit_del_id($daftar->id); ?></td>
                                </tr>
                                <?php 
                                        @$total = $total + $daftar->subtotal;
                                        @$nominal = $daftar->subtotal;
                                        $nomor++; 
                                      } 
                                  }
                                  else{
                                ?>
                                <tr>
                                    <td><?php echo @$nomor; ?></td>
                                    <td><?php echo @$daftar->nama_bahan; ?></td>
                                    <td><?php echo @$daftar->jumlah; ?></td>
                                    <td><?php echo @$daftar->harga_satuan; ?></td>
                                    <td><?php echo @$daftar->subtotal; ?></td>
                                    <td><?php echo get_edit_del_id($daftar->id); ?></td>
                                </tr>
                                <?php
                                  }
                                ?>
                                
                                <tr>
                                    <td colspan="3"></td>
                                    <td style="font-weight:bold;">Nominal Retur</td>
                                    <td><?php echo @$total; ?></td>
                                    <td></td>
                                </tr>

                                <tr>
                                    <?php 
                                        $nominal_retur = $this->db->get_where('transaksi_retur',array('kode_retur'=>$kode));
                                        $list_nominal_retur = $nominal_retur->row();
                                        $sisa = @$list_nominal_retur->grand_total - @$total;
                                    ?>
                                    <td colspan="3"></td>
                                    <td style="font-weight:bold;">Total Retur</td>
                                    <td><?php echo @$list_nominal_retur->grand_total; ?></td>
                                    <td></td>
                                </tr>

                                <tr>
                                    <td colspan="3"></td>
                                    <td style="font-weight:bold;">Sisa</td>
                                    <td><?php echo $sisa; ?></td>
                                    <td><input type="hidden" value="<?php echo $sisa; ?>" name="sisa_nominal" id="sisa_nominal"></td>
                                </tr>

                                <tr>
                                    <td colspan="3"></td>
                                    <td style="font-weight:bold;">Potongan</td>
                                    <td><input type="text" value="0" name="potongan" id="potongan"></input></td>
                                    <td></td>
                                </tr>

                                