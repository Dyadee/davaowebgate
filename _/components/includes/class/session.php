<?php

// A class to help work with Sessions
// In our case, primarily to manage logging users in and out
// Keep in mind when working with sessions that it is generally 
// inadvisable to store DB-related objects in sessions

class Session {

    public $logged_in = false;
    public $userID;

    //REDIRECTS THE CURRENT PAGE TO SPECIFIED PAGE
    public function redirect($location = NULL) {
        if ($location != NULL) {
            header("Location:{$location}");
            exit;
        }
    }

    function __construct() {
        session_start();
    }

    public function is_logged_in() {
        return $this->logged_in;
    }

    public function login($userDetail) {
        if (!empty($userDetail)) {
            $this->userID = $_SESSION['userID'] = $userDetail->userID;
            $this->logged_in = true;
        }
    }

    public function logout() {
        unset($_SESSION['userID']);
        unset($this->userID);
        $this->logged_in = false;
    }

    public function confirm_logged_in() {
        if (isset($_SESSION['userID'])) {
            $this->userID = $_SESSION['userID'];
            $this->logged_in = true;
            return true;
        } else {
            unset($this->userID);
            unset($_SESSION['userID']);
            $this->logged_in = false;
            $this->redirect('login.php');
        }
    }

    public function confirm_logged_in_index() {
        if (isset($_SESSION['userID'])) {
            $this->userID = $_SESSION['userID'];
            $this->logged_in = true;
            $this->redirect('member.php');
        } else {
            unset($this->userID);
            unset($_SESSION['userID']);
            $this->logged_in = false;
        }
    }

}

$session = new Session();
?>