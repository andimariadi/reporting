<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
* 
*/
function get_percent($value, $value2) {
	$result = number_format(($value/$value2)*100, 2);
	return $result;
}

function get_paging_info($tot_rows,$pp,$curr_page) {
$pages = ceil($tot_rows / $pp); // calc pages

$data = array(); // start out array
$data['si']        = ($curr_page * $pp) - $pp; // what row to start at
$data['pages']     = $pages;                   // add the pages
$data['curr_page'] = $curr_page;               // Whats the current page

return $data; //return the paging data

}

function selisih($start, $end) {
	$awal  = new DateTime($start);
	$akhir  = new DateTime($end);
	if ($awal > $akhir) {
		$akhir->modify('+1 day');
		$selisih = $akhir->diff($awal);
	} else {
		$selisih = $akhir->diff($awal);
	}

	$jam = $selisih->format('%h');
	$menit = $selisih->format('%i');
	$detik = $selisih->format('%s');
	if($menit >= 0 && $menit <= 9){
		$menit = "0".$menit;
	}
	if($jam >= 0 && $jam <= 9){
		$jam = "0".$jam;
	}
	if($detik >= 0 && $detik <= 9){
		$detik = "0".$detik;
	}
	$hasil = $jam.":".$menit.":".$detik;
	return $hasil;
}

function time_elapsed_string($datetime, $full = false) {
	$now = new DateTime;
	$ago = new DateTime($datetime);
	$diff = $now->diff($ago);

	$diff->w = floor($diff->d / 7);
	$diff->d -= $diff->w * 7;

	$string = array(
		'y' => 'year',
		'm' => 'month',
		'w' => 'week',
		'd' => 'day',
		'h' => 'hour',
		'i' => 'minute',
		's' => 'second',
	);
	foreach ($string as $k => &$v) {
		if ($diff->$k) {
			$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
		} else {
			unset($string[$k]);
		}
	}

	if (!$full) $string = array_slice($string, 0, 1);
	return $string ? implode(', ', $string) . ' ago' : 'just now';
}