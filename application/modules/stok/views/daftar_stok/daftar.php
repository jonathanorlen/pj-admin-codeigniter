<?php 
$get_position = $this->uri->segment(2);
$position = ucwords($get_position);
?>
<div class="row">      
  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <a class="dashboard-stat dashboard-stat-light blue-soft" id="gudang">
      <div class="visual">
        <i class="glyphicon glyphicon-tasks" ></i>
      </div>
      <div class="details" >
        <div class="number">

        </div>
        <div class="desc">
          Gudang
        </div>
      </div>
    </a>
  </div>
  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <a class="dashboard-stat dashboard-stat-light red-soft"  id="kitchen">
      <div class="visual">
        <i class="glyphicon glyphicon-shopping-cart"></i>
      </div>
      <div class="details">
        <div class="number">

        </div>
        <div class="desc">
          Kitchen
        </div>
      </div>
    </a>
  </div>
  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <a class="dashboard-stat dashboard-stat-light green-soft"  id="bar">
      <div class="visual">
        <i class="glyphicon glyphicon-shopping-cart"></i>
      </div>
      <div class="details">
        <div class="number">

        </div>
        <div class="desc">
          Bar
        </div>
      </div>
    </a>
  </div>
  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <a class="dashboard-stat dashboard-stat-light purple-soft"  id="serve">
      <div class="visual">
        <i class="glyphicon glyphicon-shopping-cart"></i>
      </div>
      <div class="details">
        <div class="number">

        </div>
        <div class="desc">
          Server
        </div>
      </div>
    </a>
  </div>
  <div class="col-xs-12">
    <!-- /.box -->
   
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Stok <?php echo $position; ?>
        </div>
        <div class="tools">
          <a href="javascript:;" class="collapse">
          </a>
          <a href="javascript:;" class="reload">
          </a>

        </div>
      </div>
      <div class="portlet-body">
        <!------------------------------------------------------------------------------------------------------>


        <div class="box-body">            
          <div class="sukses" ></div>
           <a style="padding:13px; margin-bottom:10px;width: 100px" class="btn btn-app green" href="<?php echo base_url().'stok/'.$position; ?>"><i class="fa fa-edit"></i> Stok </a>
    <a style="padding:13px; margin-bottom:10px;width: 100px" class="btn btn-app blue" href="<?php echo base_url().'spoil/'.$position; ?>"><i class="fa fa-edit"></i> Spoil </a>
    <!-- <a style="padding:13px; margin-bottom:10px;" class="btn btn-app red" href="<?php echo base_url().'retur_pembelian/'.$position; ?>"><i class="fa fa-edit"></i> Retur </a> -->
    <a style="padding:13px; margin-bottom:10px;width: 100px" class="btn btn-app red" href="<?php echo base_url().'mutasi/'.$position; ?>"><i class="fa fa-edit"></i> Mutasi </a>
    <a style="padding:13px; margin-bottom:10px;width: 100px" class="btn btn-warning" href="<?php echo base_url().'opname/'.$position; ?>"><i class="fa fa-edit"></i> Opname </a>
        <?php if($position=="Server"){
            
         ?>
         <table class="table table-striped table-hover table-bordered" id="tabel_daftar"  style="font-size:1.5em;">
            <thead>
              <tr>
               <th>No.</th>
              <th>Kode Barang</th>
              <th>Nama Barang</th>
              <th>Nama Rak</th>
              <th align="right">Real Stok</th>
              <th align="right">Stok Min</th>
              <th>HPP</th>
              <th>Aset</th>
              <th>Action</th>
            </tr>
            </thead>
            <tbody>
              <?php
              
              $get_master_barang = $this->db->get_where('master_barang',array('position'=>"U004"));
              $hasil_master_barang = $get_master_barang->result();

              $no = 1;
              foreach($hasil_master_barang as $item){
                if($this->session->flashdata('message')==$item->kode_barang){

                  echo '<tr id="warna" style="background: #88cc99; display: none;">';
                }
                else{
                  echo '<tr>';
                  $kode_bahan = $item->kode_barang; 
              $this->db->select_max('id');                       
              $get_kode_bahan = $this->db->get_where('transaksi_stok',array('kode_bahan'=>$kode_bahan,'jenis_transaksi'=>'pembelian'));
              $hasil_hpp_bahan = $get_kode_bahan->row();
              #echo $this->db->last_query();

              $get_hpp = $this->db->get_where('transaksi_stok',array('id'=>$hasil_hpp_bahan->id));
              $hasil_get_hpp = $get_hpp->row();

              $get_stok_min = $this->db->get_where('master_bahan_baku',array('id'=>$item->kode_barang));
              $hasil_stok_min = $get_stok_min->row();

                }
                ?>
                <td><?php echo $no;?></td>
                <td><?php echo $item->kode_barang; ?></td>                  
                <td><?php echo $item->nama_barang; ?></td>   
                <td><?php echo $item->nama_rak; ?></td>
                <td><?php echo $item->real_stok; ?></td>   
                <td><?php echo $item->stok_minimal." ",$item->satuan_stok; ?></td>
                 <td><?php echo format_rupiah(@$hasil_get_hpp->hpp);?></td>
                <td><?php echo format_rupiah((@$item->real_stok <= 0) ? (@$hasil_get_hpp->hpp * 0) : (@$hasil_get_hpp->hpp * $item->real_stok));?></td>
                <td align="center"><?php echo detail_stok($get_position,$item->kode_barang); ?></td>
              </tr>
              <?php
              $no++;
            } ?>
          </tbody>                
        </table>
         <?php } else { ?>
          <table class="table table-striped table-hover table-bordered" id="tabel_daftar"  style="font-size:1.5em;">
            <thead>
              <tr>
               <th>No.</th>
              <th>Kode Bahan</th>
              <th>Nama Bahan</th>
              <th>Nama Rak</th>
              <th align="right">Real Stok</th>
              <th align="right">Stok Min</th>
              <th>HPP</th>
              <th>Aset</th>
              <th>Action</th>
            </tr>
            </thead>
            <tbody>
              <?php
              
              $get_master_barang = $this->db->get_where('master_bahan_baku',array('nama_unit'=>$position));
              $hasil_master_barang = $get_master_barang->result();

              $no = 1;
              foreach($hasil_master_barang as $item){
                if($this->session->flashdata('message')==$item->kode_bahan_baku){

                  echo '<tr id="warna" style="background: #88cc99; display: none;">';
                }
                else{
                  echo '<tr>';
                }
                ?>
                <td><?php echo $no;?></td>
                <td><?php echo $item->kode_bahan_baku; ?></td>                  
                <td><?php echo $item->nama_bahan_baku; ?></td>   
                <td><?php echo $item->nama_rak; ?></td>
                <td><?php echo $item->real_stock; ?></td>   
                <td><?php echo $item->stok_minimal." ",$item->satuan_stok; ?></td>                
                <td><?php 
                $kode_bahan = $item->kode_bahan_baku; 
              $this->db->select_max('id');                       
              $get_kode_bahan = $this->db->get_where('transaksi_stok',array('kode_bahan'=>$kode_bahan,'jenis_transaksi'=>'pembelian'));
              $hasil_hpp_bahan = $get_kode_bahan->row();
              #echo $this->db->last_query();

              $get_hpp = $this->db->get_where('transaksi_stok',array('id'=>$hasil_hpp_bahan->id));
              $hasil_get_hpp = $get_hpp->row();

              $get_stok_min = $this->db->get_where('master_bahan_baku',array('id'=>$item->id));
              $hasil_stok_min = $get_stok_min->row();
                  echo format_rupiah(@$hasil_get_hpp->hpp);
                ?>
                </td>
                <td>
                <?php echo format_rupiah((@$item->real_stock <= 0) ? (@$hasil_get_hpp->hpp * 0) : (@$hasil_get_hpp->hpp * $item->real_stock));?>
                  
                </td>
               
               
                
                <td align="center"><?php echo detail_stok($get_position,$item->kode_bahan_baku); ?></td>
              </tr>
              <?php
              $no++;
            } ?>
          </tbody>                
        </table>

<?php } ?>
      </div>

      <!------------------------------------------------------------------------------------------------------>

    </div>
  </div>
