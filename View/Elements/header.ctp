<div class="container">
    <div class="page-header-inner">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="/home">
            <img src="/img/ONZSA_logo-05.png" alt="logo" class="logo-default"/>
            </a>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN HORIZANTAL MENU -->
        <!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
        <!-- DOC: This is desktop version of the horizontal menu. The mobile version is defined(duplicated) sidebar menu below. So the horizontal menu has 2 seperate versions -->
        <div class="hor-menu hidden-sm hidden-xs">
            <ul class="nav navbar-nav">
                <!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the horizontal opening on mouse hover -->
                <?php if($authUser['user_type_id'] !== "user_type_cashier") { ?>
                    <li>
                        <a href="/dashboard">
                        Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="/home">Sell</a>
                    </li>
                    <li>
                        <a href="/history">
                        History </a>
                    </li>
                    <li>
                        <a data-hover="dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;">
                        Product <i class="fa fa-angle-down"></i></a>
                        <ul class="dropdown-menu pull-left">
                            <li>
                                <a href="/product">Product</a>
                            </li>
                            <li>
                                <a href="/product/brand">Brand</a>
                            </li>
                            <li>
                                <a href="/product/type">Types</a>
                            </li>
                            <li>
                                <a href="/pricebook">Price Books</a>
                            </li>
                            <li>
                                <a href="/supplier">Suppliers</a>
                            </li>
                            <li>
                                <a href="/product/tag">Tags</a>
                            </li>
                            <li>
                                <a href="/stock_orders">Stock Control</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a data-hover="dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;">
                        Customer <i class="fa fa-angle-down"></i></a>
                        <ul class="dropdown-menu pull-left">
                            <li>
                                <a href="/customer">Customer</a>
                            </li>
                            <li>
                                <a href="/customer/group">Group</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a data-hover="dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;">
                        Setup <i class="fa fa-angle-down"></i></a>
                        <ul class="dropdown-menu pull-left">
                            <li>
                                <a href="/setup">General</a>
                            </li>
                            <li>
                                <a href="/account">Account</a>
                            </li>
                            <li>
                                <a href="/setup/outlets_and_registers">Outlets and Registers</a>
                            </li>
                            <li>
                                <a href="/setup/quick_keys">Quick Keys</a>
                            </li>
                            <li>
                                <a href="/setup/payments">Payment Types</a>
                            </li>
                            <li>
                                <a href="/setup/taxes">Sales Taxes</a>
                            </li>
                            <li>
                                <a href="/setup/loyalty">Loyalty</a>
                            </li>
                            <li>
                                <a href="/setup/user">Users</a>
                            </li>
                            <li>
                                <a href="/setup/add_ons">Add-ons</a>
                            </li>
                        </ul>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <!-- END HORIZANTAL MENU -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
        </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN TOP NAVIGATION MENU -->
        <div class="top-menu">
            <ul class="nav navbar-nav pull-right">
                <?php if($authUser['RegisterCount'] >= 2 and !empty($authUser['outlet_id'])) { ?>
                <li class="dropdown dropdown-user">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                    <span class="username">
                    <?php echo $authUser['MerchantRegister']['name'];?> </span>
                    <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li id="change_register">
                            <a href="javascript:;">
                            <i class="icon-user"></i> Change Register </a>
                        </li>
                    </ul>
                </li>
                <?php } ?>
                <!-- BEGIN USER LOGIN DROPDOWN -->
                <li class="dropdown dropdown-user">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                    <img alt="" class="img-user" src="/img/user.png"/>
                    <span class="username">
                    <?=$authUser['display_name'];?> </span>
                    <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="/users/<?php echo $authUser['id'];?>">
                            <i class="icon-user"></i> My Profile </a>
                        </li>
                        <li class="divider">
                        </li>
                        <li>
                            <a href="#">
                            <i class="icon-lock"></i> Lock Screen </a>
                        </li>
                        <li>
                            <a href="/users/logout">
                            <i class="icon-key"></i> Log Out </a>
                        </li>
                    </ul>
                </li>
                <!-- END USER LOGIN DROPDOWN -->
                <!-- BEGIN QUICK SIDEBAR TOGGLER -->
                <li class="dropdown dropdown-quick-sidebar-toggler">
                    <a href="javascript:;" class="dropdown-toggle">
                    <i class="glyphicon glyphicon-question-sign"></i>
                    </a>
                </li>
                <!-- END QUICK SIDEBAR TOGGLER -->
            </ul>
        </div>
        <!-- END TOP NAVIGATION MENU -->
    </div>
</div>
