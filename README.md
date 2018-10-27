# About Reporting

Reporting merupakan salah satu project saya yang menangani tentang laporan oleh Technician Mine Dispatch (PT. SaptaIndra Sejati). Yang mana laporan ini akan diolah sesuai dengan kebutuhan dilapangan. Semua data tersaji lengkap dengan summary dari pekerjaan setiap hari.

## Requirement Software

Aplikasi ini membutuhkan beberapa software yang sudah terstandarkan, diantarnya :

* PHP 7.0 >=
* Apache 2.4
* Mozilla 63.0
* Etc.

## Feature Menu

* Admin Elements
	* Category Report
	* Problem
	* Analysis
	* Cause By
	* Action
	* Remark
	* Backlog
	* Other Element
* Admin Control
    * Relations
    * Device
    * Time Periodic
    * People
    * Level User
* Population
	* Record Unit Jigsaw &amp; Network
	* Summary Unit Area &amp; Type
* Report
	* Record Backlog
	* Battery
		* Proccess menggunakan system cronjob yang sudah diatur pada jam 06.00 WITA dan 18.00 WITA setiap harinya.
	* Reporting Jigsaw
	* Reporting Network
	* Reporting Tahun > Bulan
	* Other Activity
* Summary
	* Summary Unit Perbulan
	* Graphic Problem Network & Jigsaw
	* Summary Problem Data Unit
	* Preventive Maintenance
* Chart
	* Summary Graphic Jigsaw
	* Summary Graphic Network
	* Summary Graphic Bandwith
		* Proccess menggunakan system cronjob yang sudah diatur pada jam 06.00 WITA dan 18.00 WITA setiap harinya.
* Employe Performance
* Activity Jigsaw & Network
* Counting Activity
* API for public access
* Level user yang sudah didefinisikan sebagai
	* Supervisor
	* Administrator
	* Report
	* Teknisi
	* User login with NRP

## Database Table
* backlog
	* Record all report backlog
* bandwith
	* Record all bandwith
* battery
	* Record activity battery
* device
	* Device unit jigsaw &amp; network
* enum
	* All data dynamis
* periodic_pm
	* Periode Preventive Maintenance pertahun
* pic_recondition
	* Get Person in Charge recondition
* pic_report
	* Get Person in Charge Reporting
* recondition
	* Next update
* relations
	* Untuk relasi semua data di Enum table
* report
	* All data report
* unit
	* All data unit Jigsaw &amp; Network
* user
	* All data data login user.


## Version

First Release

* 1.0