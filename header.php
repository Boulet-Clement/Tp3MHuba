<header>
    <nav>
        <div class="nav-wrapper">
        <ul id="nav-mobile" class="left hide-on-med-and-down">
            <li><a href="index.php" style="font-size:2rem;">Tp 3</a></li>
            <li><a href="welcome.php">Welcome</a></li>
        </ul>  
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <?php 
                        if(!isset($_SESSION['login'])){
                            echo "<li><a href=\"signin.php\">Connect me</a></li>";
                            echo "<li><a href=\"signup.php\">Sign up</a></li>";
                        }else{
                            echo "<li><a href=\"signout.php\">Disconnect</a></li>";
                        }
                    ?>
            </ul>
        </div>
    </nav>
</header>