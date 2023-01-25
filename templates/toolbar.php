<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <?php
                        if(isset($_SESSION['welcome_message']))
                        {
                            require_once('notifications/welcome_message.php');
                        }
                        unset($_SESSION['welcome_message']);
                        if(isset($_SESSION['Authfailed']))
                        {
                            require_once('notifications/Authfailed.php');
                        }
                        unset($_SESSION['Authfailed']);
                        if(isset($_SESSION['nulls_Found']))
                        {
                            require_once('notifications/nulls_Found.php');
                        }
                        unset($_SESSION['nulls_Found']);
                        if(isset($_SESSION['Exist_Account']))
                        {
                            require_once('notifications/Exist_Account.php');
                        }
                        unset($_SESSION['Exist_Account']);
                        if(isset($_SESSION['update_info']))
                        {
                            require_once('notifications/update_info.php');
                        }
                        unset($_SESSION['update_info']);
                     ?>
                    
                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo ($_SESSION['auth_user']['nameNlast']);?></span>
                                <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="dashboard.php" data-bs-toggle="modal" data-bs-target="#static_updateAdmin">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                               
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="index.php" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>