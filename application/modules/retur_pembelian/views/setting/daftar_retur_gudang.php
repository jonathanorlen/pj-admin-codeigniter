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
          Serve
        </div>
      </div>
    </a>
  </div>  
  <div class="col-xs-12">
    <!-- /.box -->
    

    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Retur Pembelian Gudang
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
          <a style="padding:13px; margin-bottom:10px;" class="btn btn-app green" href="<?php echo base_url().'stok/gudang'; ?>"><i class="fa fa-edit"></i> Stok </a>
    <a style="padding:13px; margin-bottom:10px;" class="btn btn-app blue" href="<?php echo base_url().'spoil/gudang/01'; ?>"><i class="fa fa-edit"></i> Spoil </a>
    <a style="padding:13px; margin-bottom:10px;" class="btn btn-app red" href="<?php echo base_url().'retur_pembelian/gudang'; ?>"><i class="fa fa-edit"></i> Retur </a>
          <table class="table table-striped table-hover table-bordered" id="sample_editable_1"  style="font-size:1.5em;">
            <thead>
              <tr>
                <th width="50px;">No</th>
                <th>No Transaksi</th>
                <th>Nama Anggota</th>
                <th>Kelompok</th>
                <th>Status</th>

                <th width="133px;">Action</th>
              </tr>
            </thead>
            <tbody>
              
            </tbody>                
          </table>

          
        </div>
        
        <!------------------------------------------------------------------------------------------------------>

      </div>
    </div>
  </div><!-- /.col -->
</div>
</div>    
</div>  
<style type="text/css" media="screen">
        .btn-back
          {
            position: fixed;
            bottom: 10px;
             left: 10px;
            z-index: 999999999999999;
                vertical-align: middle;
                cursor:pointer
          }
        </style>
                <img class="btn-back" src="<?php echo base_url().'component/img/back_icon.png'?>" style="width: 70px;height: 70px;">

        <script>
          $('.btn-back').click(function(){
$(".tunggu").show();
            window.location = "<?php echo base_url().'stok/gudang'; ?>";
          });
        </script>


<script>
  $(document).ready(function() {
    $("#gudang").click(function(){
                              window.location = "<?php echo base_url() . 'stok/gudang' ?>";

                            });

                            $("#bar").click(function(){
                              window.location = "<?php echo base_url() . 'stok/bar' ?>";
                            });

                            $("#kitchen").click(function(){
                              window.location = "<?php echo base_url() . 'stok/kitchen' ?>";
                            });

                            $("#serve").click(function(){
                              window.location = "<?php echo base_url() . 'stok/serve' ?>";
                            });
    setTimeout(function(){
      $("#lalal").fadeIn('slow');
    }, 1000);
    $("a#hapus").click( function() {    
      var r =confirm("Anda yakin ingin menghapus data ini ?");
      if (r==true)  
      {
        $.ajax( {  
          type :"post",  
          url :"<?php echo base_url() . 'anggota/hapus' ?>",  
          cache :false,  
          data :({key:$(this).attr('key')}),
          beforeSend:function(){
          $(".tunggu").show();  
        },
 success : function(data) { 
            $(".sukses").html(data);   
            setTimeout(function(){$('.sukses').html('');window.location = "<?php echo base_url() . 'anggota/daftar' ?>";},1500);              
          },  
          error : function() {  
            alert("Data gagal dimasukkan.");  
          }  
        });
        return false;
      }
      else {}        
    });

    $('#tabel_daftar').dataTable();
  } );
  setTimeout(function(){
    $("#lalal").css("background-color", "white");
    $("#lalal").css("transition", "all 3000ms linear");
  }, 3000);

</script>

