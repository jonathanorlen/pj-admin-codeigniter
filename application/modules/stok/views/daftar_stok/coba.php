

<form method="get">
  <a class="btn btn-app blue" id="upload_foto">
                    <i class="fa fa-edit"></i> Image Product
                  </a>
                </div>
                <div class="box_upload"></div>
                <div class="foto_upload"></div>

                <br>
                <input type="submit" value="simpan">
</form>

<script>
  
    $("#upload_foto").click( function() {    
      $.ajax( {  
        type :"post",  
        url : "<?php echo base_url() . 'component/upload/foto' ?>",  
        cache :false,  
        data :$(this).serialize(),
        beforeSend:function(){
          $(".tunggu").show();  
        },
 success : function(data) {  
          $(".box_upload").html(data);           
        },  
        error : function() {  
          alert("Data gagal dimasukkan.");  
        }  
      });
      return false;                          
    });   
</script>