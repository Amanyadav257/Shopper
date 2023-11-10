<?php 

 include('../includes/connect.php');
 include('../functions/common_function.php');

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignUp</title>
      <!-----------------------------------------------------------------Bootstrap css link --------------------------------------------------->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">


</head>
<body>
    
    <div class="container-fluid my-3">
        <h2 class="text-center">New User Registration</h2>
        <div class="row d-flex align-items-center justify-content-center">
            <div class="col-lg-12 col-xl-6">
                <form action="" method="post" enctype="multipart/form-data">

                    <!-------------------------------------------------------------------- Username field ------------------------------------->
                        <div class="form-outline mb-4">
                            <label for="user_name" class="form-label">Username<span class="text-danger">*</span></label>
                            <input type="text" id="user_name" class="form-control " placeholder="Enter your Username" 
                            autocomplete="off" required="required" name="user_name">
                        </div>

                         <!-------------------------------------------------------------------- Email field ----------------------------------->
                         <div class="form-outline mb-4">
                            <label for="user_email" class="form-label">Email<span class="text-danger">*</label>
                            <input type="email" id="user_email" class="form-control " placeholder="Enter your Email" 
                            autocomplete="off" required="required" name="user_email">
                        </div>
                        
                         <!-------------------------------------------------------------------- image field ----------------------------------->
                         <div class="form-outline mb-4">
                            <label for="user_image" class="form-label">Image</label>
                            <input type="file" id="user_image" class="form-control " name="user_Image">
                        </div>

                         <!--------------------------------------------------------------------Password field ----------------------------------->
                         <div class="form-outline mb-4">
                            <label for="user_password" class="form-label">Password<span class="text-danger">*</label>
                            <input type="password" id="user_password" class="form-control " placeholder="Enter your Password" 
                            autocomplete="off" required="required" name="user_password">
                        </div>

                         <!--------------------------------------------------------------------conf_Password field ----------------------------------->
                         <div class="form-outline mb-4">
                            <label for="conf_user_password" class="form-label">Confirm Password<span class="text-danger">*</label>
                            <input type="password" id="conf_user_password" class="form-control " placeholder="Confirm Password" 
                            autocomplete="off" required="required" name="conf_user_password">
                        </div>

                        <!-------------------------------------------------------------------- Address field ------------------------------------->
                        <div class="form-outline mb-4">
                            <label for="user_address" class="form-label">Address<span class="text-danger">*</label>
                            <input type="text" id="user_address" class="form-control " placeholder="Enter your Address" 
                            autocomplete="off" required="required" name="user_address">
                        </div>

                        <!-------------------------------------------------------------------- contact field ------------------------------------->
                        <div class="form-outline mb-4">
                            <label for="user_contact" class="form-label">Mobile number<span class="text-danger">*</label>
                            <input type="number" id="user_contact" class="form-control " placeholder="Enter your Mobile number" 
                            autocomplete="off" required="required" name="user_contact">
                        </div>

                        <div>
                            <input type="submit" value="SignUp" class="bg-info py-2 px-3 border-0" name="user_signup">
                        </div>
                        
                        <P class="small fw-bold mt-3 pt-2 mb-0">Already have an account? <a href="user_login.php" class="text-danger">Login</a></P>
                </form>
            </div>
        </div>
    </div>

</body>
</html>

<?php

if(isset($_POST['user_signup'])){

    $user_name=$_POST['user_name'];
    $user_email=$_POST['user_email'];
    $user_password=$_POST['user_password'];
    $hash_password=password_hash($user_password,PASSWORD_DEFAULT);
    $conf_user_password=$_POST['conf_user_password'];
    $user_address=$_POST['user_address'];
    $user_contact=$_POST['user_contact'];
    
    $user_image=$_FILES['user_Image']['name'];
    $user_image_tmp=$_FILES['user_Image']['tmp_name'];

    move_uploaded_file($user_image_tmp,"./user_images/$user_image");
    $user_ip=getIPAddress();

    $select_query="select * from `user_table` where user_name='$user_name' or user_email='$user_email' ";
    $result=mysqli_query($con,$select_query);
    $rows_count=mysqli_num_rows($result);
    if($rows_count > 0){
        echo "<script>alert('Username or Email already exist')</script>";
    }else if($user_password != $conf_user_password){
        echo "<script>alert('Passwords don't match')</script>";
    }else{

    $insert_query="insert into `user_table` (user_name,user_email,user_password,user_image,user_ip,user_address,user_mobile) values
     ('$user_name','$user_email','$hash_password','$user_image','$user_ip','$user_address','$user_contact')";

    $sql_execute=mysqli_query($con,$insert_query);

    if($sql_execute){
        echo "<script>alert('Data inserted successfully')</script>";
    }else{
        die(mysqli_error($con));
    }
    
}

// selecting cart items

$select_cart_items="select * from `cart_details` where ip_address='$user_ip'";
$result_cart=mysqli_query($con,$select_cart_items);
$rows_count=mysqli_num_rows($result_cart);
if($rows_count > 0){
    $_SESSION['username']=$user_name;
    echo "<script>alert('You have items in your cart')</script>";
    echo "<script>window.open('checkout.php','_self')</script>";
}else{
    echo "<script>window.open('../index.php','_self')</script>";
}

}

?>