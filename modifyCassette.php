<?php
/**
 * @author Edward Cooney <ec789115@wcupa.edu>
 * File: modfiyCassette.php
 * Date: 05/17/2014
 * PHP version: 5.3
 * Description: Allows superuser to modify a cassette already in database.  
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

$cassette = R::load('cassette', $params->id);

if ($cassette->id == 0) {
  die("no such cassette for id $params->id");
}

$old_entry = "$cassette->artist | $cassette->title | $cassette->tapes | "
        . "$cassette->country | $cassette->cond | $cassette->prod_year | "
        . "$cassette->upc | $cassette->category | $cassette->description";

// Modify the item on click of modify button  
if (isset($params->modify)) {
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
    R::store($cassette);

    // Added in case DB needs rebuilt
    // Here we replace the old entry with the new entry
    $file = 'setup/cassettes.txt';  // file name
    $contents = file($file);  // contents of file to array
    $contents = array_map('strtoupper',$contents);
    $new_entry = "$artist | $title | $tapes | $country | $condition | "
            . "$year | $upc | $category | $description";
    $new_entry = trim($new_entry);
    $old_entry = trim($old_entry);
    $contents = array_map('strtoupper',$contents);
    $count = 1; // Only replace 1 occurance
    $contents = str_replace($old_entry, $new_entry, $contents, $count);
    file_put_contents($file, $contents, LOCK_EX);
    // go to cassette table
    header("location: cassettes.php");
    exit();
  } catch (Exception $ex) {
    $message = $ex->getMessage();
  }
} else {
  $message = "";
  $params->artist = $cassette->artist;
  $params->title = $cassette->title;
  $params->tapes = $cassette->tapes;
  $params->country = $cassette->country;
  $params->condition = $cassette->cond;
  $params->year = $cassette->prod_year;
  $params->upc = $cassette->upc;
  $params->category = $cassette->category;
  $params->description = $cassette->description;
  $params->image = $cassette->image;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
  "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <title>Admin - Modify Cassette</title>
    <link rel="stylesheet" type="text/css" href="css/superfish.css" />
    <link rel="stylesheet" type="text/css" href="css/layout.css" />
     <link rel="stylesheet" type="text/css" href="css/form-layout.css" />
    <style type="text/css">
      
    </style>  
  </head>
  <body >
  <section class="container">
    <header class="header"><?php require_once "include/header.php" ?></header>
    <section class="navigation"><?php require_once "include/navigation.php" ?></section>
    <section class="content"><!-- content -->   
        <h2>Modify Cassette</h2>
        <h3 class="message" ><?php echo htmlspecialchars($message) ?></h3>
        <form name="add" action="" method="post">
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
                  <option 
                    <?php if ($i == $params->tapes): ?>
                       selected ="<?php echo $i; ?>"
                    <?php endif; ?>
                    value="<?php echo "$i" ?>"><?php echo $i; ?></option>          
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
              <td>
                <input style="width: 3em" 
                         <?php if ($params->condition == "SEALED"): ?>
                            checked
                         <?php endif; ?>
                         type="radio" name="condition" value="SEALED">Sealed
                <input style="width: 3em" 
                         <?php if ($params->condition == "OPENED"): ?>
                            checked
                         <?php endif; ?>
                         type="radio" name="condition" value="OPENED">Opened
              </td>            
            </tr>
            <tr>
              <th>year:</th>
              <td>
                <select required name="year">
                  <?php foreach ($years as $year): ?>
                  <option 
                    <?php if ($year == $params->year): ?>
                       selected ="<?php echo $year; ?>"
                    <?php endif; ?>                   
                    value="<?php echo "$year" ?>"><?php echo htmlspecialchars($year); ?></option>
              
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
                    <option 
                    <?php if ($category == $params->category): ?>
                       selected ="<?php echo $category; ?>"
                    <?php endif; ?>
                      ><?php echo htmlspecialchars($category); ?></option>
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
           </table>
            <table class="changer">
            <tr>
              <td></td>
              <td><button class="button" type="submit" name="modify">Modify Item</button></td>
              <td><button class="button" type="reset" name="reset">Reset</button></td>
              <td></td>
              <td></td>
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
        $("button[name='modify']").click(function() {
          return confirm("Are you sure?");
        });
      });
  </script>
  <footer id="footer"><?php require_once 'footer.php'; ?></footer>
</body>
</html>