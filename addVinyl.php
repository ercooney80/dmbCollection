<?php
/**
 * @author Edward Cooney <ec789115@wcupa.edu>
 * File: addVinyl.php
 * Date: 05/17/2014
 * PHP version: 5.3
 * Description: Allows superuser to add new vinyl to the database.  
 * Redirected to VINYL TABLE
 * ToDo: Enable image stuff
 */
require_once "include/Session.php";
$session = new Session();

// Logged in SU only
if ($session->user == null || $session->user->level == 0) {
  die("You do not have permission to access this page");
}

require_once "include/DB.php";
DB::init();

$params = (object) $_REQUEST;

$years = DB::getYears();              // prod_year select
$categories = DB::getCategories();    // category select
$num_records = 8;                     // discs select
$size_pattern = '^[0-9]+[\"]$^';


// Add the item on click of add button  
if (isset($params->add)) {
  try {
    // Get values from params
    $artist = trim($params->artist);
    $title = trim($params->title);
    $records = $params->records;
    $country = trim($params->country);
    $condition = $params->condition;
    $year = $params->year;
    $tupc = str_replace(' ', '', trim($params->upc)); // No need for regex
    $upc = str_replace('-', '', $tupc);
    $category = $params->category;
    $vinyl_size = trim($params->vinyl_size);
    $description = trim($params->description);
    //$image = trim($params->image);
    // Validate
    if (empty($artist)) {
      throw new Exception("ARTIST IS EMPTY");
    }
    if (empty($title)) {
      throw new Exception("TITLE IS EMPTY");
    }
    if (empty($vinyl_size)) {
      throw new Exception("VINYL SIZE IS EMPTY");
    }
    if (!preg_match($size_pattern, $vinyl_size)) {
      throw new Exception("VINYL SIZE FORMATTED WRONG");
    }
    if (empty($upc)) {
      $upc = 'n/a';
    }


    // Create the vinyl
    $vinyl = R::dispense('vinyl');
    $vinyl->artist = $artist;
    $vinyl->title = $title;
    $vinyl->records = $records;
    $vinyl->country = $country;
    $vinyl->cond = $condition;
    $vinyl->prod_year = $year;
    $vinyl->upc = $upc;
    $vinyl->category = $category;
    $vinyl->vinyl_size = $vinyl_size;
    $vinyl->description = $description;
    //$vinyl->image = $image;
    $vinyl->created_at = time();
    R::store($vinyl);

    // Added in case DB needs rebuilt
    // Note that time is not madatory.  It is only used in frontpage
    $file = 'setup/vinyl.txt';
    $entry = "$artist | $title | $records | $country | $condition | $year | $category | $vinyl_size | $upc | $description\n";
    file_put_contents($file, $entry, FILE_APPEND);
    // go to vinyl table
    header("location: vinyl.php");
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
  $params->vinyl_size = "";
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
    <title>Admin - Add Vinyl</title>
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

      <h2>Add Vinyl</h2>
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
          <th>vinyl size:</th>
          <td><input type="text" name="vinyl_size"
                     value="<?php echo htmlspecialchars($params->vinyl_size) ?>" />
          </td>
          </tr>
          <tr>
            <th>records:</th>
            <td>
              <select required name="records">
                <?php for ($i = 1; $i < ($num_records + 1); $i++): ?>
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
            <td><input style="width: 5em" type="radio" name="condition" value="sealed">Sealed
              <input style="width: 5em" checked type="radio" name="condition" value="opened">Opened</td>            
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
  /* local JavaScript */
</script>
<footer id="footer"><?php require_once 'footer.php'; ?></footer>
</body>
</html>