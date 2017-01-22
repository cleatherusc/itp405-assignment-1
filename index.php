<!DOCTYPE html>
<html>
<head>
  <title>Search</title>
  <script>
    function validateEntry() {
      var x = document.forms["form"]["title"].value;
      if (x.search(/\W+/)!=-1) {
        alert("Only use alphanumeric characters in the search box.");
        return false;
      }
    }
  </script>
</head>
<body>
<form name="form" method="get" action="dvd.php" onsubmit="return validateEntry()">
  Title: <input type="text" name="title">
  <input type="submit" value="Search">
</form>

</body>
</html>
