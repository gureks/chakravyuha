<?php

$level_no = 9;
$correctAns = "37253";


require_once 'init.php';

Redirect::to($us_url_root.'leaderboard.php');
$isCorrectAnswer=0;//not attempted 1->right 2->wrong
if (!(isset($user) && $user->isLoggedIn())) {
    Redirect::to("http://chakravyuha.in/users/login.php");
}

$host = Config::get('mysql/host');
$db = Config::get('mysql/db');
$un = Config::get('mysql/username');
$password = Config::get('mysql/password');
$dbC = new mysqli($host, $un, $password, $db);

$username = $user->data()->username;
$queryC = "SELECT * FROM users WHERE username=\"$username\"";
$res = $dbC->query($queryC);
$row = $res->fetch_assoc();
if (!($level_no == $row['level'])) {
    Redirect::to($us_url_root.'users/level'.$row['level'].'.php');
}

if (isset($_POST['answer'])) {
    $userAns = $_POST['answer'];
    $userID = $row['id'];
    $levelOfUser = $row['level'];

    $userAttemptQuery = "INSERT INTO attempt (id, level, answer, time) VALUES ($userID, $levelOfUser, \"$userAns\", NOW())";
    if (!$dbC->query($userAttemptQuery)) {
        echo "ERROR IN ATTEMPT";
    }

    if ($userAns == $correctAns) {
        $isCorrectAnswer = 1;
        $levelOfUser = $levelOfUser + 1;
        $usersUpdateQuery = "UPDATE users SET level=$levelOfUser,lastAnswerTime = NOW() WHERE id=$userID";
        if (!$dbC->query($usersUpdateQuery)) {
            echo "ERROR IN UPDATING USERS CRED";
        }
        Redirect::to($us_url_root.'users/level'.$levelOfUser.'.php');
    }
    else
    {
        $isCorrectAnswer=2;
    }
}
?>


<?php require_once $abs_us_root.$us_url_root.'users/includes/header.php';?>

<?php require_once $abs_us_root.$us_url_root.'users/includes/navigation.php'; ?>
    <script>
        document.title = "notrot9";
    </script>

    <div id="particles-js"></div>
    <script src="http://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script> <!-- stats.js lib -->
    <header>

        <div class="jumbotron " id="back" style="background-color:transparent">

            <div class="container">

                <div class="row">

                    <div class="col-xs-12"> </br>

                        </br>

                        </br>


                        <h1 class="text-center">notrot9</h1>

                        </br>

                        </br>

                        <p class="text-center" style="color: #2e8a19">
                            <?php
                            if ($isCorrectAnswer==1)
                            {
                                echo 'Your Answer was Correct';

                            }
                            else if($isCorrectAnswer==2)
                            {
                                echo 'Your Answer was Wrong';
                            }

                            ?>
                        </p>

                        </br>

                        <p class="text-center">
                            <img src="http://65.media.tumblr.com/6b76f293c613a6b8a7c60b9f66ef07bb/tumblr_n5g8s9OaMp1s4vo4xo1_500.jpg" alt="" class="img-responsive center-block" height="400px" width="400px">
                        </p>

                        </br>
                        <!-- You used to text me on your flip phone, late night when you need my clue.-->
                    </div>
                    <!--XY-->
                </div>

            </div>
        </div>

    </header>
<?php
if ($level_no == $row['level']) {
    ?>
    <form action="level9.php" method="post" style="z-index: 999999999; width: 100%; position: absolute;">
        <label>
            <input type="text" id="answer" name="answer" class="answer">
            <div class="label-text">
                Your Answer
            </div>
        </label>
        </br></br></br>
        <input type="submit" value="Submit" role="button" class="btn btn-primary trans" style="font-size: 18px">
    </form>

    <?php
} else {
    ?>
    <header>

        <div class="jumbotron " id="back" style="background-color:transparent" >

            <div class="container" >

                <div class="row" >

                    <div class="col-xs-12">
                        <h1>You have already cleared this level</h1>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <?php

}

?>

