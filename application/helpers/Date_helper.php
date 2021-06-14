<?php

function get_week_now()
{
  $date = new stdClass();
  $number_now = date("d");
  $day = date("D");
  if ($day == "Sun") {
    $now = $number_now;
    $next = $number_now + 6;
  } else if ($day == "Mon") {
    $now = $number_now - 1;
    $next = $number_now + 5;
  } else if ($day == "Tue") {
    $now = $number_now - 2;
    $next = $number_now + 4;
  } else if ($day == "Wed") {
    $now = $number_now - 3;
    $next = $number_now + 3;
  } else if ($day == "Thu") {
    $now = $number_now - 4;
    $next = $number_now + 2;
  } else if ($day == "Fri") {
    $now = $number_now - 5;
    $next = $number_now + 1;
  } else if ($day == "Sat") {
    $now = $number_now - 6;
    $next = $number_now;
  }
  if ($now < 10) {
    $now = "0$now";
  }
  if ($next < 10) {
    $next = "0$next";
  }
  $date->start = date("Y-m-$now");
  $date->end = date("Y-m-$next");
  return $date;
}

function day_ind($day)
{
  if ($day == "Sun") {
    $hari = "Minggu";
  } else if ($day == "Mon") {
    $hari = "Senin";
  } else if ($day == "Tue") {
    $hari = "Selasa";
  } else if ($day == "Wed") {
    $hari = "Rabu";
  } else if ($day == "Thu") {
    $hari = "Kamis";
  } else if ($day == "Fri") {
    $hari = "Jum'at";
  } else if ($day == "Sat") {
    $hari = "Sabtu";
  }
  return $hari;
}

function month_ind($month) {
  if ($month == "Jan") {
    $bulan = "Januari";
  } else if ($month == "Feb") {
    $bulan = "Februari";
  } else if ($month == "Mar") {
    $bulan = "Maret";
  } else if ($month == "Apr") {
    $bulan = "April";
  } else if ($month == "May") {
    $bulan = "Mei";
  } else if ($month == "Jun") {
    $bulan = "Juni";
  } else if ($month == "Jul") {
    $bulan = "Juli";
  } else if ($month == "Aug") {
    $bulan = "Agustus";
  } else if ($month == "Sep") {
    $bulan = "September";
  } else if ($month == "Oct") {
    $bulan = "Oktober";
  } else if ($month == "Nov") {
    $bulan = "November";
  } else if ($month == "Dec") {
    $bulan = "Desember";
  }
  return $bulan;
}