<?php
/**
 * @author Edward Cooney <ercooney80@gmail.com>
 * File: index.php
 * Date: 05/15/2014
 * PHP version: 5.3
 * Description: Homepage for site 
 * ToDo: Add Features
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <title>DMB Collection</title>

        <link rel="stylesheet" type="text/css" href="css/superfish.css" />
        <link rel="stylesheet" type="text/css" href="css/layout.css" />
        <link rel="stylesheet" type="text/css" href="css/homepage.css" />
        <style type="text/css">
            // local style     
        </style>  
    </head>
    <body >
    <section class="container">
        <header class="header"><?php require_once "include/header.php" ?></header>
        <section class="navigation"><?php require_once "include/navigation.php" ?></section>
        <section class="content"><!-- content -->

            <section id="lside"><?php require_once 'Homepage/frontpage.php'; ?></section>
            <section id="rside"><?php require_once 'Homepage/contact.php'; ?></section>  

        </section><!-- content -->

    </section><!-- container -->

    <script type="text/javascript" src="js/textlength.js"></script>
    <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="js/superfish.min.js"></script>
    <script type="text/javascript" src="js/init.js"></script>
    <script type="text/javascript">
        /* local JavaScript */
    </script>
    <footer id="footer"><?php require_once 'footer.php'; ?></footer>
</body>
</html>