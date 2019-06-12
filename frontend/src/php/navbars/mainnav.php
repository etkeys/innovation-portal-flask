<?php
    $permissions = array();
    $isRegistered = @array_key_exists("userdef", $_SESSION);
    $specialUserFlag = "notspecial";

    if($isRegistered){
        $permissions = $_SESSION["userdef"]["permissions"];

        if (@array_key_exists("specialUserFlag", $_SESSION["userdef"]["permissions"])){
            $specialUserFlag = $_SESSION["userdef"]["permissions"]["specialUserFlag"];
        }
    }
?>
<ul class="navbar">
    <li class="navitem"><a href="index.php?content=featured">Home</a></li>
    <li class="navitem dropdown">
            <a class="dropdown-btn" href="javascript:void(0)">Browse</a>
            <div class="dropdown-content">
                <a href="index.php?content=featured">Featured</a>
                <a href="index.php?content=frequently-viewed">Frequently Viewed</a>
                <a href="index.php?content=newlyadded">Newly Added</a>
                <?php
                    if ($specialUserFlag === "moderator"){
                        echo "<a href=\"index.php?content=requesting-moderator\">Projects requesting moderators</a>";
                    }
                ?>
            </div>
    </li>
    <?php
        if ($isRegistered){
            echo "<li class=\"navitem dropdown\">
                        <a class=\"dropdown-btn\" href=\"index.php?content=my-project\">My Projects</a>
                        <div class=\"dropdown-content\">
                            <a href=\"createproject.php?create=true\">Create Project</a>
                        </div>
                    </li>";

        if ($specialUserFlag === "administrator"){
			echo "<li class='navitem dropdown'>";
            echo  "<a class='dropdown-btn' href='javascript:void(0)'>Admin Tool</a>";
			echo "<div class='dropdown-content'>";
			echo "<a href='index.php?content=admin-view-all'>View All Project</a>";
            }
        }

        if ($specialUserFlag === "tester"){
            echo "<li class=\"navitem\"><a href=\"#news\">Tester Tools</a></li>";
        }
    ?>
    <li class="navitem right-align dropdown">
        <?php
            if ($isRegistered){
                echo "
            <a class=\"dropdown-btn\" href=\"javascript:void(0)\">" . $_SESSION["userdef"]["userdisplayname"] . "</a>
            <div class=\"dropdown-content\">
                <a href=\"logout.php\">Logout</a>
            </div>";
            }else{
                echo "<a href=\"login.php?operation=login\">Login | Register</a>";
            }
        ?>
    </li>
    <li class="navitem right-align searchbar">
        <!--
        <form action="./php/simplesearch.php" method="post">
            <input type="text" name="search" placeholder="Search keywords ...">
            <input class="gobutton" type="submit" value="Search">
        </form>
        -->

        <form action="./php/simplesearch.php" method="get">
            <input type="text" name="query" placeholder="Search keywords ...">
            <button type="submit" class="gobutton"><i class="fa fa-search"></i></button>
        </form>
    </li>
    
</ul>