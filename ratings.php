<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <title>Search</title>
</head>
<body>
<?php
#validate and get input rating
if (!isset($_GET['rating'])) {
  header('Location: index.php');
}
$rating = $_GET['rating'];

#Make sure rating is valid, whitelist only allows 1 or more letters
preg_match('([^A-Z]+)', $rating, $matches);
if (sizeof($matches)!=0){
  exit('Bad input, input should only be a letter');
}

#create PDO object
$host = 'itp460.usc.edu';
$database_name = 'dvd';
$username = 'student';
$password = 'ttrojan';
$pdo = new PDO("mysql:host=$host;dbname=$database_name", $username, $password);

#format and execute sql statement
$sql = "
  SELECT title, genres.genre_name as genre, formats.format_name as format, ratings.rating_name as rating, rating_id
  FROM dvds
  INNER JOIN genres
  ON genre_id = genres.id
  INNER JOIN formats
  ON format_id = formats.id
  INNER JOIN ratings
  ON rating_id = ratings.id
  AND ratings.rating_name = ?;
";
$statement = $pdo->prepare($sql);
$statement->bindParam(1, $rating);
$statement->execute();
$dvds = $statement->fetchAll(PDO::FETCH_OBJ);

#display number of rows and search query
$row_count = $statement->rowCount();
echo "$row_count movies with rating of $rating found</br></br>";

#display the search results
?><?php if ($row_count==0): ?>
  No results returned. <a href='index.php'>Return home</a>
<?php else: ?>
<table class='table table-striped'>
  <tr>
    <th>Title</th>
    <th>Genre</th>
    <th>Format</th>
    <th>Rating</th>
  </tr>
<?php foreach($dvds as $dvd): ?>
  <tr>
    <td><?=$dvd->title ?></td>
    <td><?=$dvd->genre ?></td>
    <td><?=$dvd->format ?></td>
    <td><a href='ratings.php?rating=<?=$dvd->rating ?>'><?=$dvd->rating ?></a></td>
  </tr>
<?php endforeach; ?>
</table>
<?php endif ?>
</body>
</html>
