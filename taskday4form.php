<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
 
    $name       = clean($_POST['name']);
    $email      = clean($_POST['email']);
    $password   = clean($_POST['password']);
    $address    = clean($_POST['address']);
    $linked_url = clean($_POST['linked_url']);
    $gender     = clean($_POST['gender']);
    $cv         = clean($_POST['cv']);

     $errors = [];

      $name = "root account";
      var_dump(ctype_alpha(str_replace(' ','',$name)));

    if (empty($name)) {    
        $errors['name'] = 'Field is Required';
    }elseif (!ctype_alpha(str_replace(' ', '', $name))) {
        $errors['name'] = 'Name must be only letters';
    }


    if (empty($email)) {
        $errors['email'] = 'Field is Required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid Email';
    }

    if (empty($password)) {
        $errors['password'] = 'Field is Required';
    } elseif (strlen($password) < 6) {
        $errors['password'] = 'Password must be at least 6 characters';
    } 

     if (empty($_POST["linked_url"])) {
        
        $linked_url = "";

      } else {

         $linked_url = test_input($_POST["linked_url"]);

       }

 
    if (count($errors) > 0) {

        foreach ($errors as $key => $value) {
            
            echo $key . ' : ' . $value . '<br>';
        }
    } else {
            
         $_SESSION['studentData'] = [
            'name'       => $name,
            'email'      => $email,
            'password'   => $password,
            'address'    => $address,
            'linked_url' => $linked_url,
            'cv'         => $cv];

    }
}


 if (!empty($_FILES['cv']['name'])) {

        $tempName  = $_FILES['cv']['tmp_name'];
        $cveName = $_FILES['cv']['name'];
        $cvType = $_FILES['cv']['type'];

        $extensionArray = explode('/', $cvType);
        $extension =  strtolower( end($extensionArray));

        $allowedExtensions = ['pdf'];    

        if (in_array($extension, $allowedExtensions)) {

            $finalName = uniqid().time().'.'. $extension;

            $disPath = 'uploads/'. $finalName;

            if (move_uploaded_file($tempName, $disPath)) {
                echo 'File Uploaded Successfully';
            } else {
                echo 'File Uploaded Failed';
            }
        } else {
            echo 'File Type Not Allowed';
        }
     }
    else {
        echo 'Please Select File';
    }


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>

    <div class="container">
        <h2>Register</h2>
         <form method="post" action="<?php echo  htmlspecialchars($_SERVER['PHP_SELF']); ?>">

            <div class="form-group">
                <label for="exampleInputName">Name</label>
                <input type="text" class="form-control" name="name" id="exampleInputName" aria-describedby="" placeholder="Enter Name">
            </div>


            <div class="form-group">
                <label for="exampleInputEmail">Email address</label>
                <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
            </div>

            <div class="form-group">
                <label for="exampleInputPassword">New Password</label>
                <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Password">
            </div>
            <div class="form-group">
                <label for="exampleInputAddress">Address</label>
                <input type="Address" class="form-control" name="Address" id="exampleInputAddress" placeholder="Address">
            </div>
            
            <div class="form-group">
                <label for="exampleInputLinkedin_url">Linkedin_URL</label>
                <input type="URL" class="form-control" name="linkedin"  id="exampleInputLinkedin_url" aria-describedby="urlHelp" placeholder="Enter Linkedin_url">
            </div>

            <div class="form-group">
                <label for="exampleInputGender">Gender :-  </label>
             
            <input type="radio" name="gender"
          <?php if (isset($gender) && $gender=="female") echo "checked";?>
          value="female">Female
         <input type="radio" name="gender"
         <?php if (isset($gender) && $gender=="male") echo "checked";?>
           value="male">Male
             
             </div>

            
         <div class="form-group">
                <label for="exampleInputPassword">Upload CV </label>
                <input type="file" name="CV">
            </div>


        <div class="container">
         
         <form method="post" action="<?php echo  htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">

        </form>
    </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

</body>

</html>