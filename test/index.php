<!DOCTYPE html>
<html>
<head>
<title>How to create searchable select box</title>
<!-- JS for jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- CSS for searching -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- JS for searching -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
// .js-example-basic-single declare this class into your select box
$(document).ready(function() {
    $('.js-example-basic-single').select2();
});
</script>
</head>
<body>

<h1>How to create searchable select box</h1>

<label for="cars">Choose a car:</label>

<select name="cars" id="cars" class="js-example-basic-single">
  <option value="volvo">Volvo</option>
  <option value="saab">Saab</option>
  <option value="mercedes">Mercedes</option>
  <option value="audi">Audi</option>
</select> 

</body>
</html> 