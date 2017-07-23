<!DOCTYPE html>
<html>
    <head>
        <title>Beacons Manager</title>
        <link rel="stylesheet" type="text/css" href="css/masterStyle.css">
        <link rel="stylesheet" type="text/css" href="css/contentStyle.css">
        <link rel="stylesheet" type="text/css" href="css/navigationStyle.css">
		    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="jquery/jquery-ui.min.js"></script>
        <script src="jquery/jquery-ui.js"></script>

    </head>
    <?php

      include('Database.php');
      session_start();

     ?>

    <body>
        <div id="header">
            <div id="top">
                <div id="headerLeft">
                    <button class="openSideNav" onclick="openSideNav()"></button><span>Beacons Manager</span>
                </div>
                <div id="headerMiddle">
                  <?php
                    if (isset($_SESSION['login'])) {
                  ?>

                    <input type="text" />
                  <?php
                    }
                  ?>
                </div>
                <div id="headerRight">
                    <div>
                        <div id="hrImage">
                            <img src="https://cdn1.iconfinder.com/data/icons/ninja-things-1/1772/ninja-simple-512.png" />
                        </div>
                        <div id="hrName">
                            <p>Welcome Michal</p>
                        </div>
                    </div>

                </div>
            </div>
            <?php
              if(isset($_SESSION['login'])){
                include('navigation.php');
              }

            ?>
        </div>

        <div id="body">
          <!-- Maing Content -->
          <div id="content">
