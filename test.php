<?php
/*
$begin = new DateTime( '2018-01-01' );
$end = new DateTime( '2018-12-31' );
$end = $end->modify( '+1 day' );

$interval = new DateInterval('P6M');
$daterange = new DatePeriod($begin, $interval ,$end);

foreach($daterange as $date){
    echo $date->format("Y-m-d") . "<br>";
}*/


$str = '/input Jigsaw

*ID Jigsaw* : X4-018
*Work Location* : N3
*BD Type*(**) : H1

*BD Receiver*(**) : G13
*RFU Receiver*(**) : G13
*Person in Charge*(**) : G1,G11,G13

_Waiting_
*Start* : 0
*End* : 0

_Action_ 
*Start* : 08:30
*End* : 09:30

*Problem*(**) : A3
*Analysis*(**) : B6
*Cause By Problem*(**) : C10
*Action*(**) : D16
*Remark*(**) : E19

*Antenna*(**) : M1
*Source Power*(**) : L1
*Locked* : LOCKED
*Status*(**) : J1

*S/N Display* : 000000
*S/N Router* : 0000
*S/N GPS* : 000000

*Other Information* : REPOSISI ANTENNA DARI ATAS KABIN TO SEBELAH KANAN KABIN, BRACKET DISPLAY TERLALU JAUH

*Backlog*(**) : F7,F26';

$ex = explode(' ', $str);
print_r($ex);
echo "<br />dev : " . trim(explode("\n", $ex[1])[0]);
echo "<br />Unit : " . trim(explode("\n", $ex[4])[0]);
echo "<br />Location : " . trim(explode("\n", $ex[7])[0]);
echo "<br />BD Type : " . trim(explode("\n", $ex[10])[0]);
echo "<br />BD Receiver : " . trim(explode("\n", $ex[13])[0]);
echo "<br />RFU Receiver : " . trim(explode("\n", $ex[16])[0]);
echo "<br />PIC : " . trim(explode("\n", $ex[20])[0]);
echo "<br />Problem : " . trim(explode("\n", $ex[31])[0]);
echo "<br />Analysis : " . trim(explode("\n", $ex[33])[0]);
echo "<br />Cause Of Problem : " . trim(explode("\n", $ex[37])[0]);
echo "<br />Action : " . trim(explode("\n", $ex[39])[0]);
echo "<br />Remark : " . trim(explode("\n", $ex[41])[0]);
echo "<br />Wait Start : " . trim(explode("\n", $ex[22])[0]);
echo "<br />Wait End : " . trim(explode("\n", $ex[24])[0]);
echo "<br />Action Start : " . trim(explode("\n", $ex[27])[0]);
echo "<br />Action End : " . trim(explode("\n", $ex[29])[0]);


?>