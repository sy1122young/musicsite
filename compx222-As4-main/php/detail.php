<?php

// Setup error reporting
ini_set("error_reporting", E_ALL);
ini_set("log_errors", "1");
ini_set("error_log", "php_errors.txt");

// Include helper.php for some handy functions
include("helper.php");

// Load song list if exists, else error
if (file_exists('../xml/song_list.xml')) {
    $songList = simplexml_load_file('../xml/song_list.xml');
} else exit('Failed to open ../xml/song_list.xml');

// Convert the song list to an array of associative arrays
$songList = xmlSongsToAsscArray($songList);

// Get the title and artist of the song we want to display
$title = $_GET["title"];
$artist = $_GET["artist"];

// Get a song from the song list that matches the title and artist exactly
$song = array();
foreach ($songList as $currentSong) {
    if ($currentSong["title"] == $title && $currentSong["artist"] == $artist) {
        $song = $currentSong;
        break;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/detail.css">
    <title><?php echo $title . " - " . $artist ?></title>
</head>

<body>
    <!-- Musical notes -->
    <?php include("../html/notes.html") ?>

    <!-- Song card -->
    <div id="card">
        <div class='img-wrap'>
            <img alt='' src=<?php echo "../".$song["art"] ?>>
        </div>
        <div class='info-wrap'>
            <div class='field-1'><strong>Title: </strong><span><?php echo $song["title"] ?></span></div>
            <div class='field-2'><strong>Artist: </strong><span><?php echo $song["artist"] ?></span></div>
            <div class='field-3'><strong>Album: </strong><span><?php echo $song["album"] ?></span></div>
            <div class='field-4'><strong>Year: </strong><span><?php echo $song["year"] ?></span></div>
            <div class='field-5'><strong>Genre: </strong><span><?php echo $song["genre"] ?></span></div>
        </div>
    </div>

    <!-- Musical notes -->
    <?php include("../html/notes.html") ?>
</body>

</html>