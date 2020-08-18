<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Daftar Omset
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
        <?php

        $get_pemasukan = $this->db->get('keuangan_keluar');
        $hasil_pemasukan = $get_pemasukan->result();
        ?>

        <div class="box-body">            
          <div class="sukses" ></div>
          <form id="pencarian_form" method="post" style="margin-left: 18px;" class="form-horizontal" target="_blank">
                           <div class="row">
                            <div class="col-md-5" id="">
                              <div class="input-group">
                                <span class="input-group-addon">Tanggal Awal</span>
                                <input type="text" class="form-control tgl" id="tgl_awal">
                              </div>
                            </div>

                            <div class="col-md-5" id="">
                              <div class="input-group">
                                <span class="input-group-addon">Tanggal Akhir</span>
                                <input type="text" class="form-control tgl" id="tgl_akhir">
                              </div>
                            </div>                        
                            <div class="col-md-2 pull-left">
                               <a class="btn btn-success" onclick="cari_omset()"><i class="fa fa-search"></i> Cari</a>
                            </div>
                          </div>




                         

                          <br>

                          
                        </form>
          <div id="omset">
          
          </div>


    </div>

    <!------------------------------------------------------------------------------------------------------>

  </div>
</div>
</div><!-- /.col -->
</div>
</div>    
</div>  
<script src="<?php echo base_url().'component/lib/jquery.min.js'?>"></script>
<script src="<?php echo base_url().'component/lib/zebra_datepicker.js'?>"></script>
<link rel="stylesheet" href="<?php echo base_url().'component/lib/css/default.css'?>"/>
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
            window.location = "<?php echo base_url().'analisa'; ?>";
          });
        </script>

<script>
function cari_omset(){
    var tgl_awal =$("#tgl_awal").val();
    var tgl_akhir =$("#tgl_akhir").val();
    var petugas = $("#nama_petugas").val();
    $.ajax( {  
        type :"post",  
        url : "<?php echo base_url().'omset/search_omset'; ?>",  
        cache :false,
        data : {tgl_awal:tgl_awal,tgl_akhir:tgl_akhir,petugas:petugas},
        beforeSend:function(){
          $(".tunggu").show();  
        },
 success : function(data) {
             $("#omset").html(data);
              $(".tunggu").hide();  
        },  
        error : function(data) {  
          alert("das");  
        }  
      });
}

     
$(document).ready(function(){
  $('#tabel_daftar').dataTable({
        "paging":   false,
        "info":     false
      });

       $('.tgl').Zebra_DatePicker({});
})
   
</script>

