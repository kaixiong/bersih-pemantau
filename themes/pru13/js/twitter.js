// by blacklizard for pru13.info
$(document).ready(function() {
	$.getJSON('http://search.twitter.com/search.json?callback=?&rpp=5&result_type=recent&q=jompantau' ,function(response){
		twitterParse(response);
	});
});

function twitterParse(response){

	var tweetCount = response.results.length;
	//to be used later to convert parsed data into jquery object
	this.el = $('<div />');
	var html = [];// container to store parsed data
	var months = ['Jan', 'Feb', 'March', 'April', 'May', 'June','July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'];
	//i could use .each but what the heck.. lol
	for (var i = 0; i < tweetCount; i++) {
		html.push('<div class="result"><div class="byline"><span class="by"><a target="_blank" href="https://twitter.com/');
		html.push(response.results[i].from_user);
		html.push('">');
		html.push(response.results[i].from_user);
		html.push('</a></span><span class="date"> ');
		
		var date = new Date(response.results[i].created_at);
		
		var hour = date.getHours();
		html.push(months[date.getMonth()]);
		html.push(date.getDate());
		html.push(', ');
		html.push(hour);
		html.push(':');
		
		var minutes = date.getMinutes();
		
		if(minutes<10){
			minutes = '0'+minutes;
		}
		
		html.push(minutes);
		
		if(hour>11){
			html.push('pm');
		}else{
			html.push('am');
		}
		
		html.push('</span></div><div class="tweet">');
		html.push(response.results[i].text);
		html.push('</div></div>');
	}
	//convert to jquery object
	this.el.html(html.join(''));
	
	//get container
	var $feed = $('#twitter-feed');
	//append
	$feed.append(this.el);
}