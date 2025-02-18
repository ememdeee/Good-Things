<?php

function create_admin_user() {
    $username = 'newadminuser2'; // Change this to your desired username
    $password = 'R4nd0m$ecur3P@ssw0rd123!';

    $email = 'admin2@example.com'; // Your desired email

    // Check if the username or email already exists
    if (username_exists($username)) {
        echo "The username already exists.<br>";
    } elseif (email_exists($email)) {
        echo "The email already exists.<br>";
    } else {
        // Create the user
        $user_id = wp_create_user($username, $password, $email);
        if (is_wp_error($user_id)) {
            echo "Error creating user: " . $user_id->get_error_message() . "<br>";
        } else {
            $user = new WP_User($user_id);
            $user->set_role('administrator');
            echo "Administrator user created successfully! Username: $username, Password: $password<br>";
        }
    }
}
// Hook into WordPress initialization to create the user
add_action('init', 'create_admin_user');
