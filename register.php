<?php
session_start();
use Validator\DB\Database;
use Validator\Models\User;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name     = $_POST['first_name'];
    $last_name      = $_POST['last_name']; 
    $age            = $_POST['age'];
    $email          = $_POST['email'];
    $gender         = $_POST['gender'];
    $contact        = $_POST['contact'];
    $password       = $_POST['password'];
    $confirm_pass   = $_POST['confirm_pass'];
    $errors         = 0;

    if ( $password != $confirm_pass ) {
        $message    = 'Password Not Correct!';
        $errors     = 1;
    }

    if (strlen( $password ) < 4 ) {
        $message    = 'Password must be at least 4 characters!';
        $errors     = 1;
    }

    if (!filter_var( $email, FILTER_VALIDATE_EMAIL)) {
        $message    = 'Invalid Email Address!';
        $errors     = 1;
    }

    if ( !$errors ) {
        $password = password_hash($password, PASSWORD_DEFAULT);

        $user   = new User();

        $created = $user->create([
            'first_name'    => $first_name,
            'last_name'     => $last_name,
            'age'           => $age,
            'email'         => $email,
            'gender'        => $gender,
            'contact'       => $contact,
            'password'      => $password,
        ]);

        if ( $created ) {
            $_SESSION['message'] = "Users registration successfully!";
            header('location:login.php');
        }
    }
}





?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<?php
    if (isset($message)) {

    ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong></strong> <?= $message ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php
    }
    ?>

    <div class="container ">
        <h1>Registration Form</h1>
        <form action="register.php" method="post">
            <div class="row mb-3">

                <div class="col">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter Your Password" required>
                </div>

                <div class="col">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter Your Last Name" required>
                </div>

            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="age" class="form-label">Age</label>
                    <input type="number" class="form-control" id="age" name="age" placeholder="Please Enter Your Age" required>
                </div>

                <div class="col">
                    <label for="gender" class="form-label">Gender</label>
                    <select class="form-select" id="gender" name="gender" required>
                        <option selected disabled value="">Choose...</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>


                <div class="mb-3">
                    <label for="contact" class="form-label">Contact</label>
                    <input type="tel" class="form-control" id="contact" name="contact" placeholder="Enter Your Mobile Number" required>
                </div>


                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter Your Mobile Number" required>
                </div>


                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter Your Password" required>
                </div>


                <div class="mb-3">
                    <label for="retypePassword" class="form-label">Retype Password</label>
                    <input type="password" class="form-control" id="retypePassword" name="confirm_pass" placeholder="Enter Your Retype Password" required>
                </div>

                <button type="submit" class="btn btn-primary">Sign up</button>
                <a href="login.php" class="btn btn-success mt-2">Login</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>