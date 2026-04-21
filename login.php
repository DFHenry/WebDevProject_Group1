<?php
    //name page title, get initial error message
    $pageTitle = "Login | Three Dudes Bakery";
    $errorMessage = "Please Enter Your Email & Password Below";
?>

<?php 
    //get header component
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
            $errorMessage= "invalid email or password.";
        }
        //if login email is impropery formatted, send error message
        elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
        {
            $isValid = false; 
            $errorMessage= "invalid email or password.";            
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

                //var_dump($result);

                //place first entry in $result (there should only be one result anyways)
                $user = $result->fetch_all(MYSQLI_ASSOC);

                //if user is empty, throw an error
                if(empty($user[0]) || is_null($user[0]))
                {
                    $errorMessage = 'invalid email or password.';
                }
                //otherwise, check if password matches the one on the DB for the user
                else
                {
                    //verify password
                    if(password_verify($_POST['password'], $user[0]['password']))
                    {
                        //assign email and id to $_SESSION
                        $_SESSION['id'] = $user[0]['id'];
                        $_SESSION['email'] = $user[0]['email'];

                        //redirect to dashboard
                        header('Location: dashboard.php');
                    }
                    else
                    {
                        //change error message
                        $errorMessage = 'invalid email or password.';
                    }
                }
            }

        }
    }
    //end of validation
?>

<h1>Restaurant Name</h1>

<h3>Login Page</h3>

<p><?=$errorMessage?></p>

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

<?php 
    //get footer component
    include_once('components/footer.php'); 
?>