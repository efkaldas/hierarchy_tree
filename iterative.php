
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
function getCat($get){
    global $db;
    $a = $db->query("SELECT cat_num FROM categories WHERE id = $get");
    $row = $a->fetch_assoc();
    $b = $row['cat_num'];
    $b = $b + 1;
    if($row['cat_num'] = null)
    {
    return 0;
    } else {
        return $b;
    }
    }
function categoryTreeshow(){
    global $db;
    $query = $db->query("SELECT * FROM categories");
   $sub_mark = '';
   if($query->num_rows > 0){
    while($row = $query->fetch_assoc()){
        $id = $row['parent_id'];
        $sub_mark = '---';
            if($row['parent_id'] > 0)
            {
            $query2 = $db->query("SELECT * FROM categories WHERE id = $id ORDER BY name ASC");
            while($row2 = $query2->fetch_assoc())
            {
                if($row2['parent_id'] > 0)
                {
                    $sub_mark = '';
                    for ($i = 0; $i < $row2['cat_num']; $i++)
                    {
                    $sub_mark = $sub_mark . "---";
                    }
                    echo '<tr><th>' . $sub_mark.$row['name'] . '</tr></th>';
                } else {                    
                    echo '<tr><th>' . $sub_mark.$row['name'] . '</tr></th>';
                }
                
            }
        } else {
                echo '<tr><th>' . $row['name'] . '</tr></th>';
            }
        
    }

    }

}
?>
<head>
  <title>Iterative tree</title>
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
<h1 align="center">Iterative tree</h1>
<div class="ex2" align="left">
<a href="index.php" class="btn btn-secondary btn-md form-control mt-2" role="button" aria-pressed="true">Back to recursive</a>
</div>
<table class="table table-striped"  align="center" style="width:50%">                     
        <thead>
            

              <?php categoryTreeshow(); ?>

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
                $name = $_POST['name'];
                }
else {die ("");}
$num = getCat($parent_id);


          $sql = "INSERT INTO categories (parent_id, name, created, cat_num) 
            VALUES ('$parent_id', '$name', '$date', '$num')";
 if (mysqli_query($db, $sql)) echo "Įrašyta sėkmingai!";
else die ("Klaida:" .mysqli_error($db));
			
	?>