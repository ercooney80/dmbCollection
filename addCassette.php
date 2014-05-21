<?php
/**
 * @author Edward Cooney <ec789115@wcupa.edu>
 * File: addCassette.php
 * Date: 05/17/2014
 * PHP version: 5.3
 * Description: Allows superuser to add new cassette to the database.  
 * Redirected to CASSETTE TABLE
 * ToDo: Enable image stuff
 */
require_once "include/Session.php";
$session = new Session();
require_once "include/DB.php";
DB::init();
$params = (object) $_REQUEST;

// Logged in SU only
if ($session->user == null || $session->user->level == 0) {
  die("You do not have permission to access this page");
}

$years = DB::getYears();              // prod_year select
$categories = DB::getCategories();    // category select
$num_tapes = 6;                       // tapes select

// Add the item on click of add button  
if (isset($params->add)) {
  try {
    // Get values from params
    $artist = strtoupper(trim($params->artist));
    $title = strtoupper(trim($params->title));
    $tapes = $params->tapes;
    $country = strtoupper(trim($params->country));
    if (isset($params->condition)) {
      $condition = $params->condition;
    } else {
      throw new Exception("NO CONDITION SELECTED");
    }
    $year = $params->year;
    if (empty($params->upc)) {
      $upc = 'n/a';
    } else {
      $upc = str_replace(' ', '', trim($params->upc)) ;
      $upc = str_replace('-', '', $upc);
    }
    $upc = strtoupper($upc);
    $category = $params->category;
    $description = strtoupper(trim($params->description));
    //$image = trim($params->image);
    
    // Validate
    if (empty($artist)) {
      throw new Exception("ARTIST IS EMPTY");
    }
    if (empty($title)) {
      throw new Exception("TITLE IS EMPTY");
    } 
    if (empty($country)) {
      throw new Exception("COUNTRY IS EMPTY");
    }
    
    // Create the cassette
    $cassette = R::dispense('cassette');
    $cassette->artist = $artist;
    $cassette->title = $title;
    $cassette->tapes = $tapes;
    $cassette->country = $country;
    $cassette->cond = $condition;
    $cassette->prod_year = $year;
    $cassette->upc = $upc;
    $cassette->category = $category;
    $cassette->description = $description;
    //$cassette->image = $image;
    $cassette->created_at = time();
    R::store($cassette);

    // Added in case DB needs rebuilt
    $file = 'setup/cassettes.txt';
    $entry = "$artist | $title | $tapes | $country | $condition | $year | $upc | $category | $description\n";
    file_put_contents($file, $entry, FILE_APPEND);
    // go to cassette table
    header("location: cassettes.php");
    exit();
  } catch (Exception $ex) {
    $message = $ex->getMessage();
  }
} else {
  $message = "";
  $params->artist = "";
  $params->title = "";
  $params->country = "";
  $params->upc = "";
  $params->description = "";
  $params->image = "";
  
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
  "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <title>Admin - Add Cassette</title>
    <link rel="stylesheet" type="text/css" href="css/superfish.css" />
    <link rel="stylesheet" type="text/css" href="css/layout.css" />
     <link rel="stylesheet" type="text/css" href="css/form-layout.css" />
    <style type="text/css">
      
    </style>  
  </head>
  <body>
  <section class="container">
    <header class="header"><?php require_once "include/header.php" ?></header>
    <section class="navigation"><?php require_once "include/navigation.php" ?></section>
    <section class="content"><!-- content -->
      
        <h2>Add Cassette</h2>
        <h3 class="message" ><?php echo htmlspecialchars($message) ?></h3>
        <form name="add" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
          <table class="formtable">
            <tr>
              <th>artist:</th>
                <td><input type="text" name="artist"
                  value="<?php echo htmlspecialchars($params->artist) ?>" />
                </td>
            </tr>
            <tr>
              <th>title:</th>
                <td><input type="text" name="title"
                  value="<?php echo htmlspecialchars($params->title) ?>" />
                </td>
            </tr>
            <tr>
              <th>tapes:</th>
              <td>
                <select required name="tapes">
                 <?php for ($i = 1; $i < ($num_tapes + 1); $i++): ?>
                  <option value="<?php echo "$i" ?>"><?php echo $i; ?></option>      
                    <?php endfor; ?>
                </select>    
              </td>
            </tr>
            <tr>
              <th>country:</th>
                <td><input type="text" name="country"
                  value="<?php echo htmlspecialchars($params->country) ?>" />
                </td>
            </tr>
            <tr>
              <th>condition:</th> 
              <td><input style="width: 5em" type="radio" name="condition" value="SEALED">SEALED
                <input style="width: 5em" type="radio" name="condition" value="OPENED">OPENED</td>            
            </tr>
            <tr>
              <th>year:</th>
              <td>
                <select required name="year">
                  <?php foreach ($years as $year): ?>
                  <option value="<?php echo "$year" ?>"><?php echo htmlspecialchars($year); ?></option>
                  <option
                    <?php endforeach; ?>
                </select>              
            </td>
            </tr>
            <tr>
              <th>upc/cat#:</th>
                <td><input type="text" name="upc"
                  value="<?php echo htmlspecialchars($params->upc) ?>" />
                </td>
            </tr>
            <tr>
              <th>category:</th>
              <td>
                <select required name="category">
                  <?php foreach ($categories as $category): ?>
                    <option><?php echo htmlspecialchars($category); ?></option>
                    <?php endforeach; ?>
                </select>
              </td>  
            </tr>
            <tr>
              <th>description:</th>
              <td>
                <textarea  rows="15" cols="50"  type="text" name="description"><?php
                  echo htmlspecialchars($params->description)
                  ?></textarea>    
              </td>
            </tr>
            <tr>
              <th>image:</th>
              <td><input type="text" name="image" 
                         value="<?php echo htmlspecialchars($params->image) ?>" />
              </td>
            </tr>
            <tr>
              <td></td>
              <td><button type="submit" name="add">Add Item</button></td>
            </tr>
          </table>
        </form>
      </section><!-- content -->

  </section><!-- container -->
  <script type="text/javascript" src="js/textlength.js"></script>
  <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
  <script type="text/javascript" src="js/superfish.min.js"></script>
  <script type="text/javascript" src="js/init.js"></script>
  <script type="text/javascript">
    $(function() {
        $("button[name='add']").click(function() {
          return confirm("Are you sure?");
        });
      });
  </script>
  <footer id="footer"><?php require_once 'footer.php'; ?></footer>
</body>
</html>