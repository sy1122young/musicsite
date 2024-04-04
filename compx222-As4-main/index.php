<?php

// Setup error reporting
ini_set("error_reporting", E_ALL);
ini_set("log_errors", "1");
ini_set("error_log", "php_errors.txt");

// Include helper.php for some handy functions
include("php/helper.php");

// Load song list if exists, else error
if (file_exists('xml/song_list.xml')) {
    $songList = simplexml_load_file('xml/song_list.xml');
} else exit('Failed to open xml/song_list.xml');

// Convert the song list to an array of associative arrays
$songList = xmlSongsToAsscArray($songList);

// Get the current search. If the current search is not empty, then filter the song list by the current search
$search = "";
if (isset($_GET["search"])) {
    if (!($_GET["search"] == "")) {

        // Get the current search
        $search = trim($_GET["search"]);

        // Filter the song list by the current search
        $songList = song_array_search($songList, $search);
    }
}

// Set the current sort and sort the array
if (isset($_GET["sort"])) $sort = trim($_GET["sort"]);
else $sort = "Title";
$songList = array_sort_by_column($songList, $sort);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
    <script src="js/index.js" defer></script>

    <title>Music Database</title>
</head>

<body>
    <header>
        <!-- Left margin of the header (buffer for symmetric spacing) -->
        <div id="header-margin-left"></div>

        <!-- Center of the header. Holds everything related to search -->
        <div id="search-container">
            <div id="search-box" contenteditable data-placeholder="(untitled)">
                <!-- If something was searched, update the search box to match -->
                <?php echo $search; ?>
            </div>
            <div id="search-button">
                <img id="search-go-img" src="images/magnifying-glass.png" alt="">
            </div>
        </div>

        <!-- Right margin of the header -->
        <div id="header-margin-right">
            <!-- Dropdown -->
            <div class="dropdown open">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $sort; ?></button>
                <div class="dropdown-menu">
                    <a class="dropdown-item<?php if ($sort == "Title") echo " selected-item"; ?>">Title</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item<?php if ($sort == "Artist") echo " selected-item"; ?>">Artist</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item<?php if ($sort == "Album") echo " selected-item"; ?>">Album</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Grid of song cards -->
    <div class="grid-container">

        <?php

        // Draw each song to the page in the form of a card
        foreach ($songList as $song) {

            // Get the relevant fields from the current song (Doing it this way to circumvent errors in terms of templating)
            $title = $song['title'];
            $artist = $song['artist'];
            $album = $song['album'];
            $art = $song['art'];

            // Add the song card to the HTML
            echo
            "<div class='grid-item'>
                    <div class='img-wrap'>
                        <img src=$art alt=''>
                    </div>
                    <div class='info-wrap'>
                        <div class='field-1'><strong>Title: </strong><span>$title</span></div>
                        <div class='field-2'><strong>Artist: </strong><span>$artist</span></div>
                        <div class='field-3'><strong>Album: </strong><span>$album</span></div>
                    </div>
                </div>";
        }

        ?>

    </div>

    <!-- Gotta put bootstrap down here as requested by the docs -->
    <!-- Used for the toggle dropdown -->
    <!-- Popper JS -->
    <script src="js/bootstrap/pooper.min.js"></script>
    <!-- jquery needed for bootstrap -->
    <script src="js/jquery.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="js/bootstrap/bootstrap.min.js"></script>
</body>

</html>