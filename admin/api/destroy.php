<?php 
  session_start();
  unset ( $_SESSION['user'] ); 


  if(!isset($_SESSION['user']) || empty($_SESSION['user'])){
    header("location: ../");
    exit;
  }
?>