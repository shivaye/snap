<?php
  @extract($_POST);
  $folder_name = "temp-img";
  
//Delete single file   
$del_img = @$_GET['img'];
if(isset($del_img) and !empty($del_img)){
    $path = $folder_name."/".urldecode($del_img);
    @unlink($path);
    echo "<script>window.location.href='img.php';</script>";
}


//Delete All files
 $del_multi_img = @$_GET['del_multi_img'];
if(isset($del_multi_img) and !empty($del_multi_img)){
  
$files = glob($folder_name . '/*');
 
foreach($files as $file){ 
    if(is_file($file)){ 
        @unlink($file);
    }
}
 echo "<script>window.location.href='img.php';</script>";
}


//media upload files
if(isset($upload_media)){
$error=array();
$extension=array("jpeg","jpg","png","gif");
foreach($_FILES["files"]["tmp_name"] as $key=>$tmp_name) {
    $file_name=$_FILES["files"]["name"][$key];
    $file_tmp=$_FILES["files"]["tmp_name"][$key];
    $ext=pathinfo($file_name,PATHINFO_EXTENSION);
    $upload_path = $folder_name."/".$file_name;
 
    if(in_array($ext,$extension)) { 
            move_uploaded_file($_FILES["files"]["tmp_name"][$key],$upload_path);
        
    }
    else {
        array_push($error,"$file_name, ");
    }
}
 echo "<script>window.location.href='img.php';</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Upload Image</title>
  <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
  
</head>
<body>
    <div class="container">
        <div class="panel panel-info">
            <div class="panel-heading">Upload Media</div>
    <div class="panel-body">
    <form action="img.php" method="post" enctype="multipart/form-data"> 
    <div class="form-group">
             <label>Select Photo (one or multiple):</label>
             <input type="file" required class="form-control" name="files[]" multiple/> 
         <small>Note: Supported image format: .jpeg, .jpg, .png, .gif</small> 
         <input type="submit" value="Submit" class="btn btn-info btn-block" name="upload_media"/> 
         </div>
</form>
</div>
</div>
       <div class="panel panel-info">
            <div class="panel-heading">All Media Images <a class="pull-right btn btn-info btn-xs del_class" href="javascript:;">Remove All Files</a></div>
    <div class="panel-body"> 
    <table id="table_id" class="display">
    <thead>
        <tr>
            <th>Sr</th>
            <th>Image View</th>
            <th>Image Url</th>
            <th>Action</th>
            
        </tr>
    </thead>
    <tbody>
        <?php
      
$files = scandir ($folder_name,1);
for ($i = 0; $i < count($files); $i++) {
    $image = $files[$i];
    $supported_file = array('gif','jpg','jpeg','png');

    $ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
    if (in_array($ext, $supported_file)) { ?>
       <tr>
           <td><?php echo $i+1; ?></td>
            
          
           <td> 
       <img src="<?php echo $folder_name."/".$image; ?>" alt="<?php echo $image;?>" width="50px" height="50px" />
       </td>
       <td><?php echo 'http://localhost/mix-mobile/'.$folder_name."/".$image;?></td>
       <td><a class="btn btn-info" href="img.php?img=<?php echo urlencode($image);?>">Delete File</a></td>
   </tr> 
     <?php }  
}
?>
         
    </tbody>
</table>
</div>
</div>
</div>
<script
  src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
  integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8="
  crossorigin="anonymous"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
<script>
    $(document).ready( function () {
        $('#table_id').DataTable();
} );

 $(document).on('click','.del_class',function(){
     if(confirm('Are you Sure you want to delete')==true){
         window.location.href='img.php?del_multi_img=1';
     }else{
         return false;
     }
 })
</script>
</body>
</html>