<html>
<ody>

<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

echo ("MySQL - PHP Connect Test <br/>");
$hostname = "localhost";
$username = "cs20121631";
$password = "dbpass";
$dbname = "db20121631";

$connect = mysqli_connect($hostname, $username, $password)
	         or die("DB Connection Failed");
			          if($connect) {
						            echo("MySQL Server Connect Success!");
						}
else {
	echo("MySQL Server Connect Failed!");
}

?> 
<table width = "800" border = "1" cellpadding = "10">
<tr align = "center">
<td bgcolor = "#cccccc">Name</td>
<td bgcolor = "#cccccc">Score</td>
<td bgcolor = "#cccccc">Rank</td>

<?php
$name = $score = $grade = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$name = test_input($_POST["name"]);
	$score = test_input($_POST["score"]);
	$score=20;

	mysqli_select_db($connect,"db20121631");
	$sql = "insert into project(name, score) values ('$name', '$score')";
	mysqli_query($connect,$sql);
	$sql1 = "select name, score , (select count(*)+1 from project where score > t.score) as rank from project as t order by rank asc";
	$result = mysqli_query($connect,$sql1);
	if (!$result) { 
		die('Invalid query: ' . mysqli_error($connect));
	}
	while($row = mysqli_fetch_array($result))
	{
		echo " <tr>
			<td> $row[name] </td>
			<td> $row[score] </td>
			<td> $row[rank] </td>
			</tr>
			";
	}

}


function test_input($data) {

	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
mysqli_close($connect);
?>

</body>
</html>

