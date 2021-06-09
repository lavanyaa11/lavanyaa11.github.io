<?php
include 'config.php';

if(isset($_POST['submit']))
{
    $from = $_GET['id'];
    $toUser = $_POST['to'];
    $amnt = $_POST['amount'];

    $sql = "SELECT * from users where id=$from";
    $query = mysqli_query($conn,$sql);
    $sql1 = mysqli_fetch_array($query); 

    $sql = "SELECT * from users where id=$toUser";
    $query = mysqli_query($conn,$sql);
    $sql2 = mysqli_fetch_array($query);

  
 if($amnt > $sql1['Balance'])
    {

        echo '<script type="text/javascript">';
        echo ' alert("Insufficient Balance")';  
        echo '</script>';
    }

     else if($amnt == 0){
         echo "<script type='text/javascript'>alert('Enter Amount Greater than Zero');
    </script>";
     }
    else {

      
        $newCredit = $sql1['Balance'] - $amnt;
        $sql = "UPDATE users set Balance=$newCredit where id=$from";
        mysqli_query($conn,$sql);



        $newCredit = $sql2['Balance'] + $amnt;
        $sql = "UPDATE users set Balance=$newCredit where id=$toUser";
        mysqli_query($conn,$sql);

        $sender = $sql1['Name'];
        $receiver = $sql2['Name'];
        $sql = "INSERT INTO transaction(`sender`, `receiver`, `Balance`) VALUES ('$sender','$receiver','$amnt')";
        $query=mysqli_query($conn,$sql);
        if($query){
           echo "<script type='text/javascript'>
                    alert('Transaction Successful !!');
                    window.location='history.php';
                </script>";
        }
        $newCredit= 0;
        $amnt =0;
    }

}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Transfer Credits</title>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>
    
    .button {
      background-color: #0b2d4e;
      border: none;
      color: white;
      padding: 10px 20px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 18px;
      margin: 0px 2px;
      border-radius: 5px;
    }
    .button:hover{
      background-color: #7cafe1;
      color: #10002b;
    }
    .button:active{
      background-color: #2ec4b6;
    }
    h2{
      text-align: center;
      margin-top: 15px;
    }
	.form-control{
	color:black;
	}
	.form-control.hover{
		color:black;
	}

  h2{
font-family: sans-serif;
color: #03045e;
font-weight: bold;
}
th, td{
    font-family: opensans;
    font-size: 18px;
    font-weight: 20pt;
}
label {
    font-family: opensans;
    font-weight: bold;
    color: #293d3d;
    font-size: 20px;
}

body {
    background-color: white;
}

    </style>
</head>


<body>
</header>

    <div class="container divStyle">
        <h2>Transaction</h2>
       
            <?php
                include 'config.php';
                $sid=$_GET['id'];
                $sql = "SELECT * FROM  users where id=$sid";
                $query=mysqli_query($conn,$sql);
                if(!$query)
                {
                    echo "Error ".$sql."<br/>".mysqli_error($conn);
                }
                $rows=mysqli_fetch_array($query);
            ?>
            <form method="post" name="tcredit" class="tabletext" ><br/>
        <label> SENDER </label><br/>
        <div>
            <table class="table roundedCorners  tabletext table-hover  table-condensed"  >
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Account Balance</th>
                </tr>
                <tr>
                    <td><?php echo $rows['id'] ?></td>
                    <td><?php echo $rows['Name'] ?></td>
                    <td><?php echo $rows['Email'] ?></td>
                    <td><?php echo $rows['Balance'] ?></td>
                </tr>
            </table>
        </div>
        <br/>
        <label> RECEIVER </label>
        <select class=" form-control"   name="to" style="margin-bottom:5%;" required>
            <option value="" disabled selected> </option>
            <?php
                include 'config.php';
                $sid=$_GET['id'];
                $sql = "SELECT * FROM users where id!=$sid";
                $query=mysqli_query($conn,$sql);
                if(!$query)
                {
                    echo "Error ".$sql."<br/>".mysqli_error($conn);
                }
                while($rows = mysqli_fetch_array($query)) {
            ?>
                <option class="table text-center table-striped " value="<?php echo $rows['id'];?>" >

                    <?php echo $rows['Name'] ;?>
                    <!--(Credits:
                    <?php echo $rows['Balance'] ;?> )-->

                </option>
            <?php
                }
            ?>
        </select>
            <label> ENTER THE AMOUNT TO TRANSFER </label>
            <input type="number" id="amm" class="form-control" name="amount" min="0" required  />  <br/><br/>
                <div class="text-center btn3" >
            <button class="button" name="submit" type="submit" id="myBtn" style="margin:8px;">TRANSFER</button>
            <button class="button" name="reset" type="reset" id="myBtn" style="margin:8px;">RESET</button>
            </div>
        </form>
    </div>



<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>