<table  class="table table-striped table-hover table-bordered" id="tabel_daftarr"  style="font-size:1.5em;">

  <?php
  $kode_default = $this->db->get('setting_gudang');
  $hasil_unit =$kode_default->row();
  $param=$hasil_unit->kode_unit;



  $this->db->limit(100);
  $data = $this->input->post();
  if(@$data['kategori']){
    $kategori = $data['kategori'];
    $this->db->where('kode_kategori_produk',$kategori);
  }
  if(@$data['nama_produk']){
    $produk = $data['nama_produk'];
    $this->db->like('nama_bahan_baku',$produk,'both');
  }
  $bahan_baku = $this->db->get_where('master_bahan_baku',array('kode_unit' => $param));
  $hasil_bahan_baku = $bahan_baku->result();
  ?>

  <thead>
    <tr width="100%">
      <th>No</th>
      <th>Kode Produk</th>
      <th>Nama Produk</th>
      <th style="display:none;">Kategori Produk</th>
      <th>Unit</th>
      <th>Block</th>
      <th>HPP</th>
      <th>Harga Jual 1</th>
      <th>Harga Jual 2</th>
      <th>Harga Jual 3</th>
      <th>Harga Beli</th>
      <th>Satuan Pembelian</th>
      <th>Satuan Stok</th>
      <th style="width:50px;display:none;">Isi Dalam 1 <br>(Satuan Pembelian)</th>
      <th>Stok Minimal</th>
      <th>Real Stock</th>
      <th>Supplier</th>
      <th width="10%">Action</th>
    </tr>
  </thead>
  <tbody style="width: 700px;" id="posts">
    <?php
    $nomor=1;
    foreach($hasil_bahan_baku as $daftar){

                // $opsi_bahan_baku = $this->db->get_where('opsi_bahan_baku',array('kode_bahan_baku' => $daftar->kode_bahan_baku));
                // $hasil_opsi_bahan_baku = $opsi_bahan_baku->row();

      ?>
      <tr class="table_bahan" id="table_bahan_<?php echo $nomor; ?>" key="<?php echo $nomor; ?>">
        <td><?php echo $nomor; ?></td>
        <td><?php echo $daftar->kode_bahan_baku; ?></td>
        <td width="500px"><?php echo $daftar->nama_bahan_baku; ?></td>
        <td style="display:none;"><?php echo $daftar->nama_kategori_produk; ?></td>
        <td><?php echo $daftar->nama_unit; ?></td>
        <td><?php echo $daftar->nama_rak; ?></td>
        <td align="right">
          <?php echo format_rupiah($daftar->hpp); ?>
        </td>
        <td align="right">
          <div class="edit_bahan edit_bahan_<?php echo $nomor; ?>">
            <input type="hidden" class="form-control" value="<?php echo $daftar->id; ?>" id="id_<?php echo $nomor; ?>">
            <input type="text" class="form-control" value="<?php echo $daftar->harga_jual_1; ?>" id="hj1_<?php echo $nomor; ?>">
          </div>
          <div class="normal_bahan normal_bahan_<?php echo $nomor; ?>" id="thj1_<?php echo $nomor; ?>">
            <?php echo format_rupiah($daftar->harga_jual_1); ?>
          </div>
        </td>
        <td align="right">
          <div class="edit_bahan edit_bahan_<?php echo $nomor; ?>">
            <input type="text" class="form-control" value="<?php echo $daftar->harga_jual_2; ?>" id="hj2_<?php echo $nomor; ?>">
          </div>
          <div class="normal_bahan normal_bahan_<?php echo $nomor; ?>" id="thj2_<?php echo $nomor; ?>">
            <?php echo format_rupiah($daftar->harga_jual_2); ?>
          </div>
        </td>
        <td align="right">
          <div class="edit_bahan edit_bahan_<?php echo $nomor; ?>">
            <input type="text" class="form-control" value="<?php echo $daftar->harga_jual_3; ?>" id="hj3_<?php echo $nomor; ?>">
          </div>
          <div class="normal_bahan normal_bahan_<?php echo $nomor; ?>" id="thj3_<?php echo $nomor; ?>">
            <?php echo format_rupiah($daftar->harga_jual_3); ?>
          </div>
        </td>
        <td align="right"><?php echo format_rupiah($daftar->harga_beli_akhir); ?></td>
        <td><?php echo $daftar->satuan_pembelian; ?></td>
        <td><?php echo $daftar->satuan_stok; ?></td>
        <td style="display:none;"><?php echo $daftar->jumlah_dalam_satuan_pembelian; ?></td>
        <td><?php echo $daftar->stok_minimal; ?></td>
        <td><?php echo $daftar->real_stock; ?></td>
        <td><?php echo $daftar->nama_supplier; ?></td>
        <td>
          <div class="edit_bahan edit_bahan_<?php echo $nomor; ?>">
            <button key="<?php echo $nomor; ?>" data-toggle="tooltip" title="Simpan" class="btn btn-circle blue simpan_hj"><i class="fa fa-save"></i> Simpan</button>
          </div>
          <div class="normal_bahan normal_bahan_<?php echo $nomor; ?>">
            <?php echo get_detail_edit_delete_string($daftar->id); ?>
          </div>
        </td>
      </tr>
      <?php $nomor++; } ?>
    </tbody>
    <tfoot>
      <tr>
       <th>No</th>
       <th>Kode Produk</th>
       <th>Nama Produk</th>
       <th style="display:none;">Kategori Produk</th>
       <th>Unit</th>
       <th>Block</th>
       <th>HPP</th>
       <th>Harga Jual 1</th>
       <th>Harga Jual 2</th>
       <th>Harga Jual 3</th>
       <th>Harga Beli</th>
       <th>Satuan Pembelian</th>
       <th>Satuan Stok</th>
       <th style="width:50px;display:none;">Isi Dalam 1 <br>(Satuan Pembelian)</th>
       <th>Stok Minimal</th>
       <th>Real Stock</th>
       <th>Supplier</th>
       <th>Action</th>
     </tr>
   </tfoot>
 </table>
 <br><br><br><br><br><br><br><br>
 <br><br><br><br><br><br><br><br>
 <?php 
 if(@$data['kategori']){
  $kategori = $data['kategori'];
  $this->db->where('kode_kategori_produk',$kategori);
}
if(@$data['nama_produk']){
  $produk = $data['nama_produk'];
  $this->db->like('nama_bahan_baku',$produk,'both');
}
$get_jumlah = $this->db->get_where('master_bahan_baku', array('kode_unit' => $param));
$jumlah = $get_jumlah->num_rows();
$jumlah = floor($jumlah/100);
?>
<input type="hidden" class="form-control rowcount" value="<?php echo $jumlah ?>">
<input type="hidden" class="form-control pagenum" value="0">
<script type="text/javascript">
  $('.simpan_hj').on('click', function(event) {
    $('.table_bahan').removeClass('danger');
    key = $(this).attr('key');
    id = $("#id_"+key).val();
    harga_jual_1 = $("#hj1_"+key).val();
    harga_jual_2 = $("#hj2_"+key).val();
    harga_jual_3 = $("#hj3_"+key).val();
    $.ajax({
      url: '<?php echo base_url().'master/bahan_baku/edit_harga_jual'; ?>',
      type: 'POST',
      data: {id:id,harga_jual_1:harga_jual_1,harga_jual_2:harga_jual_2,harga_jual_3:harga_jual_3},
      dataType: 'JSON',
      success: function(data) {
        $('.edit_bahan').hide();
        $('.normal_bahan').show();
        $("#hj1_"+key).val(data.harga_jual_1);
        $("#thj1_"+key).text(toRp(data.harga_jual_1));
        $("#hj2_"+key).val(data.harga_jual_2);
        $("#thj2_"+key).text(toRp(data.harga_jual_2));
        $("#hj3_"+key).val(data.harga_jual_3);
        $("#thj3_"+key).text(toRp(data.harga_jual_3));
        $('#table_bahan_'+key).addClass('success')
        setTimeout(function(){$('#table_bahan_'+key).removeClass('success');},3000);
      }
    });
  });
  $('.table_bahan').on('dblclick', function(event) {
    $(this).addClass('danger');
    key = $(this).attr('key');
    $('.edit_bahan').hide();
    $('.normal_bahan').show();
    $('.edit_bahan_'+key).show();
    $('.normal_bahan_'+key).hide();
  });
</script>