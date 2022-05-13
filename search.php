<?php

/**
 * @param $fileLink
 * @param $colNum
 * @param $searchString
 * @return string
 */
function find($fileLink, $colNum, $searchString)
{
    try {
        if (empty($fileLink)) {
            throw new Exception("Please specify the path to the file as the first parameter");
        }
        if (!file_exists($fileLink)) {
            throw new Exception(printf("File '%s' does not exist", $fileLink));
        }
        if ($file = fopen($fileLink, 'rb')) {
            if ('text/csv' !== mime_content_type( $file )) {
                throw new Exception("Please provide correct CSV file");
            }
            if (!isset($colNum)) {
                throw new Exception("Column number is required");
            }
            if ($colNum < 0 || $colNum > 3) {
                throw new Exception("Column number must be between 0 and 3");
            }
            if (empty($searchString)) {
                throw new Exception("Search string is required");
            }
            if (!is_numeric($colNum)) {
                throw new Exception("Column number has to be an integer");
            }

            $result = "Nothing found\r\n";
            while ($line = fgetcsv($file))
            {
                if (!empty($line[$colNum]) && strtolower($line[$colNum]) === strtolower($searchString)) {
                    $result = implode(',', $line) . ";\r\n";
                    break;
                }
            }
            fclose($file);
            return $result;
        }
        throw new Exception("File is invalid");
    } catch (Exception $e) {
        echo $e->getMessage() . "\r\n";
    }
}

function is_cli()
{
    if (defined('STDIN')) {
        return true;
    }
    if (empty($_SERVER['REMOTE_ADDR']) && !isset($_SERVER['HTTP_USER_AGENT']) && count($_SERVER['argv']) > 0) {
        return true;
    }
    return false;
}

if (is_cli()) {
    try {
        if (count($argv) !== 4) {
            throw new Exception("Three parameters are required: file link, column number and search string");
        }
        echo find($argv[1], $argv[2], $argv[3]);
    } catch(Exception $e) {
        echo $e->getMessage() . "\r\n";
    }
}