<?php
require_once('../classes/account.class.php');
require_once('../tools/functions.php');

// Initialize variables for form fields and error messages
$firstName = $lastName = $username = $password = $confirmPassword = '';
$firstNameErr = $lastNameErr = $usernameErr = $passwordErr = $confirmPasswordErr = '';

$accountObj = new Account();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Clean and validate input data
    $firstName = clean_input($_POST['first_name']);
    $lastName = clean_input($_POST['last_name']);
    $username = clean_input($_POST['username']);
    $password = clean_input($_POST['password']);
    $confirmPassword = clean_input($_POST['confirm_password']);

    // Validate First Name
    if (empty($firstName)) {
        $firstNameErr = 'First name is required.';
    } elseif (!preg_match("/^[a-zA-Z ]*$/", $firstName)) {
        $firstNameErr = 'Only letters and white space allowed.';
    }

    // Validate Last Name
    if (empty($lastName)) {
        $lastNameErr = 'Last name is required.';
    } elseif (!preg_match("/^[a-zA-Z ]*$/", $lastName)) {
        $lastNameErr = 'Only letters and white space allowed.';
    }

    // Validate Username
    if (empty($username)) {
        $usernameErr = 'Username is required.';
    } elseif ($accountObj->usernameExist($username, null)) {
        $usernameErr = 'Username already exists.';
    } elseif (!preg_match("/^[a-zA-Z0-9._-]*$/", $username)) {
        $usernameErr = 'Username can only contain letters, numbers, and symbols . _ -';
    }

    // Validate Password
    if (empty($password)) {
        $passwordErr = 'Password is required.';
    } elseif (strlen($password) < 8) {
        $passwordErr = 'Password must be at least 8 characters long.';
    }

    // Validate Confirm Password
    if (empty($confirmPassword)) {
        $confirmPasswordErr = 'Please confirm your password.';
    } elseif ($password !== $confirmPassword) {
        $confirmPasswordErr = 'Passwords do not match.';
    }

    // If there are validation errors, return them as JSON
    if (!empty($firstNameErr) || !empty($lastNameErr) || !empty($usernameErr) || 
        !empty($passwordErr) || !empty($confirmPasswordErr)) {
        echo json_encode([
            'status' => 'error',
            'firstNameErr' => $firstNameErr,
            'lastNameErr' => $lastNameErr,
            'usernameErr' => $usernameErr,
            'passwordErr' => $passwordErr,
            'confirmPasswordErr' => $confirmPasswordErr
        ]);
        exit;
    }

    // If validation passes, create the account
    if (empty($firstNameErr) && empty($lastNameErr) && empty($usernameErr) && 
        empty($passwordErr) && empty($confirmPasswordErr)) {
        
        $accountObj->first_name = $firstName;
        $accountObj->last_name = $lastName;
        $accountObj->username = $username;
        $accountObj->password = $password;
        // Default values are already set in the Account class
        // $accountObj->role = 'staff';
        // $accountObj->is_staff = true;
        // $accountObj->is_admin = false;

        if ($accountObj->add()) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Something went wrong when creating the account.'
            ]);
        }
        exit;
    }
}
?>


<script>
function submitForm(event) {
    event.preventDefault();
    
    // Clear previous error messages
    $('.error').text('');
    
    $.ajax({
        type: 'POST',
        url: 'add_account.php',
        data: $('#addAccountForm').serialize(),
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                alert('Account created successfully!');
                $('#addAccountModal').modal('hide'); // Hide modal on success
                $('#addAccountForm')[0].reset(); // Reset form fields
                window.location.href = 'accounts.php'; // Redirect to accounts list
            } else {
                // Display validation errors
                if (response.firstNameErr) $('#first_name_err').text(response.firstNameErr);
                if (response.lastNameErr) $('#last_name_err').text(response.lastNameErr);
                if (response.usernameErr) $('#username_err').text(response.usernameErr);
                if (response.passwordErr) $('#password_err').text(response.passwordErr);
                if (response.confirmPasswordErr) $('#confirm_password_err').text(response.confirmPasswordErr);
                if (response.message) alert(response.message);
            }
        },
        error: function() {
            alert('An error occurred. Please try again.');
        }
    });
    
    return false;
}
</script>