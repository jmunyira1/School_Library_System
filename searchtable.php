
<?php
  if ($page=="viewbookrecords.php"||$page=="viewbook.php") {
    $number=3;
    $message="Search for book serial...";
  }
  elseif($page=="viewbook.php") {
    $number=2;
    $message="Search for book serial...";
  }
  elseif($page=="viewissuedbook.php") {
    $number=3;
    $message="Search for book serial...";
  }
  elseif($page=="recievebooks.php"){
    $number=2;
    $message="Search for serial...";
  }
elseif($page=="viewbook.php"){
    $number=2;
    $message="Search for serial...";
  }
  elseif($page=="deletebookrecords.php"){
    $number=1;
    $message="Search for serial...";
  }
  elseif($page=="viewstaff.php"){
    $number=1;
    $message="Search by name...";
  }
  

  else{
    $number=0;
    $message="Search for book titles..";
    if ($page=="viewstudents.php") {
        $message="Search for Admission...";
        $number=0;
    }
    
  }

?>
<input type="text" class="form-control" id="myInput" onkeyup="myFunction()" placeholder="<?php echo $message; ?>" autocomplete="off">

<script>
function myFunction() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[<?php echo $number?>];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
</script>