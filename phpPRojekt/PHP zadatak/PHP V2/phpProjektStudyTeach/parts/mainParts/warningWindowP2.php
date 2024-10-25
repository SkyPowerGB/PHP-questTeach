<script>
closeWrn();
function showWarning($msg){
  warn($msg);
}
function showMessage($msg){
  ok($msg);
}
</script>
<?php
function showWarning($msg){
  echo("<script> showWarning('$msg'); </script>");
}
function showMessage($msg){
  echo("<script> ok('$msg'); </script>");
}
?>