<?php
//require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class CsvConverter
{

    public function convert($file_path, $filename)
    {

        $parser = new \Smalot\PdfParser\Parser();
        $pdf = $parser->parseFile($file_path);
        $spreadsheet = new Spreadsheet();
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();

        $string = str_replace('/"/g', '""', str_replace("\n", "<br/>", $pdf->getText()));
        chmod($file_path, 0777);
        unset($csv[0]);

        $fp = fopen('./documents/' . $filename . '.xlsx', 'w');
        // check its permission .
        chmod('./documents/' . $filename . '.xlsx', 0777);
        //input the title
        $title = array(
            array("UGANDA NATIONAL METEOROLOGICAL AUTHORITY"),
            array("NATIONAL METEOROLOGICAL CENTRE - ENTEBBE"),
            array($this->clean_ascii_characters("P.O. BOX 7025 – KAMPALA / BOX 3 ENTEBBE")),
            array("Tel. +256 414 25 1798, +256 414 320920 Fax. +256 414 251797, Email: exdir@unma.go.ug"),
            array("Website : www.unma.go.ug"));
        foreach ($title as $line) {
            fputcsv($fp, $line, $delimiter = ',', $enclosure = '"', $escape_char = "\\");
        }
        //print($string);

        // check if empty.
        if (!empty($string)) {

            $string = explode("<br/>", $string);

            $typeofforecast = preg_replace("/[^A-Z]+/", "", $string[0]);

            $typeofforecast = str_replace(' ', '', $typeofforecast);

            if (strcmp($typeofforecast, "DAILYWEATHERFORECAST") == 0) {

                foreach ($string as $key => $line) {

                    $cond = str_replace(' ', '', preg_replace("/[^A-Z]+/", "", $line));
                    if (strcmp($cond, "REGIONWEATHER") == 0) {
                        $table_header = array("REGION", "WEATHER \n ELEMENT",
                            $this->clean_ascii_characters($string[$key + 2]) . "\n" . $this->clean_ascii_characters($string[$key + 3]) . "\n" . $this->clean_ascii_characters($string[$key + 4]),
                            $this->clean_ascii_characters($string[$key + 5]) . "\n" . $this->clean_ascii_characters($string[$key + 6]) . "\n" . $this->clean_ascii_characters($string[$key + 7])
                            , $this->clean_ascii_characters($string[$key + 8]) . "\n" . $this->clean_ascii_characters($string[$key + 9]) . "\n" . $this->clean_ascii_characters($string[$key + 10]),
                            $this->clean_ascii_characters($string[$key + 11]) . "\n" . $this->clean_ascii_characters($string[$key + 12]) . "\n" . $this->clean_ascii_characters($string[$key + 13]),
                        );

                        fputcsv($fp, $table_header, $delimiter = ',', $enclosure = '"', $escape_char = "\\");
                        for ($i = $key; $i <= $key + 13; $i++) {
                            unset($string[$i]);

                        }
                        break;
                    }
                    fputcsv($fp, array($this->clean_ascii_characters($line)), $delimiter = ',', $enclosure = '"', $escape_char = "\\");
                    unset($string[$key]);

                }
                foreach ($string as $key => $line) {
                    $cond1 = str_replace(' ', '', preg_replace("/[^a-zA-Z0-9]+/", "", $line));
                    foreach ($title as $row) {
                        $cond2 = str_replace(' ', '', preg_replace("/[^a-zA-Z0-9]+/", "", $row[0]));
                        if (strcmp($cond1, $cond2) == 0) {
                            unset($string[$key]);
                        }
                    }
                }

                $string = array_filter($string, 'strlen');

                $counter = 1;
                $array = array();
                $area = "";
                $direction = array();
                $strength = array();
                $weather = null;
                $weather_desc = array();
                $temperature = array();
                $previous = null;

                foreach ($string as $key => $line) {
                    $test = preg_replace("/[^a-zA-Z0-9]+/", "", $line);
                    if (empty($test)) {
                        continue;

                    }
                    $next = null;
                    if (isset($string[$key + 1])) {
                        $next = $string[$key + 1];

                    }

                    if (strcmp("Weather", $test) == 0 || strcmp("Weatherdescription", $test) == 0
                        || $weather != null
                    ) {

                        $type = $weather ? $line : preg_replace("/[^a-zA-Z0-9]+/", "", $this->clean_ascii_characters(
                            $string[$key] . $next));

                        if (strcmp("Weatherdescription", $type) == 0) {
                            $string[$key + 1] = "";
                            unset($string[$key + 1]);
                            $weather = "continue";
                            $weather_desc = array_filter($weather_desc);
                            array_push($weather_desc, $area);
                            array_push($weather_desc, "Weather \n description");

                            continue;
                        }
                        if (strpos($this->clean_ascii_characters($line), "description") !== false) {
                            continue;
                        }
                        $description = null;
                        if (strpos($string[$key + 1], "Temperatures") !== false) {
                            $weather = null;
                            $description = $string[$key];
                        } else {
                            $weather = "continue";
                            $description = $this->clean_ascii_characters($string[$key]) . "\n" . $this->clean_ascii_characters($string[$key + 1]);
                            if (!empty(preg_replace("/[^a-zA-Z0-9]+/", "", $string[$key + 1]))) {

                                $string[$key + 1] = "";
                            }

                        }
                        $weather_desc = array_filter($weather_desc);
                        if (!empty($description)) {
                            array_push($weather_desc, $this->clean_ascii_characters($description));

                        }

                    } else if (strpos($line, "Temperatures") !== false) {

                        $line = $this->clean_ascii_characters($line);
                        $line = str_replace("C", "°C", $line);
                        $row = explode(" ", $line);
                        array_push($temperature, "");
                        $row = array_filter($row);
                        $temperature = array_merge($temperature, $row);

                    } else if (strpos(preg_replace("/[^a-zA-Z0-9]+/", "",
                        $this->clean_ascii_characters($line) . $this->clean_ascii_characters($next)),
                        "Winddirection") !== false) {

                        $row = explode(" ", $this->clean_ascii_characters($string[$key + 2]));
                        array_push($direction, "");
                        array_push($direction, "Wind");
                        $row = array_filter($row);
                        $direction = array_merge($direction, $row);

                    } else if (strpos(preg_replace("/[^a-zA-Z0-9]+/", "",
                        $this->clean_ascii_characters($line) . $this->clean_ascii_characters($next)), "Windstrength") !== false
                        || strpos($test, "Windstrength") !== false) {
                        if (strpos($test, "Windstrength") !== false) {

                            $row = explode(" ", $this->clean_ascii_characters($line));
                            array_push($strength, " ");
                            array_push($strength, "Wind strength");
                            $row = array_filter($row);
                            $strength = array_merge(array_filter($strength), array_slice($row, 2));
                            // print_r(array_slice($row, 2));

                        } else {
                            if (isset($string[$key + 2])) {
                                $row = explode(" ", $this->clean_ascii_characters($string[$key + 2]));
                                array_push($strength, " ");
                                array_push($strength, "Wind strength");
                                $row = array_filter($row);
                                $strength = array_merge(array_filter($strength), $row);
                            }

                        }

                        $weather_line = array();
                        foreach ($weather_desc as $t => $word) {
                            $test = preg_replace("/[^a-zA-Z0-9]+/", "", $this->clean_ascii_characters($word));
                            if (empty($test)) {
                                continue;

                            }
                            array_push($weather_line, $word);
                        }
                        $data = array(
                            $weather_line,
                            $temperature,
                            $direction,
                            $strength,
                        );

                        foreach ($data as $i) {
                            fputcsv($fp, $i, $delimiter = ',', $enclosure = '"', $escape_char = "\\");
                        }
                        $weather_desc = array();
                        $temperature = array();
                        $direction = array();
                        $strength = array();
                        $area = "";

                    } else {

                        // array_push($array, $line);
                        $area = $this->clean_ascii_characters($area);
                        $area = $area . "\n" . $this->clean_ascii_characters($line);

                    }

                }

            }
            

            //check for which type of forecast.
            if (strcmp($typeofforecast, "SIXHOURLYDAILYWEATHERUPDATE") == 0) {

                foreach ($string as $key => $line) {
                    fputcsv($fp, array($this->clean_ascii_characters($line)), $delimiter = ',', $enclosure = '"', $escape_char = "\\");
                    $cond = str_replace(' ', '', preg_replace("/[^A-Z]+/", "", $line));
                    if (strcmp($cond, "REGIONWEATHERFORECAST") == 0) {
                        unset($string[$key]);
                        break;
                    }
                    unset($string[$key]);

                }
                // remove the title from the string.
                foreach ($string as $key => $line) {
                    $cond1 = str_replace(' ', '', preg_replace("/[^a-zA-Z0-9]+/", "", $line));
                    //echo $line."<br/><br/>";
                    foreach ($title as $row) {
                        $cond2 = str_replace(' ', '', preg_replace("/[^a-zA-Z0-9]+/", "", $row[0]));
                        //echo $row[0]."<br/><br/>";
                        if (strcmp($cond1, $cond2) == 0) {
                            unset($string[$key]);
                        }
                    }
                }

                $string = array_filter($string, 'strlen');

                $counter = 1;
                $array = array();
                $direction = null;
                $strength = null;
                $reason = null;
                $temperature = null;
                $previous = null;

                foreach ($string as $key => $line) {
                    $test = preg_replace("/[^a-zA-Z0-9]+/", "", $line);
                    if (empty($test)) {
                        continue;

                    }
                    if (strcmp("Weatherdescription", $test) == 0 || $previous == "Weatherdescription") {
                        if (strcmp("Weatherdescription", $test) == 0) {
                            $previous = "Weatherdescription";

                        } else {
                            $reason =$this->clean_ascii_characters($line);
                            $previous = "";
                        }

                    } else if (strpos($line, "Temperatures") !== false) {
                        $row = explode(" ", $this->clean_ascii_characters($line));
                        $temperature =$row[1]."°C";

                    } else if (strpos($test, "Winddirection") !== false) {

                        $row = $this->strSplit($line, 2, " ");
                        $direction = $this->clean_ascii_characters($row[1]);

                    } else if (strpos($test, "Windstrength") !== false) {

                        $row = $this->strSplit($line, 2, " ");
                        $strength = $this->clean_ascii_characters($row[1]);

                        $data = array(
                            array((string) isset($array[0]) ? $array[0] : "", "Weather description", $reason),
                            array((string) isset($array[1]) ? $array[1] : "", "Temperatures", $temperature),
                            array((string) isset($array[2]) ? $array[2] : "", "Wind direction", $direction),
                            array((string) isset($array[3]) ? $array[3] : "", "Wind strength", $strength),
                        );

                        foreach ($data as $i) {
                            fputcsv($fp, $i, $delimiter = ',', $enclosure = '"', $escape_char = "\\");
                        }
                        array_splice($array, 0);

                    } else {

                        array_push($array, $line);

                    }

                }
                fclose($fp);

            }

            /* Set CSV parsing options */
            $reader->setDelimiter(',');
            $reader->setEnclosure('"');
            $reader->setSheetIndex(0);
            /* Load a CSV file and save as a XLS */
            $spreadsheet = $reader->load('./documents/' . $filename . '.xlsx');
            $writer = new Xlsx($spreadsheet);
            $writer->save('./documents/' . $filename . '.xlsx');
            $spreadsheet->disconnectWorksheets();
            unset($spreadsheet);
        }else{
            echo "Unable to upload";
        }

// Common functions

    }
    public function clean_ascii_characters($string)
    {
        $string = str_replace(array('-', '–'), '-', $string);
        $string = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $string);

        return $string;
    }
    public function strSplit($source, $index, $delim)
    {
        $outStr[0] = $source;
        $outStr[1] = '';

        $partials = explode($delim, $source);

        if (isset($partials[$index]) && strlen($partials[$index]) > 0) {
            $splitPos = strpos($source, $partials[$index]);

            $outStr[0] = substr($source, 0, $splitPos - 1);
            $outStr[1] = substr($source, $splitPos);
        }

        return $outStr;
    }

}
