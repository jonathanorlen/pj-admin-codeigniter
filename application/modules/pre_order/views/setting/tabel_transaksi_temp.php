
                                <?php
                                  if(@$kode){
                                  $pembelian = $this->db->get_where('opsi_transaksi_po_temp',array('kode_po'=>$kode));
                                  $list_pembelian = $pembelian->result();
                                  $nomor = 1;  $total = 0;

                                  foreach($list_pembelian as $daftar){ 
                                    echo $daftar->kode_bahan;
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
                                
                                