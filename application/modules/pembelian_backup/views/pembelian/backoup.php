<?php
$this->db->select('*') ;
			$query_pembelian_temp = $this->db->get_where('opsi_transaksi_pembelian_temp',array('kode_pembelian'=>$kode_pembelian));

			$total = 0;
			foreach ($query_pembelian_temp->result() as $item){
				$data_opsi['kode_pembelian'] = $item->kode_pembelian;
				$data_opsi['kode_po'] = $kode_po;
				$data_opsi['kategori_bahan'] = $item->kategori_bahan;
				$data_opsi['kode_bahan'] = $item->kode_bahan;
				$data_opsi['nama_bahan'] = $item->nama_bahan;
				$data_opsi['jumlah'] = $item->jumlah;
				$data_opsi['kode_satuan'] = $item->kode_satuan;
				$data_opsi['nama_satuan'] = $item->nama_satuan;
				$data_opsi['harga_satuan'] = $item->harga_satuan;
		     	//$data_opsi['diskon_item'] = $item->diskon_item;
				$data_opsi['kode_supplier'] = $input['kode_supplier'];
				$data_opsi['nama_supplier'] = $input['nama_supplier'];
				$data_opsi['subtotal'] = $item->subtotal;
				$data_opsi['position'] = 'gudang';

				$tabel_opsi_transaksi_pembelian = $this->db->insert("opsi_transaksi_pembelian", $data_opsi);

				$grand_total = $total + $item->subtotal;
				$harga_satuan = $item->harga_satuan;
				$nama_bahan = $item->nama_bahan;
				$stok_masuk = $item->jumlah;
				$kode_pembelian = $item->kode_pembelian;
				$kategori_bahan = $item->kategori_bahan;
				$kode_bahan = $item->kode_bahan;
				$nama_supplier = $item->nama_supplier;
				$kode_supplier = $item->kode_supplier;

				if($kategori_bahan=='bahan baku'){
					$kode_default = $this->db->get('setting_gudang');
					$hasil_kode_default = $kode_default->row();

					$this->db->select('*') ;
					$real_stock = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$hasil_kode_default->kode_unit));
					$stok_real = $real_stock->row()->real_stock ;
					$konversi_stok = $real_stock->row()->jumlah_dalam_satuan_pembelian ;

					if(empty($stok_real)){

						$data_stok['real_stock'] = $stok_masuk * $konversi_stok;
						$this->db->update('master_bahan_baku',$data_stok,array('kode_bahan_baku'=>$kode_bahan));

						$this->db->select('kode_unit');
						$kode_default = $this->db->get('setting_gudang');
						$hasil_kode_default = $kode_default->row();
						$kode_unit = @$hasil_kode_default->kode_unit;
						$kode_rak = @$hasil_kode_default->kode_rak_default;

						$this->db->select('nama_unit');
						$master_unit = $this->db->get_where('master_unit', array('kode_unit'=>$kode_unit));
						$hasil_master_unit = $master_unit->row();
						$nama_unit = @$hasil_master_unit->nama_unit;

						$this->db->select('nama_rak');
						$master_rak = $this->db->get_where('master_rak', array('kode_rak'=>$kode_rak));
						$hasil_master_rak = $master_rak->row();
						$nama_rak = @$hasil_master_rak->nama_rak;

						$harga_satuan_stok = $harga_satuan / $konversi_stok;

						$stok['jenis_transaksi'] = 'pembelian' ;
						$stok['kode_transaksi'] = $kode_pembelian ;
						$stok['kategori_bahan'] = $kategori_bahan ;
						$stok['kode_bahan'] = $kode_bahan ;
						$stok['nama_bahan'] = $nama_bahan ;
						$stok['stok_keluar'] = '';
						$stok['stok_masuk'] = $stok_masuk * $konversi_stok ;
						$stok['posisi_awal'] = 'supplier';
						$stok['posisi_akhir'] = 'gudang';
						$stok['hpp'] = $harga_satuan_stok ;
						$stok['sisa_stok'] = $stok_masuk * $konversi_stok ;
						$stok['kode_unit_tujuan'] = $kode_unit;
						$stok['nama_unit_tujuan'] = $nama_unit;
						$stok['kode_rak_tujuan'] = $kode_rak;
						$stok['nama_rak_tujuan'] = $nama_rak;
						$stok['id_petugas'] = $id_petugas;
						$stok['nama_petugas'] = $nama_petugas;
						$stok['tanggal_transaksi'] = date("Y-m-d") ;

						//$transaksi_stok = $this->db->insert("transaksi_stok", $stok);

					}
					else{
						$this->db->select('*') ;
						$jumlah_stok = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$hasil_kode_default->kode_unit));
						$jumlah_stok = $jumlah_stok->row()->real_stock ;

						$data_stok['real_stock'] = ($stok_masuk * $konversi_stok)  + $jumlah_stok;
						$this->db->update('master_bahan_baku',$data_stok,array('kode_bahan_baku'=>$kode_bahan));

						$this->db->select('kode_unit');
						$kode_default = $this->db->get('setting_gudang');
						$hasil_kode_default = $kode_default->row();
						$kode_unit = @$hasil_kode_default->kode_unit_default;
						$kode_rak = @$hasil_kode_default->kode_rak_default;

						$this->db->select('nama_unit');
						$master_unit = $this->db->get_where('master_unit', array('kode_unit'=>$kode_unit));
						$hasil_master_unit = $master_unit->row();
						$nama_unit = @$hasil_master_unit->nama_unit;

						$this->db->select('nama_rak');
						$master_rak = $this->db->get_where('master_rak', array('kode_rak'=>$kode_rak));
						$hasil_master_rak = $master_rak->row();
						$nama_rak = @$hasil_master_rak->nama_rak;

						$harga_satuan_stok = $harga_satuan / $konversi_stok;

						$stok['jenis_transaksi'] = 'pembelian' ;
						$stok['kode_transaksi'] = $kode_pembelian ;
						$stok['kategori_bahan'] = $kategori_bahan ;
						$stok['kode_bahan'] = $kode_bahan ;
						$stok['nama_bahan'] = $nama_bahan ;
						$stok['stok_keluar'] = '';
						$stok['stok_masuk'] = $stok_masuk * $konversi_stok ;
						$stok['posisi_awal'] = 'supplier';
						$stok['posisi_akhir'] = 'gudang';
						$stok['hpp'] = $harga_satuan_stok ;
						$stok['sisa_stok'] = $stok_masuk * $konversi_stok ;
						$stok['kode_unit_tujuan'] = $kode_unit;
						$stok['nama_unit_tujuan'] = $nama_unit;
						$stok['kode_rak_tujuan'] = $kode_rak;
						$stok['nama_rak_tujuan'] = $nama_rak;
						$stok['id_petugas'] = $id_petugas;
						$stok['nama_petugas'] = $nama_petugas;
						$stok['tanggal_transaksi'] = date("Y-m-d") ;

						//$transaksi_stok = $this->db->insert("transaksi_stok", $stok);

					}
				}
				if($kategori_bahan=='barang'){
					$kode_default = $this->db->get('setting_gudang');
					$hasil_kode_default = $kode_default->row();

					$this->db->select('*') ;
					$real_stock = $this->db->get_where('master_barang',array('kode_barang'=>$kode_bahan,'position'=>$hasil_kode_default->kode_unit));
					$stok_real = $real_stock->row()->real_stok ;
					$konversi_stok = $real_stock->row()->jumlah_dalam_satuan_pembelian ;

					if(empty($stok_real)){

						$data_stok['real_stok'] = $stok_masuk * $konversi_stok;
						$this->db->update('master_barang',$data_stok,array('kode_barang'=>$kode_bahan));

						$this->db->select('kode_unit');
						$kode_default = $this->db->get('setting_gudang');
						$hasil_kode_default = $kode_default->row();
						$kode_unit = @$hasil_kode_default->kode_unit;
						$kode_rak = @$hasil_kode_default->kode_rak_default;

						$this->db->select('nama_unit');
						$master_unit = $this->db->get_where('master_unit', array('kode_unit'=>$kode_unit));
						$hasil_master_unit = $master_unit->row();
						$nama_unit = @$hasil_master_unit->nama_unit;

						$this->db->select('nama_rak');
						$master_rak = $this->db->get_where('master_rak', array('kode_rak'=>$kode_rak));
						$hasil_master_rak = $master_rak->row();
						$nama_rak = @$hasil_master_rak->nama_rak;

						$harga_satuan_stok = $harga_satuan / $konversi_stok;

						$stok['jenis_transaksi'] = 'pembelian' ;
						$stok['kode_transaksi'] = $kode_pembelian ;
						$stok['kategori_bahan'] = $kategori_bahan ;
						$stok['kode_bahan'] = $kode_bahan ;
						$stok['nama_bahan'] = $nama_bahan ;
						$stok['stok_keluar'] = '';
						$stok['stok_masuk'] = $stok_masuk * $konversi_stok ;
						$stok['posisi_awal'] = 'supplier';
						$stok['posisi_akhir'] = 'gudang';
						$stok['hpp'] = $harga_satuan_stok ;
						$stok['sisa_stok'] = $stok_masuk * $konversi_stok ;
						$stok['kode_unit_tujuan'] = $kode_unit;
						$stok['nama_unit_tujuan'] = $nama_unit;
						$stok['kode_rak_tujuan'] = $kode_rak;
						$stok['nama_rak_tujuan'] = $nama_rak;
						$stok['id_petugas'] = $id_petugas;
						$stok['nama_petugas'] = $nama_petugas;
						$stok['tanggal_transaksi'] = date("Y-m-d") ;

						//$transaksi_stok = $this->db->insert("transaksi_stok", $stok);

					}
					else{
						$this->db->select('*') ;
						$jumlah_stok = $this->db->get_where('master_barang',array('kode_barang'=>$kode_bahan,'position'=>$hasil_kode_default->kode_unit));
						$jumlah_stok = $jumlah_stok->row()->real_stok ;

						$data_stok['real_stok'] = ($stok_masuk * $konversi_stok)  + $jumlah_stok;
						$this->db->update('master_barang',$data_stok,array('kode_barang'=>$kode_bahan));

						$this->db->select('kode_unit');
						$kode_default = $this->db->get('setting_gudang');
						$hasil_kode_default = $kode_default->row();
						$kode_unit = @$hasil_kode_default->kode_unit;
						$kode_rak = @$hasil_kode_default->kode_rak_default;

						$this->db->select('nama_unit');
						$master_unit = $this->db->get_where('master_unit', array('kode_unit'=>$kode_unit));
						$hasil_master_unit = $master_unit->row();
						$nama_unit = @$hasil_master_unit->nama_unit;

						$this->db->select('nama_rak');
						$master_rak = $this->db->get_where('master_rak', array('kode_rak'=>$kode_rak));
						$hasil_master_rak = $master_rak->row();
						$nama_rak = @$hasil_master_rak->nama_rak;

						$harga_satuan_stok = $harga_satuan / $konversi_stok;

						$stok['jenis_transaksi'] = 'pembelian' ;
						$stok['kode_transaksi'] = $kode_pembelian ;
						$stok['kategori_bahan'] = $kategori_bahan ;
						$stok['kode_bahan'] = $kode_bahan ;
						$stok['nama_bahan'] = $nama_bahan ;
						$stok['stok_keluar'] = '';
						$stok['stok_masuk'] = $stok_masuk * $konversi_stok ;
						$stok['posisi_awal'] = 'supplier';
						$stok['posisi_akhir'] = 'gudang';
						$stok['hpp'] = $harga_satuan_stok ;
						$stok['sisa_stok'] = $stok_masuk * $konversi_stok ;
						$stok['kode_unit_tujuan'] = $kode_unit;
						$stok['nama_unit_tujuan'] = $nama_unit;
						$stok['kode_rak_tujuan'] = $kode_rak;
						$stok['nama_rak_tujuan'] = $nama_rak;
						$stok['id_petugas'] = $id_petugas;
						$stok['nama_petugas'] = $nama_petugas;
						$stok['tanggal_transaksi'] = date("Y-m-d") ;

						//$transaksi_stok = $this->db->insert("transaksi_stok", $stok);

					}
				}

				if($kategori_bahan=='bahan jadi'){
					$this->db->select('*') ;
					$real_stock = $this->db->get_where('master_bahan_jadi',array('kode_bahan_jadi'=>$kode_bahan));
					$stok_real = $real_stock->row()->real_stock ;
					$kode_konversi_stok_bahan_jadi = $real_stock->row()->kode_satuan_stok ;


					$konversi_stok_bahan_jadi = $this->db->get_where('master_satuan',array('kode'=>$kode_konversi_stok_bahan_jadi));
					$konversi_stok_bahan_jadi = $konversi_stok_bahan_jadi->row()->acuan ;

					if(empty($stok_real)){

						$data_stok['real_stock'] = $stok_masuk;
						$this->db->update('master_bahan_jadi',$data_stok,array('kode_bahan_jadi'=>$kode_bahan));

						$this->db->select('kode_unit_default,kode_rak_default');
						$kode_default = $this->db->get('master_setting');
						$hasil_kode_default = $kode_default->row();
						$kode_unit = @$hasil_kode_default->kode_unit_default;
						$kode_rak = @$hasil_kode_default->kode_rak_default;

						$this->db->select('nama_unit');
						$master_unit = $this->db->get_where('master_unit', array('kode_unit'=>$kode_unit));
						$hasil_master_unit = $master_unit->row();
						$nama_unit = @$hasil_master_unit->nama_unit;

						$this->db->select('nama_rak');
						$master_rak = $this->db->get_where('master_rak', array('kode_rak'=>$kode_rak));
						$hasil_master_rak = $master_rak->row();
						$nama_rak = @$hasil_master_rak->nama_rak;

						$harga_satuan_stok =$harga_satuan / $konversi_stok_bahan_jadi;

						$stok['jenis_transaksi'] = 'pembelian' ;
						$stok['kode_transaksi'] = $kode_pembelian ;
						$stok['kategori_bahan'] = $kategori_bahan ;
						$stok['kode_bahan'] = $kode_bahan ;
						$stok['nama_bahan'] = $nama_bahan ;
						$stok['stok_keluar'] = '';
						$stok['stok_masuk'] = $stok_masuk ;
						$stok['posisi_awal'] = 'supplier';
						$stok['posisi_akhir'] = 'gudang';
						$stok['hpp'] = $harga_satuan_stok ;
						$stok['sisa_stok'] = $stok_masuk * $konversi_stok ;
						$stok['kode_unit_tujuan'] = $kode_unit;
						$stok['nama_unit_tujuan'] = $nama_unit;
						$stok['kode_rak_tujuan'] = $kode_rak;
						$stok['nama_rak_tujuan'] = $nama_rak;
						$stok['id_petugas'] = $id_petugas;
						$stok['nama_petugas'] = $nama_petugas;
						$stok['tanggal_transaksi'] = date("Y-m-d") ;

						//$transaksi_stok = $this->db->insert("transaksi_stok", $stok);

					}
					else{
						$this->db->select('*') ;
						$jumlah_stok = $this->db->get_where('master_bahan_jadi',array('kode_bahan_jadi'=>$kode_bahan));
						$jumlah_stok = $jumlah_stok->row()->real_stock ;

						$data_stok['real_stock'] = $stok_masuk + $jumlah_stok;
						$this->db->update('master_bahan_jadi',$data_stok,array('kode_bahan_jadi'=>$kode_bahan));

						$this->db->select('kode_unit_default,kode_rak_default');
						$kode_default = $this->db->get('master_setting');
						$hasil_kode_default = $kode_default->row();
						$kode_unit = @$hasil_kode_default->kode_unit_default;
						$kode_rak = @$hasil_kode_default->kode_rak_default;

						$this->db->select('nama_unit');
						$master_unit = $this->db->get_where('master_unit', array('kode_unit'=>$kode_unit));
						$hasil_master_unit = $master_unit->row();
						$nama_unit = @$hasil_master_unit->nama_unit;

						$this->db->select('nama_rak');
						$master_rak = $this->db->get_where('master_rak', array('kode_rak'=>$kode_rak));
						$hasil_master_rak = $master_rak->row();
						$nama_rak = @$hasil_master_rak->nama_rak;

						$harga_satuan_stok =$harga_satuan / $konversi_stok_bahan_jadi;

						$stok['jenis_transaksi'] = 'pembelian' ;
						$stok['kode_transaksi'] = $kode_pembelian ;
						$stok['kategori_bahan'] = $kategori_bahan ;
						$stok['kode_bahan'] = $kode_bahan ;
						$stok['nama_bahan'] = $nama_bahan ;
						$stok['stok_keluar'] = '';
						$stok['stok_masuk'] = $stok_masuk ;
						$stok['posisi_awal'] = 'supplier';
						$stok['posisi_akhir'] = 'gudang';
						$stok['hpp'] = $harga_satuan_stok ;
						$stok['sisa_stok'] = $stok_masuk * $konversi_stok ;
						$stok['kode_unit_tujuan'] = $kode_unit;
						$stok['nama_unit_tujuan'] = $nama_unit;
						$stok['kode_rak_tujuan'] = $kode_rak;
						$stok['nama_rak_tujuan'] = $nama_rak;
						$stok['id_petugas'] = $id_petugas;
						$stok['nama_petugas'] = $nama_petugas;
						$stok['tanggal_transaksi'] = date("Y-m-d") ;

						//$transaksi_stok = $this->db->insert("transaksi_stok", $stok);

					}
				}
			}

			//if($transaksi_stok){
				unset($input['kategori_bahan']);
				unset($input['kode_bahan']);
				unset($input['nama_bahan']);
				unset($input['jumlah']);
				unset($input['kode_satuan']);
				unset($input['nama_satuan']);
				unset($input['harga_satuan']);
				unset($input['id_item']);

				$this->db->select('*') ;
				$query_akun = $this->db->get_where('keuangan_sub_kategori_akun',array('kode_sub_kategori_akun'=>$input['kode_sub']))->row();
				$kode_sub = $query_akun->kode_sub_kategori_akun;
				$nama_sub = $query_akun->nama_sub_kategori_akun;
				$kode_kategori = $query_akun->kode_kategori_akun;
				$nama_kategori = $query_akun->nama_kategori_akun;
				$kode_jenis = $query_akun->kode_jenis_akun;
				$nama_jenis = $query_akun->nama_jenis_akun;

				$this->db->select('*, SUM(subtotal)as grand_total') ;
				$query = $this->db->get_where('opsi_transaksi_pembelian_temp',array('kode_pembelian'=>$kode_pembelian));
				$data = $query->row();
				$grand_total = $data->grand_total ;

				unset($input['kode_sub']);

				$input['tanggal_pembelian'] = date("Y-m-d") ;
				$input['total_nominal'] = $grand_total ;
				$input['grand_total'] = $grand_total - $input['diskon_rupiah'];
				$input['petugas'] = $nama_petugas ;
				$input['id_petugas'] = $id_petugas;
				$input['keterangan'] = '' ;
				$input['nama_supplier'] = $nama_supplier ;
				$input['status'] = 'belum divalidasi';
				$input['position'] = 'gudang' ;

				$tabel_transaksi_pembelian = $this->db->insert("transaksi_pembelian", $input);
				if($tabel_transaksi_pembelian){
					
					if($input['proses_pembayaran'] == 'cash'){
						$data_keu['id_petugas'] = $id_petugas;
						$data_keu['petugas'] = $nama_petugas ;
						$data_keu['kode_referensi'] = $kode_pembelian ;
						$data_keu['tanggal_transaksi'] = date("Y-m-d") ;
						$data_keu['keterangan'] = 'pembelian' ;
						$data_keu['nominal'] = $grand_total - $input['diskon_rupiah'];
						$data_keu['kode_jenis_keuangan'] = $kode_jenis ;
						$data_keu['nama_jenis_keuangan'] = $nama_jenis ;
						$data_keu['kode_kategori_keuangan'] = $kode_kategori ;
						$data_keu['nama_kategori_keuangan'] = $nama_kategori ;
						$data_keu['kode_sub_kategori_keuangan'] = $kode_sub ;
						$data_keu['nama_sub_kategori_keuangan'] = $nama_sub ;
						
						//$keuangan = $this->db->insert("keuangan_keluar", $data_keu);
					}
					else if($input['proses_pembayaran'] == 'debet'){
						$data_keu['id_petugas'] = $id_petugas;
						$data_keu['petugas'] = $nama_petugas ;
						$data_keu['kode_referensi'] = $kode_pembelian ;
						$data_keu['tanggal_transaksi'] = date("Y-m-d") ;
						$data_keu['keterangan'] = 'pembelian' ;
						$data_keu['nominal'] = $grand_total - $input['diskon_rupiah'];
						$data_keu['kode_jenis_keuangan'] = $kode_jenis ;
						$data_keu['nama_jenis_keuangan'] = $nama_jenis ;
						$data_keu['kode_kategori_keuangan'] = $kode_kategori ;
						$data_keu['nama_kategori_keuangan'] = $nama_kategori ;
						$data_keu['kode_sub_kategori_keuangan'] = $kode_sub ;
						$data_keu['nama_sub_kategori_keuangan'] = $nama_sub ;
						
						//$keuangan = $this->db->insert("keuangan_keluar", $data_keu);
					}
					else if($input['proses_pembayaran'] == 'credit'){
						$data_keu['id_petugas'] = $id_petugas;
						$data_keu['petugas'] = $nama_petugas ;
						$data_keu['kode_referensi'] = $kode_pembelian ;
						$data_keu['tanggal_transaksi'] = date("Y-m-d") ;
						$data_keu['keterangan'] = 'pembelian' ;
						$data_keu['nominal'] = $input['dibayar'];
						$data_keu['kode_jenis_keuangan'] = $kode_jenis ;
						$data_keu['nama_jenis_keuangan'] = $nama_jenis ;
						$data_keu['kode_kategori_keuangan'] = $kode_kategori ;
						$data_keu['nama_kategori_keuangan'] = $nama_kategori ;
						$data_keu['kode_sub_kategori_keuangan'] = $kode_sub ;
						$data_keu['nama_sub_kategori_keuangan'] = $nama_sub ;
						
						//$keuangan = $this->db->insert("keuangan_keluar", $data_keu);

						$data_hutang['kode_transaksi'] = $kode_pembelian ;
						$data_hutang['kode_supplier'] = $kode_supplier ;
						$data_hutang['nama_supplier'] = $nama_supplier ;
						$data_hutang['nominal_hutang'] = ($grand_total - $input['diskon_rupiah']) - $input['dibayar'];
						$data_hutang['angsuran'] = '' ;
						$data_hutang['sisa'] = ($grand_total - $input['diskon_rupiah']) - $input['dibayar'] ;
						$data_hutang['tanggal_transaksi'] = date("Y-m-d") ;
						$data_hutang['petugas'] = $nama_petugas ;
						$data_hutang['id_petugas'] = $id_petugas;

						//$hutang = $this->db->insert("transaksi_hutang", $data_hutang);

					}
					$this->db->delete( 'opsi_transaksi_pembelian_temp', array('kode_pembelian' => $kode_pembelian) );
				    //$this->db->truncate('opsi_transaksi_pembelian_temp');
					echo '1|<div class="alert alert-success">Berhasil Melakukan Pembelian.</div>';  
				}
				else{
					echo '1|<div class="alert alert-danger">Gagal Melakukan Pembelian (Trx_pmbelian) .</div>';  
				}
			//}else{
				//echo '1|<div class="alert alert-danger">Gagal Melakukan Pembelian (update_stok).</div>';  
			//}
		
	}