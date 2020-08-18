<table class="table table-striped table-hover table-bordered" id="tabel_daftar"  style="font-size:1.5em;">
            <thead>
              <tr>
                <th width="50px;">No</th>
                <th>Tanggal Pengiriman</th>
                <th>No. Kendaraan</th>
                <th>Jumlah</th>
                <th width="220px">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $tgl_awal=$this->input->post('tgl_awal');
              $tgl_akhir=$this->input->post('tgl_akhir');
              
              if(!empty($tgl_awal) and !empty($tgl_akhir)){
                $get_pengiriman =  $this->db->query("SELECT * FROM (`opsi_transaksi_pengiriman`) WHERE tanggal_kirim >='$tgl_awal' and tanggal_kirim <='$tgl_akhir' GROUP BY `tanggal_kirim`, `no_kendaraan`");
              }else{
                $get_pengiriman =  $this->db->query("SELECT * FROM (`opsi_transaksi_pengiriman`)  GROUP BY `tanggal_kirim`, `no_kendaraan`");
              }
              
              //$get_pengiriman = $this->db->get('opsi_transaksi_pengiriman');
              $hasil_pengiriman = $get_pengiriman->result();
              //echo $this->db->last_query();
              $no = 1;
              foreach($hasil_pengiriman as $item){
                ?>
                <td><?php echo $no;?></td>
                <td><?php echo tanggalIndo($item->tanggal_kirim); ?></td>                  
                <td><?php echo $item->no_kendaraan; ?></td> 
                <?php 
            
                $get_total = $this->db->query("SELECT count(no_kendaraan) as nomor from opsi_transaksi_pengiriman where tanggal_kirim='$item->tanggal_kirim' and no_kendaraan='$item->no_kendaraan'");
                $hasil_total = $get_total->row();
                ?>                 
                <td><?php echo  $hasil_total->nomor." "."Kali"; ?></td>
                <td align="center"><a href="<?php echo base_url().'laporan/detail_laporan_ritase/'.$item->tanggal_kirim.'/'.$item->kode_kendaraan ?>" class="btn btn-primary"><i class="fa fa-search"></i> Detail</a></td>
              </tr>
              <?php
              $no++;
            } ?>
          </tbody>                
        </table>