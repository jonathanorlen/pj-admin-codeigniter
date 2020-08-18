<div class="">
  <div class="page-content">

    <div class="row">
      <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-light blue-soft" id="tambahkannya">
          <div class="visual">
            <i class="fa fa-comments"></i>
          </div>

          <div class="details">
            <div class="number">
             Tambahkan
           </div>
           <div class="desc">

           </div>
         </div>
       </a>
     </div>

     <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <a class="dashboard-stat dashboard-stat-light blue-soft" id="daftarnya">
        <div class="visual">
          <i class="fa fa-comments"></i>
        </div>

        <div class="details">
          <div class="number">
           Daftar
         </div>
         <div class="desc">

         </div>
       </div>
     </a>
   </div>


   <div id="box_load"></div>

 </div>

 <script>
 $(document).ready(function(){

  $("#tambahkannya").click(function(){
    $.ajax( {  
      type :"post",  
      url : "<?php echo base_url() . 'cooling_unit/add' ?>",          
      cache :false,  
      data :$(this).serialize(),
      beforeSend:function(){
          $(".tunggu").show();  
        },
 success : function(data) {  
        $("#box_load").html(data);             
      },  
      error : function() {  
        alert("Data gagal dimasukkan.");  
      }  
    });
    return false;                
  });

  $("#daftarnya").click(function(){
    $.ajax( {  
      type :"post",  
      url : "<?php echo base_url() . 'cooling_unit/daftar' ?>",          
      cache :false,  
      data :$(this).serialize(),
      beforeSend:function(){
          $(".tunggu").show();  
        },
 success : function(data) {  
        $("#box_load").html(data);             
      },  
      error : function() {  
        alert("Data gagal dimasukkan.");  
      }  
    });
    return false;                
  });

});
 </script>