</div><!-- /.col -->
</div>
</div>    
</div>  


<script>
  $(document).ready(function() {
    $("#tabel_daftar").dataTable({
    "paging":   false,
    "ordering": false,
    "info":     false
  });
  } );
    $("#gudang").click(function(){
      $('.tunggu').show();
                              window.location = "<?php echo base_url() . 'stok/gudang' ?>";

                            });

                            $("#bar").click(function(){
                              $('.tunggu').show();
                              window.location = "<?php echo base_url() . 'stok/bar' ?>";
                            });

                            $("#kitchen").click(function(){
                              $('.tunggu').show();
                              window.location = "<?php echo base_url() . 'stok/kitchen' ?>";
                            });

                            $("#serve").click(function(){
                              $('.tunggu').show();
                              window.location = "<?php echo base_url() . 'stok/server' ?>";
                            });

    setTimeout(function(){
      $("#warna").fadeIn('slow');
    }, 1000);
    $("a#hapus").click( function() {    
      var r =confirm("Anda yakin ingin menghapus data ini ?");
      if (r==true)  
      {
        $.ajax( {  
          type :"post",  
          url :"<?php echo base_url() . 'master/barang/hapus' ?>",  
          cache :false,  
          data :({key:$(this).attr('key')}),
          beforeSend:function(){
          $(".tunggu").show();  
        },
 success : function(data) { 
            $(".sukses").html(data);   
            setTimeout(function(){$('.sukses').html('');window.location = "<?php echo base_url() . 'master/barang/daftar' ?>";},1500);              
          },  
          error : function() {  
            alert("Data gagal dimasukkan.");  
          }  
        });
        return false;
      }
      else {}        
    });

                           
  
  setTimeout(function(){
    $("#warna").css("background-color", "white");
    $("#warna").css("transition", "all 3000ms linear");
  }, 3000);

</script>

