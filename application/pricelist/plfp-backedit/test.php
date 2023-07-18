<?php
  
  echo "<pre>";
  print_r ($_SESSION);
  echo "</pre>";
  
?>
<!DOCTYPE html>
<html>
<head>
  <script src="https://code.jquery.com/jquery.min.js" type="text/javascript"></script>
  <script>tinymce.init({ selector:'textarea' });</script>
</head>
<body>
  <form enctype="multipart/form-data" method="POST">
  	<input type="file" name="up_file" id="up_file" />
    <input type="button" value="Upload" name="upload" id="upload">
  </form>
<script>
	$('#upload').on('click', function(){
        var file = $('#up_file')[0].files[0];

        var form_data = new FormData();
        form_data.append('file', file);

        $.ajax({
            url : 'upload.php',
            type : 'POST',
            cache : false,
            data : form_data,
            processData : false,
            contentType : false,
            dataType : 'text',
            success : function(){
                alert('Upload sukses !');
            }
        });

    }); 
</script>
</body>
</html>
