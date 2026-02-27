<?php 
include "ddb.php";

$message = "Identify the country!";

// 1. Handle Answer Submission
if(isset($_POST['submit_answer'])){
    $user_answer = $_POST['user_choice'];
    $correct = $_POST['correct_answer'];

    if($user_answer === $correct){
        $message = "<span style='color:green;'>Correct! That is " . htmlspecialchars($correct) . ".</span>";
    } else {
        $message = "<span style='color:red;'>WRONG! It was " . htmlspecialchars($correct) . ".</span>";
    }
}


$sql_correct = "SELECT * FROM quis ORDER BY RAND() LIMIT 1";
$res_correct = mysqli_query($conn, $sql_correct);
$row = mysqli_fetch_assoc($res_correct);
$correct_country = $row['country_name'];


$sql_wrong = "SELECT country_name FROM quis WHERE country_name != '$correct_country' ORDER BY RAND() LIMIT 3";
$res_wrong = mysqli_query($conn, $sql_wrong);

$options = [];
$options[] = $correct_country; // Add correct one
while($w = mysqli_fetch_assoc($res_wrong)) {
    $options[] = $w['country_name']; // Add wrong ones
}

shuffle($options); // Mix them up so 'A' isn't always right
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <center>
        <h1>Flag Quiz</h1>
        <div class="contain">
            <div class="iimg">
                <img src="img/<?php echo $row['img'];?>" alt="Flag">
            </div>

            <div class="cont">
                <p><b><?php echo $message; ?></b></p>
                <p><?php echo $row['question']; ?></p>
            </div>

            <form method="POST" action="">
                <input type="hidden" name="correct_answer" value="<?php echo $correct_country; ?>">
                
                <div class="but">
                    <?php foreach($options as $opt): ?>
                        <button type="submit" name="user_choice" value="<?php echo $opt; ?>"><?php echo $opt; ?></button>
                    <?php endforeach; ?>
                    <input type="hidden" name="submit_answer" value="1">
                </div>
            </form>
            
            <br>
            <a href="quis.php"><button style="background-color:gray; color:white; border-radius:5px;">Next Question</button></a>
        </div>
    </center>
</body>
</html>