<?php
session_start();

// include our LDAP object
require_once __DIR__ . '/LDAP/LDAP.php';
require_once __DIR__ . '/LDAP/config_ldap.php';


// check uid
if (empty($_POST['user']) || empty($_POST['password'])) {
    echo 'You must fill each field<br><br>';
    echo 'Click <a href="./index.php">here</a> to come back to login page';
} else {
    // Check received data length (to prevent code injection)
    if (strlen($_POST['user']) > 50) {
        echo 'Strange username ... Please try again<br><br>';
        echo 'Click <a href="./index.php">here</a> to come back to login page';
    }
    //$pattern = '^(\S+)\\(\S+)$'
    //if (preg_match('/\S+\\\S+/', $_POST['user'], $matches)) {
    //}
    if (strlen($_POST['password']) > 50 || strlen($_POST['password']) <= 5) {
        echo 'Strange password ... Please try again<br><br>';
        echo 'Click <a href="./index.php">here</a> to come back to login page';
    } else {
        // Remove every html tag and useless space on username (to prevent XSS)
        $user = mb_strtolower(strip_tags(trim($_POST['user'])));

        $password = $_POST['password'];

        // Open a LDAP connection
        $ldap = new LDAP($hostname, $port);
        $check = false;

        try {
            //echo 'Pre start check <br/>';
            // Check user credential on LDAP
            $check = $ldap->checkLogin($user, $password, $search_attribute, $filter, $base, $bind_dn, $bind_pass);

        } catch (Exception $e) {
            //error_log('Exception: '. $e->getMessage());
        }
        echo 'Check: ', $check, '<br/>';
        if ($check) {
            $_SESSION['uid'] = $user;

            // If user came here with an autorize request, redirect him to the authorize page. Else prompt a simple message.
            if (isset($_SESSION['auth_page'])) {
                //echo "Test <br>";
                $auth_page = $_SESSION['auth_page'];
                header('Location: ' . $auth_page);
                exit();
            } else {
                echo "Congratulation you are authenticated ! <br><br> However there is nothing to do here ...";
            }
        } // check login on LDAP has failed. Login and password were invalid or LDAP is unreachable
        else {
            echo "Authentication failed ... Check your username and password.<br>If error persist contact your administrator.<br><br>";
            echo 'Click <a href="./index.php">here</a> to come back to login page';
        }
    }
}
