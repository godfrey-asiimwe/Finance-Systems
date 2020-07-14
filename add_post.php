<?php

include ('DB.php');
require_once ("Class/DB.class.php");
require_once ("Class/Organisation.class.php");

if(isset($_POST['name'])){

	$name =$_POST['name'];
	$desc=$_POST['desc'];

	$time=time();
	$date2=date("Y-m-d",$time);

	$no=uniqid();

	$organisation = new Organisation();
	$insertId = $organisation->addOrganisation($date2,$no,$name,$desc);

}
?>		

<?php
	if(isset($_POST['res'])){
	?>
	<?php
		$query=mysqli_query($con,"SELECT * FROM organisation ORDER BY id") or die(mysqli_error());
		while($row=mysqli_fetch_array($query)){
	?>	
	<tr>
		<td>
            <?php echo $row["name"]; ?>
          </td>
          <td>
            <?php echo $row["des"]; ?>
          </td>
          <td>
            <a class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="Edit" href=""><i class="fas fa-pencil-alt"></i></a>
            <a href="" class="btn btn-danger btn-action" data-toggle="tooltip" title="Delete"  data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="alert('Deleted')"><i class="fas fa-trash"></i></a>
        </td>
    </tr>
	<?php
		}
	}	
?>
