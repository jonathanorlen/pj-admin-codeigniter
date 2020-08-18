      
<?php



            $kode_default = $this->db->get('setting_gudang');
            $hasil_unit =$kode_default->row();
            $param=$hasil_unit->kode_unit;
            
            $jenis_filter=$this->input->post('jenis_filter');
            $kategori_filter=$this->input->post('kategori_filter');
            $nama_produk=$this->input->post('nama_produk');
            if($kategori_filter=='kategori' and !empty($jenis_filter) and empty($nama_produk)){
              
              $this->db->where('kode_kategori_produk',$jenis_filter);
              //$this->db->where('nama_bahan_baku',$nama_produk);

            }elseif ($kategori_filter=='blok' and !empty($jenis_filter) and empty($nama_produk)) {
              
              $this->db->where('kode_rak',$jenis_filter);
              //$this->db->where('nama_bahan_baku',$nama_produk);
            }else{
               $this->db->like('nama_bahan_baku',$nama_produk,'both');
            }

            $this->db->where('kode_unit',$param);
$this->db->select('*');
$this->db->from('master_bahan_baku');
$transaksi = $this->db->get();
$hasil_transaksi = $transaksi->result();

$total=0;
$kode_default = $this->db->get('setting_gudang');
$hasil_unit =$kode_default->row();
$param =$hasil_unit->kode_unit;
?>
<br>
<br>
<br>
<a style="padding:13px; margin-bottom:10px; margin-right:0px;" id="spoil_tambah" class="btn btn-app green pull-right" ><i class="fa fa-barcode"></i> Barcode </a>
<form method="post" id="opsi_spoil"> 
  <table class="table table-striped table-hover table-bordered" id="tabel_daftar" style="font-size:1.5em;">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Jumlah</th>
        <th>Nama Blok</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php

      $nomor = 1;  

      foreach($hasil_transaksi as $daftar){ 
        ?> 
        <tr>
          <td><?php echo $nomor; ?></td>
          <td><?php echo $daftar->nama_bahan_baku; ?></td>
          <td><?php echo $daftar->real_stock.' '.$daftar->satuan_stok; ?></td>
          <td><?php echo $daftar->nama_rak; ?></td>
          <td align="center"><input name="opsi_spoil[]" type="checkbox" id="opsi_pilihan" value="<?php echo $daftar->kode_bahan_baku; ?>"></td>
        </tr>
        <?php 
        $nomor++; 
      } 
      ?>

    </tbody>
    <tfoot>
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Jumlah</th>
        <th>Nama Blok</th>
        <th>Action</th>
      </tr>
    </tfoot>            
  </table>
  <input type="hidden" name="kode_unit" id="kode_unit" value="<?php echo $param ?>">
  
  <input type="hidden" name="kode_spoil" id="kode_spoil" value="<?php echo $kode_trans ?>">
</form>
<script type="text/javascript">
  $('#spoil_tambah').click(function(){
    checkedValue = $('#opsi_pilihan:checked').val();
    kode_spoil = $('#kode_spoil').val();
    if(!checkedValue){
      alert("Pilih Barang Yang Akan Di Spoil");
    } else {
      $.ajax( {  
        type :"post",  
        url : "<?php echo base_url().'master/printer_barcode/simpan_spoil_temp_baru'; ?>",  
        cache :false,
        data : $("#opsi_spoil").serialize(),
        beforeSend:function(){
          $(".tunggu").show();  
        },
        success : function(data) {
          $(".tunggu").hide();  
          setTimeout(function(){
           // window.location = "<?php echo base_url() . 'master/printer_barcode/tambah_spoil/'; ?>"+kode_spoil;
          },15);       
        },  
        error : function(data) {
        }  
      });
    }

  });
</script>