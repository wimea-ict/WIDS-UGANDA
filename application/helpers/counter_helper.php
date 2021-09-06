<?php defined('BASEPATH') OR exit('No direct script access allowed.');

if ( ! function_exists('count_visitor')) {
    function count_visitor()
    {
        $filecounter=(APPPATH . 'logs/counter.txt');
        $kunjungan=file($filecounter);
        $kunjungan[0]++;
        $file=fopen($filecounter, 'w');
        fputs($file, $kunjungan[0]);
        fclose($file);
        return $kunjungan[0];
    }
}
?>