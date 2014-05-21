<?php

$users_file = "setup/users.txt";
if (!file_exists($users_file)) {
  die("missing file $users_file\n");
}

require_once "include/DB.php";
$props = DB::init();
echo "\naddUsers -- url: {$props['url']}\n\n";

$users = file($users_file);

// populate table by reading file
foreach ($users as $str) {
  $info = trim($str);
  if (empty($info))
    continue;
  if (substr($info, 0, 1) == "#") // skip comment line
    continue;
  list($name, $email, $password, $level) = array_map('trim', explode("|", $info));
  echo "$name | $email | " . sha1($password) . " | $level\n";
  $user = R::dispense('user');
  $user->name = $name;
  $user->email = $email;
  $user->password = sha1($password);
  $user->level = $level;
  try {
    $id = R::store($user);
    echo "#$id: $name\n";
  } catch (Exception $ex) {
    echo $ex->getMessage(), "\n";
  }
}
