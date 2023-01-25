<?php
    if(session_status() !== PHP_SESSION_ACTIVE || session_status() === PHP_SESSION_NONE)
    {
        session_start();
    } 
?>