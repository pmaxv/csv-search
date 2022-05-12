<?php

/**
 * @param $data
 * @return string
 */
function find(Array $data)
{
    if (empty($data[1])) {
        return "Please specify the path to the file as the first parameter\r\n";
    }
    if (!file_exists($data[1])) {
        return printf("File '%s' does not exist\r\n", $data[1]);
    }
    if ($file = fopen($data[1], 'rb')) {
        if ('text/csv' !== mime_content_type( $file )) {
            return "Please provide correct CSV file\r\n";
        }
        if (!isset($data[2])) {
            return "Second argument is required\r\n";
        }
        if ($data[2] < 0 || $data[2] > 3) {
            return "Second argument must be between 0 and 3\r\n";
        }
        if (empty($data[3])) {
            return "Third argument is required\r\n";
        }
        if (!is_numeric($data[2])) {
            return "Second argument has to be an integer\r\n";
        }

        $result = "Nothing found\r\n";
        while ($line = fgetcsv($file))
        {
            if (!empty($line[$data[2]]) && strtolower($line[$data[2]]) === strtolower($data[3])) {
                $result = implode(',', $line) . ";\r\n";
                break;
            }
        }
        fclose($file);
        return $result;
    }
    return "File is invalid\r\n";
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
    echo find($argv);
}