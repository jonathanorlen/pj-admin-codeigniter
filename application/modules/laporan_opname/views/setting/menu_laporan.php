
<div class="row">
  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <a class="dashboard-stat dashboard-stat-light blue-soft" id="stok_opname">
      <div class="visual">
        <i class="glyphicon glyphicon-taskss" ></i>
      </div>
      <div class="details" >
        <div class="number">

        </div>
        <div class="desc">
        Laporan Opname
        </div>
      </div>
    </a>
  </div>
  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <a class="dashboard-stat dashboard-stat-light red-soft"  id="spoil" >
      <div class="visual">
        <i class="glyphicon glyphicon-taskss" ></i>
      </div>
      <div class="details">
        <div class="number">

        </div>
        <div class="desc">
          Laporan Spoil
        </div>
      </div>
    </a>
  </div>

</div>
<!-- END DASHBOARD STATS -->


  <script type="text/javascript">

    $(document).ready(function(){


      $("#stok_opname").click(function(){
        $('.tunggu').show();
        window.location = "<?php echo base_url() . 'laporan_opname/daftar' ?>";
      });


      $("#material").click(function(){
        $('#modal-confirm').modal('show');
      });

      $("#spoil").click(function(){
        window.location = "<?php echo base_url() . 'laporan_opname/daftar_spoil' ?>";
      });

      $("#user").click(function(){
       $('.tunggu').show();
       window.location = "<?php echo base_url() . 'master/user/' ?>";
     });

      $("#jabatan").click(function(){
       $('.tunggu').show();
       window.location = "<?php echo base_url() . 'master/jabatan/' ?>";
     });

      $("#supplier").click(function(){
       $('.tunggu').show();
       window.location = "<?php echo base_url() . 'master/supplier/' ?>";
     });
      $("#barang").click(function(){
       $('.tunggu').show();
       window.location = "<?php echo base_url() . 'master/barang/' ?>";
     });

    });
  </script>
