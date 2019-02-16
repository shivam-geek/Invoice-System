<?php
require 'include/currency_converter.php';
// FINANCIAL DATE Generator
function financialDateGen($date)
{
    $d = date_parse("d/m/y", $date);

    $year_current = str_replace("20", "", $d['year']);

    if ($d["month"] > 3) {
        $year_previous = $year_current;
        $year_next = $year_current+ 1;
        return array("year_previous" => $year_previous, "year_next" => $year_next);
    } else {
        $year_previous = $year_current - 1;
        $year_next = $year_current;
        return array("year_previous" => $year_previous, "year_next" => $year_next);
    }
}


// Currency Convert

function currencyConverter($data) {
    $total_calc = $data;
    $total_calc_list = number_format($total_calc,2);
    $total_calc_list = str_replace(",", "", $total_calc_list);

     list($rupees, $paise) = explode('.', $total_calc_list);

     $rupees = (int) $rupees;
     $paise = (int) $paise;

       require_once 'include/currency_converter.php';

      if($total_calc == 0) {
          $total_calc_word = "Zero Rupees";
      } else {

          $total_calc_rupees = currencyConvert($rupees);
          if($paise == 0) {
              $total_calc_pasie = "Zero";
          } else {
              $total_calc_pasie = currencyConvert($paise);
          }
          $total_calc_word = $total_calc_rupees." Rupees and ".$total_calc_pasie." Paise only";
      }

      return $total_calc_word;

}



