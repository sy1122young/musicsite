<?php

/**
 * Converts the contents of an XML file to an array of associative arrays
 * @param array The raw XML data to be converted
 * @return array An array of associative arrays, generates from the XML data passed in
 */
function xmlSongsToAsscArray($songList) {

    $newSongList = array();

    foreach ($songList->children() as $song) {
        $newSongList[] = array(
            'title' => (string)$song->title,
            'artist' => (string)$song->artist,
            'album' => (string)$song->album,
            'year' => (int)$song->year,
            'genre' => (string)$song->genre,
            'art' => (string)$song->art
        );
    }

    // Return the converted song list
    return $newSongList;
}

/**
 * Takes in an array of songs and a string to search by.
 * Creates a new array and adds any song that has a match in any enumarable column
 * @param array An array of songs to filter by search
 * @param string The search to filter the array by
 * @return array The filtered song array
 */
function song_array_search($songList, $search) {

    // Declare an array of fields to search by
    $fieldList = array("title", "artist", "album");

    // Create a new song list
    $newSongList = array();

    // For each song in the song list, if a field matches the search result, then push the song to the new song list
    foreach ($songList as $song) {
        foreach ($fieldList as $field) {
            if (strpos(strtolower($song[$field]), strtolower($search)) !== false) {
                array_push($newSongList, $song);
                break;
            }
        }
    }

    // Return the filtered song list
    return $newSongList;
}

/**
 * Created a referenceArray with content from songs with only one column - the one given.
 * It's then sorted, then sorts the big song array using the referenceArray as reference
 * Takes in an array of songs. Creates a reference array
 * @param array An array of songs to filter by search
 * @param string The name of the column to sort the song array by
 * @return array The sorted song array
 */
function array_sort_by_column($songList, $column) {

    // Create a reference array for sorting 
    $refArray = array();

    // For each song in the song list, extract the field we want to sort by and put it into the reference array
    foreach ($songList as $key => $row) {
        $refArray[$key] = $row[strtolower($column)];
    }

    // Sort the song list, using the indexes in the reference array as a reference
    array_multisort($refArray, $songList);

    // Return the sorted song list
    return $songList;
}
