var LED_On=new Image();
LED_On.src="numerals/on.png";
var LED_Off=new Image();
LED_Off.src="numerals/off.png";

var target = new Date('February 14, 2015 00:00:00'); 
var oneMinute=1000*60
var oneHour=1000*60*60
var oneDay=1000*60*60*24

function binary_time(){
	var today=new Date();

	var timediff=(target.getTime()-today.getTime());
	var dayfield=Math.floor(timediff/oneDay);
	var hourfield=Math.floor((timediff-dayfield*oneDay)/oneHour);
	var minutefield=Math.floor((timediff-dayfield*oneDay-hourfield*oneHour)/oneMinute);
	var secondfield=Math.floor((timediff-dayfield*oneDay-hourfield*oneHour-minutefield*oneMinute)/1000);

	//console.log(dayfield+" "+hourfield+" "+minutefield+" "+secondfield);

	var days_binary=dayfield.toString(2);
	var hours_binary=hourfield.toString(2);
	var minutes_binary=minutefield.toString(2);
	var seconds_binary=secondfield.toString(2);
	
	//console.log(now+" "+hours_binary+" "+minutes_binary+" "+seconds_binary);

	while(hours_binary.length<5){
		hours_binary='0'+hours_binary;
	}
	while(minutes_binary.length<6){
		minutes_binary='0'+minutes_binary;
	}
	while(seconds_binary.length<6){
		seconds_binary='0'+seconds_binary;
	}
	
	for(var a=0;a<6;a++){
		if(days_binary.charAt(a)=='1'){
			document.getElementById('days_'+a).src=LED_On.src; document.getElementById('days_'+a).alt='1';
		}
		else {
			document.getElementById('days_'+a).src=LED_Off.src; document.getElementById('days_'+a).alt='0';
		}
		if(a!=5){
			if(hours_binary.charAt(a)=='1'){
				document.getElementById('hours_'+a).src=LED_On.src; document.getElementById('hours_'+a).alt='1';
			}
			else
			{
				document.getElementById('hours_'+a).src=LED_Off.src; document.getElementById('hours_'+a).alt='0';
			}
		}
		if(minutes_binary.charAt(a)=='1'){
			document.getElementById('min_'+a).src=LED_On.src; document.getElementById('min_'+a).alt='1';
		}
		else {
			document.getElementById('min_'+a).src=LED_Off.src; document.getElementById('min_'+a).alt='0';
		}
		if(seconds_binary.charAt(a)=='1'){
			document['sec_'+a].src=LED_On.src;document['sec_'+a].alt='1';
		}
		else
		{
			document['sec_'+a].src=LED_Off.src;document['sec_'+a].alt='0';
		}
	}
	setTimeout("binary_time();",500);
}
