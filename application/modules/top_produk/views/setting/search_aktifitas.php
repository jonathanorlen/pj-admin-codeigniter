 <?php
 $data = $this->input->post();
 

?>
<table class="table table-hover table-bordered" id="sample_editable_1"  style="font-size:1.5em;">
<thead>
            <th>No</th>
            <th>Nama Aktifitias</th>
            <th>Jumlah Transaksi</th>
            <th>Action</th>
</thead>
<tbody>
            <tr>
            <?php
                if(@$data['tgl_awal'] && @$data['tgl_akhir']){
                  $tgl_awal = $data['tgl_awal'];
                  $tgl_akhir = $data['tgl_akhir'];
                  $this->db->where('tanggal_pembelian >=', $tgl_awal);
                  $this->db->where('tanggal_pembelian <=', $tgl_akhir);
                 }
            
                $get_pembelian = $this->db->get('transaksi_pembelian');
                $hasil_pembelian = $get_pembelian->result();
                $jml_pembelian = count($hasil_pembelian);
            ?>
                <td>1</td>
                <td>Pembelian</td>
                <td><?php echo $jml_pembelian; ?> Transaksi</td>
                <td>
                    <div class="btn-group">
                        <a href="<?php echo base_url().'laporan_aktifitas/detail_pembelian/'.@$tgl_awal."/".@$tgl_akhir; ?>" title="Detail" class="btn btn-xs green">
                            <i class="fa fa-search"></i> detail
                        </a>
                    </div>
                </td>
            </tr>
            <tr>
            <?php
            if(@$data['tgl_awal'] && @$data['tgl_akhir']){
                  $tgl_awal = $data['tgl_awal'];
                  $tgl_akhir = $data['tgl_akhir'];
                  $this->db->where('tanggal_input >=', $tgl_awal);
                  $this->db->where('tanggal_input <=', $tgl_akhir);
                 }
                $get_po = $this->db->get('transaksi_po');
                $hasil_po = $get_po->result();
                $jml_po = count($hasil_po);
            ?>
                <td>1</td>
                <td>Pre Order</td>
                <td><?php echo $jml_po; ?> Transaksi</td>
                <td>
                    <div class="btn-group">
                        <a href="<?php echo base_url().'laporan_aktifitas/detail_po/'.@$tgl_awal."/".@$tgl_akhir; ?>" title="Detail" class="btn btn-xs green">
                            <i class="fa fa-search"></i> detail
                        </a>
                    </div>
                </td>
            </tr>
            <tr>
            <?php
                if(@$data['tgl_awal'] && @$data['tgl_akhir']){
                  $tgl_awal = $data['tgl_awal'];
                  $tgl_akhir = $data['tgl_akhir'];
                  $this->db->where('tanggal_retur_keluar >=', $tgl_awal);
                  $this->db->where('tanggal_retur_keluar <=', $tgl_akhir);
                 }
                 
                $get_retur = $this->db->get('transaksi_retur');
                $hasil_retur = $get_retur->result();
                $jml_retur = count($hasil_retur);
            ?>
                <td>2</td>
                <td>Retur Pembelian</td>
                <td><?php echo $jml_retur ?> Transaksi</td>
                <td>
                    <div class="btn-group">
                        <a href="<?php echo base_url().'laporan_aktifitas/detail_retur_pembelian/'.@$tgl_awal."/".@$tgl_akhir; ?>" title="Detail" class="btn btn-xs green">
                            <i class="fa fa-search"></i> detail
                        </a>
                    </div>
                </td>
            </tr>
            <tr>
            <?php
                if(@$data['tgl_awal'] && @$data['tgl_akhir']){
                  $tgl_awal = $data['tgl_awal'];
                  $tgl_akhir = $data['tgl_akhir'];
                  $this->db->where('tanggal_transaksi >=', $tgl_awal);
                  $this->db->where('tanggal_transaksi <=', $tgl_akhir);
                 }
                
                $get_mutasi = $this->db->get('transaksi_mutasi');
                $hasil_mutasi = $get_mutasi->result();
                $jml_mutasi = count($hasil_mutasi);
            ?>
                <td>3</td>
                <td>Mutasi Bahan</td>
                <td><?php echo $jml_mutasi; ?> Transaksi</td>
                <td>
                    <div class="btn-group">
                        <a href="<?php echo base_url().'laporan_aktifitas/detail_mutasi/'.@$tgl_awal."/".@$tgl_akhir; ?>" title="Detail" class="btn btn-xs green">
                            <i class="fa fa-search"></i> detail
                        </a>
                    </div>
                </td>
            </tr>
            <tr>
            <?php
                if(@$data['tgl_awal'] && @$data['tgl_akhir']){
                  $tgl_awal = $data['tgl_awal'];
                  $tgl_akhir = $data['tgl_akhir'];
                  $this->db->where('tanggal_spoil >=', $tgl_awal);
                  $this->db->where('tanggal_spoil <=', $tgl_akhir);
                 }
                 
                $get_spoil = $this->db->get('transaksi_spoil');
                $hasil_spoil = $get_spoil->result();
                $jml_spoil = count($hasil_spoil);
            ?>
                <td>4</td>
                <td>Spoil</td>
                <td><?php echo $jml_spoil ?> Transaksi</td>
                <td>
                    <div class="btn-group">
                        <a href="<?php echo base_url().'laporan_aktifitas/detail_spoil/'.@$tgl_awal."/".@$tgl_akhir; ?>" title="Detail" class="btn btn-xs green">
                            <i class="fa fa-search"></i> detail
                        </a>
                    </div>
                </td>
            </tr>
            <tr>
            <?php
                if(@$data['tgl_awal'] && @$data['tgl_akhir']){
                  $tgl_awal = $data['tgl_awal'];
                  $tgl_akhir = $data['tgl_akhir'];
                  $this->db->where('tanggal_opname >=', $tgl_awal);
                  $this->db->where('tanggal_opname <=', $tgl_akhir);
                 }
                
                $get_opname = $this->db->get('transaksi_opname');
                $hasil_opname = $get_opname->result();
                $jml_opname = count($hasil_opname);
            ?>
                <td>5</td>
                <td>Opname</td>
                <td><?php echo $jml_opname; ?> Transaksi</td>
                <td>
                    <div class="btn-group">
                        <a href="<?php echo base_url().'laporan_aktifitas/detail_opname/'.@$tgl_awal."/".@$tgl_akhir; ?>" title="Detail" class="btn btn-xs green">
                            <i class="fa fa-search"></i> detail
                        </a>
                    </div>
                </td>
            </tr>
            <tr>
            <?php
                if(@$data['tgl_awal'] && @$data['tgl_akhir']){
                  $tgl_awal = $data['tgl_awal'];
                  $tgl_akhir = $data['tgl_akhir'];
                  $this->db->where('tanggal_penjualan >=', $tgl_awal);
                  $this->db->where('tanggal_penjualan <=', $tgl_akhir);
                 }
            
                $get_penjualan = $this->db->get('transaksi_penjualan');
                $hasil_penjualan = $get_penjualan->result();
                $jml_penjualan = count($hasil_penjualan);
            ?>
                <td>6</td>
                <td>Penjualan</td>
                <td><?php echo $jml_penjualan; ?> Transaksi</td>
                <td>
                    <div class="btn-group">
                        <a href="<?php echo base_url().'laporan_aktifitas/detail_penjualan/'.@$tgl_awal."/".@$tgl_akhir; ?>" title="Detail" class="btn btn-xs green">
                            <i class="fa fa-search"></i> detail
                        </a>
                    </div>
                </td>
            </tr>
            <tr>
            <?php
                if(@$data['tgl_awal'] && @$data['tgl_akhir']){
                  $tgl_awal = $data['tgl_awal'];
                  $tgl_akhir = $data['tgl_akhir'];
                  $this->db->where('tanggal_input >=', $tgl_awal);
                  $this->db->where('tanggal_input <=', $tgl_akhir);
                 }
                
                $get_ro = $this->db->get('transaksi_ro');
                $hasil_ro = $get_ro->result();
                $jml_ro = count($hasil_ro);
            ?>
                <td>7</td>
                <td>Request Order</td>
                <td><?php echo $jml_ro; ?> Transaksi</td>
                <td>
                    <div class="btn-group">
                        <a href="<?php echo base_url().'laporan_aktifitas/detail_ro/'.@$tgl_awal."/".@$tgl_akhir; ?>" title="Detail" class="btn btn-xs green">
                            <i class="fa fa-search"></i> detail
                        </a>
                    </div>
                </td>
            </tr>
            </tbody>