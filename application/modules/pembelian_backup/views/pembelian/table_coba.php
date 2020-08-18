 <?php
                  $kode = 'PEN_161116_005_64_1';
                  if(@$kode){
                    $pembelian = $this->db->get_where('opsi_transaksi_penjualan',array('kode_penjualan'=>$kode));
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
                        <td><?php echo @$daftar->nama_menu; ?></td>
                        <td><?php echo @$daftar->jumlah; ?> <?php echo @$hasil_satuan_bahan->satuan_pembelian; echo @$hasil_satuan_barang->satuan_pembelian;?></td>
                        <td><?php echo format_rupiah(@$daftar->harga_satuan); ?></td>
                        <td><?php echo format_rupiah(@$daftar->subtotal); ?></td>
                        <td><?php echo format_rupiah(@$daftar->diskon_item); ?></td>
                        <td><?php echo @$daftar->status; ?></td>
                        <td><?php echo validasi_penjualan(@$daftar->id); ?></td>

                      </tr>

                      <tr id="tr<?php echo $daftar->id; ?>"  style="display:none" class="detail">
                        <td colspan="10">
                          <span class="closedet pull-right"><strong><h3>X</h3></strong></span><div id="detail<?php echo $daftar->id; ?>" ></div>
                        </td>
                      </tr>

                      <?php 
                      @$total = $total + @$daftar->subtotal;
                      $nomor++; 
                    } 
                  }
                  ?>

                  <tr>
                    <td colspan="6"></td>
                    <td style="font-weight:bold;">Total</td>
                    <td><?php echo format_rupiah(@$total); ?></td>

                  </tr>

                  <tr>
                    <td colspan="6"></td>
                    <td style="font-weight:bold;">Diskon (%)</td>
                    <td id="tb_diskon"><?php echo @$diskon; ?></td></td>

                  </tr>

                  <tr>
                    <td colspan="6"></td>
                    <td style="font-weight:bold;">Diskon (Rp)</td>
                    <td id="tb_diskon_rupiah"></td>

                  </tr>

                  <tr>
                    <td colspan="6"></td>
                    <td style="font-weight:bold;">Grand Total</td>
                    <td id="tb_grand_total"><?php echo format_rupiah(@$total); ?>
                     <input id="grand_total" value="<?php echo @$total; ?>" name="grand_total" type="hidden"/>
                   </td>

                 </tr>