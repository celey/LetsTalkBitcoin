<?php
namespace Tags;
use App;
class ABPTimer
{

	function __construct()
	{
		$this->model = new \App\Meta_Model;
		$this->site = $this->model->get('sites', $_SERVER['HTTP_HOST'], array(), 'domain'); //get basic site data
	}
	
	public function display()
	{
	
		$expireTime = strtotime('2015-02-14 00:00:00');
		$time = time();
		if($time > $expireTime){
			header('Location: '.$this->site['url'].'/a5h3s-2-fl45h3s');
			die();
		}
	
		ob_end_clean();
		ob_start();
		?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>

<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
<title>TheSL33P3R</title>
<base href="<?= $this->site['url'] ?>/resources/abpt/">
<link rel="canonical" href="index.html">
<link rel="stylesheet" type="text/css" href="css/onlineclock.css">

<script language="JavaScript" src="<?= $this->site['url'] ?>/resources/abpt/javascript/binaryclock.js" type="text/javascript"></script>
<script language="JavaScript" src="<?= $this->site['url'] ?>/resources/abpt/javascript/onlineclock.js" type="text/javascript"></script>

</head>
<body onLoad="binary_time();show3();" background="<?= $this->site['url'] ?>/resources/abpt/numerals/bg_1680.png" bgcolor="#000000" text="#666666" id="theBody">
<a title="Clocks" class="qmparent"><img alt="Clocks" class="qm-is" src="clocks.gif" width="16" height="16" border="0" style="border:1px solid #FF0000; visibility: hidden;"></a>

<table align="center" width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
<td align="center" valign="middle" width="100%" height="100%">
 
<table border="0" cellspacing="4" cellpadding="4" align="center" width="100%">
<tr>
<td width="100%" align="center" valign="top">
 
<table style="width: 100%;" cellpadding="0" cellspacing="0">
<tbody><tr><td style="width: 100%;">
<center>
<table style="text-align: center;">
<tbody>
<tr>
<td id="day_0"><img id="days_0" src="<?= $this->site['url'] ?>/resources/abpt/numerals/off.png" alt="0" width="50" height="50"></td>
<td id="day_1"><img id="days_1" src="<?= $this->site['url'] ?>/resources/abpt/numerals/on.png" alt="1" width="50" height="50"></td>
<td id="day_2"><img id="days_2" src="<?= $this->site['url'] ?>/resources/abpt/numerals/off.png" alt="0" width="50" height="50"></td>
<td id="day_3"><img id="days_3" src="<?= $this->site['url'] ?>/resources/abpt/numerals/on.png" alt="1" width="50" height="50"></td>
<td id="day_4"><img id="days_4" src="<?= $this->site['url'] ?>/resources/abpt/numerals/on.png" alt="1" width="50" height="50"></td>
<td id="day_5"><img id="days_5" src="<?= $this->site['url'] ?>/resources/abpt/numerals/on.png" alt="1" width="50" height="50"></td>
</tr>
<tr>
<td id="blank"></td>
<td id="hour_0"><img id="hours_0" src="<?= $this->site['url'] ?>/resources/abpt/numerals/off.png" alt="0" width="50" height="50"></td>
<td id="hour_1"><img id="hours_1" src="<?= $this->site['url'] ?>/resources/abpt/numerals/on.png" alt="1" width="50" height="50"></td>
<td id="hour_2"><img id="hours_2" src="<?= $this->site['url'] ?>/resources/abpt/numerals/off.png" alt="0" width="50" height="50"></td>
<td id="hour_3"><img id="hours_3" src="<?= $this->site['url'] ?>/resources/abpt/numerals/on.png" alt="1" width="50" height="50"></td>
<td id="hour_4"><img id="hours_4" src="<?= $this->site['url'] ?>/resources/abpt/numerals/on.png" alt="1" width="50" height="50"></td>
</tr>
<tr>
<td><img id="min_0" src="<?= $this->site['url'] ?>/resources/abpt/numerals/on.png" alt="1" width="50" height="50"></td>
<td><img id="min_1" src="<?= $this->site['url'] ?>/resources/abpt/numerals/off.png" alt="0" width="50" height="50"></td>
<td><img id="min_2" src="<?= $this->site['url'] ?>/resources/abpt/numerals/on.png" alt="1" width="50" height="50"></td>
<td><img id="min_3" src="<?= $this->site['url'] ?>/resources/abpt/numerals/on.png" alt="1" width="50" height="50"></td>
<td><img id="min_4" src="<?= $this->site['url'] ?>/resources/abpt/numerals/on.png" alt="1" width="50" height="50"></td>
<td><img id="min_5" src="<?= $this->site['url'] ?>/resources/abpt/numerals/on.png" alt="1" width="50" height="50"></td>
</tr>
<tr>
<td><img name="sec_0" src="<?= $this->site['url'] ?>/resources/abpt/numerals/on.png" alt="1" width="50" height="50"></td>
<td><img name="sec_1" src="<?= $this->site['url'] ?>/resources/abpt/numerals/off.png" alt="0" width="50" height="50"></td>
<td><img name="sec_2" src="<?= $this->site['url'] ?>/resources/abpt/numerals/on.png" alt="1" width="50" height="50"></td>
<td><img name="sec_3" src="<?= $this->site['url'] ?>/resources/abpt/numerals/off.png" alt="0" width="50" height="50"></td>
<td><img name="sec_4" src="<?= $this->site['url'] ?>/resources/abpt/numerals/on.png" alt="1" width="50" height="50"></td>
<td><img name="sec_5" src="<?= $this->site['url'] ?>/resources/abpt/numerals/on.png" alt="1" width="50" height="50"></td>

</tbody>
</table>
</center>
</td></tr>
</tbody>
 
</td>
</tr>

</table>
 
<script type="text/javascript">changeImageSize(150,150);</script>
</BODY>

</HTML>
		<?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;
		die();
	
	
	}


}
