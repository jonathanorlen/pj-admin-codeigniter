
                                <?php
                                  if(@$kode){
                                  $status= $this->db->get_where('transaksi_ro',array('kode_ro'=>$kode));
                                  $hasil_status=$status->row();
                                  //echo $hasil_status->status;
                                  
                                     $pembelian = $this->db->get_where('opsi_transaksi_validasi_ro_temp',array('kode_ro'=>$kode));
                                     
                                  $nomor = 1;  $total = 0;
                                  $list_pembelian = $pembelian->result();
                                  foreach($list_pembelian as $daftar){ 
                                ?> 
                                    <tr>
                                      <td><?php echo $nomor; ?></td>
                                      <td><?php echo @$daftar->nama_bahan; ?></td>
                                      <td><?php echo @$daftar->jumlah." ".@$daftar->nama_satuan; ?></td>
                                      <td><?php echo @$daftar->keterangan; ?></td>
                                      <td><?php echo cek_status_ro(@$daftar->status_validasi); ?></td>
                                      <td><?php if(count($list_pembelian)>1) { echo get_del_id_temp(@$daftar->id); }  ?></td>
                                    </tr>
                                <?php 
                                    $nomor++; 
                                  } 
                                  
                                  
                                }
                                ?>
                                
                                