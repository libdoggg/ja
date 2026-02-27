<?php
session_start();
include "ddb.php";

/* -------------------- SESSION SETUP -------------------- */
if (!isset($_SESSION['completed'])) {
    $_SESSION['completed'] = [];
}

if (!isset($_SESSION['score'])) {
    $_SESSION['score'] = 0;
}

$total_questions = 4; // You said you only have 4 questions
$message = "Choose The Correct Flag!";

/* -------------------- HANDLE ANSWER -------------------- */
if (isset($_POST['submit_answer'])) {

    $user_answer = $_POST['user_choice'];
    $correct = $_POST['correct_answer'];

    if ($user_answer === $correct) {

        $message = "<span style='color:green;'>✅ Correct! That was " . htmlspecialchars($correct) . "</span>";

        if (!in_array($correct, $_SESSION['completed'])) {
            $_SESSION['completed'][] = $correct;
            $_SESSION['score']++;
        }

    } else {
        $message = "<span style='color:red;'>❌ Wrong! Correct answer is " . htmlspecialchars($correct) . "</span>";
    }
}

/* -------------------- CHECK IF QUIZ FINISHED -------------------- */
if (count($_SESSION['completed']) >= $total_questions) {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Quiz Finished</title>
        <style>
            body { font-family: Arial; text-align: center; }
            .box {
                margin: 100px auto;
                padding: 30px;
                width: 400px;
                border: 3px solid black;
                border-radius: 10px;
            }
            button {
                padding: 10px 20px;
                background: darkred;
                color: white;
                border: none;
                border-radius: 5px;
            }
        </style>
    </head>
    <body>
        <div class="box">
            <h2>🎉 Quiz Completed!</h2>
            <h3>Your Score: <?php echo $_SESSION['score']; ?> / <?php echo $total_questions; ?></h3>
            <a href="reset.php"><button>Play Again</button></a>
        </div>
    </body>
    </html>
    <?php
    exit();
}

/* -------------------- GET NEW QUESTION -------------------- */

$completed = $_SESSION['completed'];

if (!empty($completed)) {
    $notIn = "'" . implode("','", $completed) . "'";
    $sql_correct = "SELECT * FROM quis 
                    WHERE country_name NOT IN ($notIn) 
                    ORDER BY RAND() LIMIT 1";
} else {
    $sql_correct = "SELECT * FROM quis ORDER BY RAND() LIMIT 1";
}

$res_correct = mysqli_query($conn, $sql_correct);
$row = mysqli_fetch_assoc($res_correct);
$correct_country = $row['country_name'];

/* -------------------- GET WRONG OPTIONS -------------------- */

$sql_wrong = "SELECT country_name FROM quis 
              WHERE country_name != '$correct_country' 
              ORDER BY RAND() LIMIT 3";

$res_wrong = mysqli_query($conn, $sql_wrong);

$options = [];
$options[] = $correct_country;

while ($w = mysqli_fetch_assoc($res_wrong)) {
    $options[] = $w['country_name'];
}

shuffle($options);

$remaining = $total_questions - count($_SESSION['completed']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Flag Quiz</title>
    <style>
        body { font-family: Arial; }

        .contain {
            border: 5px double black;
            border-radius: 8px;
            width: 400px;
            margin: auto;
            padding: 20px;
        }

        .iimg {
            width: 100%;
            height: 160px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .iimg img {
            width: 300px;
            height: 180px;
            border: 1px solid black;
            border-radius: 8px;
            object-fit: cover;
        }

        .but {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-top: 10px;
        }

        .but button {
            color: white;
            background-color: darkred;
            border-radius: 8px;
            padding: 12px 0;
            border: none;
            width: 100%;
            font-size: 14px;
            cursor: pointer;
        }

        .but button:hover {
            background-color: red;
        }

        .progress {
            margin-top: 10px;
            font-weight: bold;
        }

        h1 {
            text-align: center;
            background-color: antiquewhite;
            padding: 20px;
        }
    </style>
</head>

<body>

<h1>🌍 Flag Quiz</h1>

<div class="contain">

    <div class="iimg">
        <img src="img/<?php echo $row['img']; ?>" alt="Flag">
    </div>

    <p><b><?php echo $message; ?></b></p>
    <p><?php echo $row['question']; ?></p>

    <div class="progress">
        Questions Remaining: <?php echo $remaining; ?> / <?php echo $total_questions; ?>
        <br>
        Score: <?php echo $_SESSION['score']; ?>
    </div>

    <form method="POST">
        <input type="hidden" name="correct_answer" value="<?php echo $correct_country; ?>">

        <div class="but">
            <?php foreach ($options as $opt): ?>
                <button type="submit" name="user_choice" value="<?php echo $opt; ?>">
                    <?php echo $opt; ?>
                </button>
            <?php endforeach; ?>
        </div>

        <input type="hidden" name="submit_answer" value="1">
    </form>

</div>

</body>
</html>