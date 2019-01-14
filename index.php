<?php
// Include the database configuration file
require 'dbconnect.php';

function categoryTree($parent_id = 0, $sub_mark = ''){
    global $db;
    $query = $db->query("SELECT * FROM categories WHERE parent_id = $parent_id ORDER BY name ASC");
    if($query->num_rows > 0){
        while($row = $query->fetch_assoc()){
            echo '<option value="'.$row['id'].'">'.$sub_mark.$row['name'].'</option>';
            categoryTree($row['id'], $sub_mark.'---');
        }
    }
}
function categoryTreeshow($parent_id = 0, $sub_mark = ''){
    global $db;
    $query = $db->query("SELECT * FROM categories WHERE parent_id = $parent_id ORDER BY name ASC");
    if($query->num_rows > 0){
        while($row = $query->fetch_assoc()){
            echo $sub_mark.$row['name'];
            categoryTree($row['id'], $sub_mark.'---');
        }
    }
}
function getCat($get){
    global $db;
    $a = $db->query("SELECT cat_num FROM categories WHERE id = '$get'");
    if($a = null)
    {
    return 0;
    } else {
        return $a;
    }
    }


?>
<head>
  <title>Recursive tree</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <style>
  div.ex1 {
  width: 300px;
  margin: auto;
  border: 3px solid #73AD21;
}
div.ex2 {
  width: 300px;
  border: 3px solid #73AD21;
  align:left;
}
  </style>
</head>
<body>
<h1 align="center">Recursive tree</h1>
<div class="ex2" align="left">
<a href="iterative.php" class="btn btn-secondary btn-md form-control mt-2" role="button" aria-pressed="true">Iterative</a>
</div>
<table class="table table-striped"  align="center" style="width:50%">                     
        <thead>
            
            <tr>
              <th><?php categoryTreeshow(); ?></th>
            </tr>
        </thead>
        </table>

<form method='post'>
<div class="ex1">
      <div class="row-xs-1" align="center">
          <label for="category">Category</label>
          <select name="category">
          <option value="0">New category</option>
    <?php categoryTree(); ?>
</select>
</div>
          <label for="name">Title</label>
    <input type="text" class="form-control" id="name" name="name"><hr>

          <button name="submit" type="submit" class="btn btn-default">Accept</button>
          </div>
          </div>
     </form>
     </body>
     <?php 
	$date = date('Y-m-d H:i:s');
				if($_POST !=null){
                $parent_id = $_POST['category'];
                $name = $_POST['name'];}               
else {die ("");}
$num = getCat($parent_id);


          $sql = "INSERT INTO categories (parent_id, name, created, cat_num) 
            VALUES ('$parent_id', '$name', '$date', '$num')";
 if (mysqli_query($db, $sql)) echo "Įrašyta sėkmingai!";
else die ("Klaida:" .mysqli_error($db));
			
	?>