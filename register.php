<?php
error_reporting(E_ALL); 
ini_set('display_errors', TRUE); 
// Include config file
require_once "dbcon.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = $firstname = $lastname = $address = $city= $email= "";
$username_err = $password_err = $confirm_password_err = $firstname_err =$lastname_err =$address_err =$city_err =$email_err= "";
$newid="";
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        //$username = trim($_POST["username"]);
        
        //select statement
        $sql = "SELECT user_id FROM user WHERE user_name = ?";
        
        if($stmt = $mysqli->prepare($sql)){
           
            $stmt->bind_param("s", $param_username);
            
            
            $param_username = trim($_POST["username"]);
            
            //execute the prepared statement
            if($stmt->execute()){
                
                $stmt->store_result();
                
                if($stmt->num_rows == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        $stmt->close();
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    //validate firstname 
    if(empty(trim($_POST["firstname"]))){
        $firstname_err = "Please enter first name.";     
    } else{
        $firstname = trim($_POST["firstname"]);
        
    }
    
    //validate lastname 
    if(empty(trim($_POST["lastname"]))){
        $lastname_err = "Please enter last name.";     
    } else{
        $lastname = trim($_POST["lastname"]);
        
    }
    //validate address
    if(empty(trim($_POST["address"]))){
        $address_err = "Please enter address.";     
    } else{
        $address = trim($_POST["address"]);
        
    }
    //validate city 
    if(empty(trim($_POST["city"]))){
        $city_err = "Please enter city.";     
    } else{
        $city = trim($_POST["city"]);
        
    }
    //validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter email.";     
    } else{
        $email = trim($_POST["email"]);
        
    }
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($firstname_err) && empty($lastname_err)&& empty($address_err) && empty($city_err) && empty($email_err)){
        
        // insert statement
        $sql = "INSERT INTO user (user_name, password,user_type,created_by) VALUES (?, ?, ?,?)";
        $sql1="INSERT INTO member_profile(first_name,last_name,address,city,user_id,email,created_by) VALUES(?, ?, ?, ?,?,?,?)";
        if($stmt = $mysqli->prepare($sql)){
           
            $stmt->bind_param("ssii", $param_username, $param_password,$param_user_type,$param_created_by);
           // $stmt1->bind_param("sssss",$param_firstname,$param_lastname,$param_address,$param_city,$param_user_id,$param_email,$param_created_by);
           
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_user_type=1;
            $param_created_by=1;
            
            //execute the prepared statement
            //$v = $stmt->execute();
            
            if($stmt->execute()){
                $sql3 = "SELECT user_id FROM user WHERE user_name = ?";
        
            if($stmt2 = $mysqli->prepare($sql3)){
            // Bind variables to the prepared statement as parameters
            $stmt2->bind_param("s", $param_username1);
            
            // Set parameters
            $param_username1 = $username;
            
            // Attempt to execute the prepared statement
            if($stmt2->execute()){
                    $stmt2->store_result();
                    if($stmt2->num_rows==1){

                    
                    // Bind result variables
                    $stmt2->bind_result($id);
                    if($stmt2->fetch()){
                        $newid=$id;
                        
                    }
                }
                
               
            }
        }
            }
            
            $stmt1 = $mysqli->prepare($sql1);
             $stmt1->bind_param("ssssisi",$param_firstname,$param_lastname,$param_address,$param_city,$param_user_id,$param_email,$param_created_by);
           
            // Close connection
            $param_firstname=$firstname;
            $param_lastname=$lastname;
            $param_address=$address;
            $param_city=$city;
            echo $newid;
            $param_user_id = $newid;
            $param_email=$email;
            $param_created_by =1;
            
            $n = $stmt1->execute();
    
            // Close statement
            
            if($n ===true){
               
                // Redirect to same page
                header("location: login.php");
           
               
              
            } else{
             
                $register= "Something went wrong. Please try again later. ";
            }
             $stmt2->close();
            $stmt1->close();
            $stmt->close();
            
        }
         
        
       $mysqli->close();
    }
    
    
}
?>
  
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>

</head>
<body >
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>   
            <div class="form-group <?php echo (!empty($firstname_err)) ? 'has-error' : ''; ?>">
                <label>First Name</label>
                <input type="text" name="firstname" class="form-control" value="<?php echo $firstname; ?>">
                <span class="help-block"><?php echo $firstname_err; ?></span>
            </div> 
            <div class="form-group <?php echo (!empty($lastname_err)) ? 'has-error' : ''; ?>">
                <label>Last Name</label>
                <input type="text" name="lastname" class="form-control" value="<?php echo $lastname; ?>">
                <span class="help-block"><?php echo $lastname_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                <label>Address</label>
                <input type="text" name="address" class="form-control" value="<?php echo $address; ?>">
                <span class="help-block"><?php echo $address_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($city_err)) ? 'has-error' : ''; ?>">
                <label>City</label>
                <input type="text" name="city" class="form-control" value="<?php echo $city; ?>">
                <span class="help-block"><?php echo $city_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>Email ID</label>
                <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>   
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>

            <p>Already have an account? <a href="login.php">Login here</a>.</p>
            <?php 
    if(isset($_GET['msg'])){  // Check if $msg is not empty
        echo '<div>'.$_GET['msg'].'</div>'; // Display our message and wrap it with a div with the class "statusmsg".
        var_dump($_GET['msg']);
    } 
?>
        </form>
    </div>    
</body>
</html>