<?php 
    function userExists($username, $password) {
        $pass = sha1($password);

        global $db;
        $stmt = $db->prepare('SELECT * FROM users WHERE username = ? AND password = ?');
        $stmt->execute(array($username, $pass));
        $user = $stmt->fetch();

        if ($user) return TRUE;
        else return FALSE;
    }
?>