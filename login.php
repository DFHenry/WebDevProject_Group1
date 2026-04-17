<?php 
    $pageTitle = "Restaurant | Login"; 
?>

<?php 
    require_once('components/header.php'); 
?>

<?php

    // login validation
    if(isset($_POST['email']))
    {
        $isValid = true;

        //if login email or password fields are empty, send error message
        if(empty($_POST['email']) || empty($_POST['password']))
        {
            $isValid = false; 
            $errorMessage= "Please Enter a Valid Email Address.";
        }
        //if login email is impropery formatted, send error message
        elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
        {
            $isValid = false; 
            $errorMessage= "Please Enter a Valid Email Address.";            
        }

        //if above checks pass, start login process
        if($isValid == true)
        {
            //Write sql query
            $query = 'SELECT id, email, password FROM users WHERE email = ? LIMIT 1';

            //prepare sql query
            $stmt = $db->prepare($query);

            //trim spaces in $_POST email
            $validatedEmail = trim($_POST['email']);

            //bind parameter to the sql statement
            $stmt->bind_param('s', $validatedEmail);

            //if statement execution fails, echo an error
            if($stmt->execute() == false)
            {
                echo "execute failed: " + $stmt->error;
            }
            //otherwise continue login
            else
            {
                //get the results of the query
                $result = $stmt->get_result();

                //place first entry in $result (there should only be one result anyways)
                $user = $result->fetch_all(MYSQLI_ASSOC)[0];

                //if user is empty, throw an error
                if(empty($user))
                {
                    $errorMessage = 'incorrect email or password';
                }
                //otherwise, check if password matches the one on the DB for the user
                else
                {
                    if(password_verify($_POST['password'], $user['password']))
                    {
                        //assign email and id to $_SESSION
                        $_SESSION['id'] = $user['id'];
                        $_SESSION['email'] = $user['email'];

                        //redirect to dashboard
                        header('Location: dashboard.php');
                    }
                }
            }

        }
    }
    //end of validation
?>

<h1>Restaurant Name</h1>

<h3>Login Page</h3>

<!-- <p><?=$errorMessage?></p> -->

<form action="" method="post">
    <div class="emailEntry">
        <label for="email">Email</label>
        <input type="email" name="email" id="email">
    </div>
    <div class="passwordEntry">
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
    </div>
    <button class="primaryButton" type="submit">Login</button>
</form>

<?php include_once('components/footer.php'); ?>