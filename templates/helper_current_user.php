<?php
    require_once __DIR__ . '/../config/env.php';
    loadEnv(__DIR__ . '/../.env');
    require_once __DIR__ . '/../config/autoload.php';


    $isLoggedIn = false;
    $isAdmin = false;
    $payload=null;
    if(isset($_COOKIE['auth_token'])){
        $isLoggedIn= true;
        try{
            $payload=(new JwtService($_ENV['JWT_SECRET']))->decode($_COOKIE['auth_token']);
            if($payload['role']=='admin')
                $isAdmin=true;
        }
        catch(AuthException $e){
            throw new AuthException("Not signed in!!!");
        }
    }
?>