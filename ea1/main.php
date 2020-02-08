<?php
/*
 * main.php
 * 
 * Copyright 2017 dell <dell@KSEB>
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 * 
 * 
 */

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	  <meta charset="utf-8">
        <meta content="IE=edge" http-equiv="X-UA-Compatible">
        <title>EA Accounts
        </title>

         <meta content="" name="description">
        <meta content="width=device-width, initial-scale=1" name="viewport">
        <link rel="icon" type="image/x-icon" href="/bundles/app/img/eX.png?v06012017" />
        <link href="/bundles/app/vendor/bootstrap/css/bootstrap.min.css?v06012017" rel="stylesheet">
        <link href="AdminLTE.min.css" rel="stylesheet">
        <link href="/bundles/app/css/styles.css?v06012017" rel="stylesheet">
        <link href="/bundles/app/vendor/jgrowl-notifications/jgrowl.css?v06012017" rel="stylesheet">
        <link href="font-awesome.min.css" rel="stylesheet">
        <link href="/bundles/app/css/skins/skin-blue-light.css?v06012017" rel="stylesheet">
        <link href="/bundles/app/vendor/bootstrap/css/bootstrap-datepicker.min.css?v06012017" rel="stylesheet"/>
        <link href="/bundles/app/css/bootstrap-datetimepicker.min.css?v06012017" rel="stylesheet"/>
        <link href="/bundles/app/vendor/select2/select2.min.css?v06012017" rel="stylesheet">
        <link href="/bundles/app/css/chosen.min.css?v06012017" rel="stylesheet">
        
   <link rel="stylesheet" href="bootstrap.min.css">
  <script src="jquery.js"></script>
  <script src="bootstrap.min.js"></script>
</head>

<body>

<body class="layout-top-nav">
    <div class="page-overlay">
        <div class="loader">
            <div class="loading-text text-center" style="display:none"  >
                <h1>LOADING...!</h1>
            </div>
        </div>
    </div>
    <div class="content-wrapper">
                <style>
    .custom-color {
        color: #777!important;
    }
    a.custom-color:hover {
        background-color: #ffffff !important;
        color: #101010!important;
    }
    navbar {
        background-color: #ffffff;
        background-image: none;
    }
    .navCustom {
        float: left;
        font-size: 18px;
        height: 75px;
        line-height: 20px;
    }
    .navBorder {
        border-bottom: none!important;
        margin-bottom: 0;
    }

</style>
<div class="main-header">
    <nav class="navbar navbar navbar-primary navbar-static-top navBorder">
        <div class="container-fluid">
            <div style="margin-top:3px;" class="navbar-header">
                <a class="text-primary navCustom" href="/dashboard/">
                    <div class="pull-left">
                        <img  style="margin-top: 10px;width:50px" src="logo.png" alt=""/>
                    </div>
                    <div class="pull-left">
                        <h2 style="margin-top: 10px;">

                                                            <a class="navbar-brand ubuntu text-red"  style="font-size: xx-large; font-weight: bolder;" href="#"><b></b>KSEBEA</a>
                            
                            <div class="font-size-12 mrg5A">
                                                            </div>
                        </h2>
                    </div>
                </a>
                <button class="navbar-toggle collapsed mrg25R margin" aria-controls="navbar" aria-expanded="false" data-target="#navbar-main" data-toggle="collapse" type="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div id="navbar-main" class="navbar-collapse collapse" aria-expanded="false">
                <ul class="nav navbar-nav navbar-right">
                                            <li class="dropdown user user-menu pull-left">
                            <a href="/" class="custom-color" title=" Home">
                                <i class="fa fa-home fa-sm text-primary"></i>
                                Home
                            </a>
                        </li>
                        <li class="dropdown  user user-menu pull-left">
                            <a href="/usr/logins/jobseeker" title=" JobSeeker Registration" class="custom-color">
                                <i class="fa fa-graduation-cap text-primary"></i>
                                Reports</a>
                        </li>
                        <li class="dropdown  user user-menu pull-left">
                            <a href="/usr/logins/employer" title=" Employer Registration" class="custom-color">
                                <i class="fa fa-briefcase text-primary"></i>
                                Accounts</a>
                        </li>
                        <li class="dropdown  user user-menu pull-left">
                            <a href="/usr/nicsl/login" title=" Login" class="custom-color">
                                <i class="fa fa-sign-in text-primary"></i>
                                Log In
                                                            </a>
                        </li>

                                    </ul>
            </div>
        </div>
    </nav>
</div>


	
</body>

</html>
