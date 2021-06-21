var moment = require('moment');
$.on('/leaderboard', function() {
    $(document).ready(function() {
		$('.leaderboard-RowGroup div:eq(0)').slideDown(300, function(){
			$(this).next().slideDown(300, arguments.callee);
		});
	});
	
	var Time = moment(moment().endOf('hour')).format('MM-DD-YYYY HH:mm:ss');
	
	function makeTimer() {	
		endTime = (Date.parse(Time) / 1000);
		var now = new Date();
		now = (Date.parse(now) / 1000);
		var timeLeft = endTime - now;
		var days = Math.floor(timeLeft / 86400); 
		var hours = Math.floor((timeLeft - (days * 86400)) / 3600);
		var minutes = Math.floor((timeLeft - (days * 86400) - (hours * 3600 )) / 60);
		var seconds = Math.floor((timeLeft - (days * 86400) - (hours * 3600) - (minutes * 60)));
		if (days < "10") { days = "0" + days; }
		if (hours < "10") { hours = "0" + hours; }
		if (minutes < "10") { minutes = "0" + minutes; }
		if (seconds < "10") { seconds = "0" + seconds; }
		$("#days").html(days);
		$("#hours").html(hours);
		$("#minutes").html(minutes);
		$("#seconds").html(seconds);		
	}

	setInterval(function() { 
		makeTimer(); 
	}, 1000);
	
	$(".leaderboard-TabGroup .leaderboard-Tab").click(function() {
		$('.leaderboard-RowTable.row-main').hide();
		$(".leaderboard-TabGroup .leaderboard-Tab").removeClass("active").eq($(this).index()).addClass("active");
		$(".leaderboard-Table").hide().eq($(this).index()).fadeIn()
		$(".leaderboard-RowGroup").each(function(index) {
			$(this).find("div:eq(0)").slideDown(200, function(){
				$(this).next().slideDown(200, arguments.callee);
			});
		});
		if($(this).index() == 0) {
		Time = moment(moment().endOf('hour')).format('MM-DD-YYYY HH:mm:ss');
		}
		if($(this).index() == 1) {
		Time = moment(moment().endOf('day')).format('MM-DD-YYYY HH:mm:ss');
		}
		if($(this).index() == 2) {
		Time = moment(moment().endOf('week')).format('MM-DD-YYYY HH:mm:ss');
		}
		makeTimer();
	}).eq(0).addClass("active");
		
}, ['/css/pages/leaderboard.css']);
