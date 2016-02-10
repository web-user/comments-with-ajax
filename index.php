<?php

// Сообщение об ошибке:
error_reporting(E_ALL^E_NOTICE);

include "connect.php";
include "comment.class.php";



$comments = array();
$result = mysql_query("SELECT * FROM comments ORDER BY id ASC");

while($row = mysql_fetch_assoc($result))
{
	$comments[] = new Comment($row);
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<title>AJAX</title>

<link rel="stylesheet" type="text/css" href="styles.css" />
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
<script src="js/jquery.min.js"></script>
<script src="js/jquery.wallform.js"></script>
<script>
 $(document).ready(function() { 
        
            $('#photoimg').die('click').live('change', function()           { 
                       //$("#preview").html('');
                
                $("#imageform").ajaxForm({target: '#preview', 
                     beforeSubmit:function(){ 
                    
                    console.log('ttest');
                    $("#imageloadstatus").show();
                     $("#imageloadbutton").hide();
                     }, 
                    success:function(){ 
                    console.log('test');
                     $("#imageloadstatus").hide();
                     $("#imageloadbutton").show();
                    }, 
                    error:function(){ 
                    console.log('xtest');
                     $("#imageloadstatus").hide();
                    $("#imageloadbutton").show();
                    } }).submit();
                    
        
            });
        }); 
</script>

<style>

body
{
font-family:arial;
}

#preview
{
color:#cc0000;
font-size:12px
}
.imgList 
{
max-height:150px;
margin-left:5px;
border:1px solid #dedede;
padding:4px;    
float:left; 
}

</style>


<div class="container">
 <div class="jumbotron">
         <h1>Ajax comment</h1>
       </div>

       <div id="addCommentContainer" class="col-md-6 col-md-offset-3">
           <p>Добавить комментарий</p>
           <form id="imageform" method="post" enctype="multipart/form-data" action='ajaxImageUpload.php'>
               <div>
                   <label for="name">ФИО</label>
                   <input type="text" class="form-control" name="name" id="name" />
                   
                   <label for="email">Email</label>
                   <input type="text" class="form-control" name="email" id="email" />
                   
                   <label for="url">Tелефон</label>
                   <input type="text" class="form-control" name="phone" id="phone" />


                   Upload image:
                   <div id='imageloadstatus' style='display:none'><img src="loader.gif" alt="Uploading...."/></div>
                   <div id='imageloadbutton'>
                   <input type="file" name="photos[]" id="photoimg" multiple="true" />
                   </div>

                   
                   <label for="body">The content of the comment</label>
                   <textarea name="body" class="form-control" id="body" cols="20" rows="5"></textarea>
                   
                   <input type="submit" id="submit2" class="submit btn btn-primary" value="Submit" />
               </div>
           </form>
       </div>
    <div id="main" class="col-md-6 col-md-offset-3">

    <div id="newcoment">
        
    </div>


    <?php

    /*
    /	Вывод комментариев один за другим:
    */

    foreach($comments as $c){
    	echo $c->markup();
    }

    ?>


    </div>

</div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="script.js"></script>


</body>
</html>
