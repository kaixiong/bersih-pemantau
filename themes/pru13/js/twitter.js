// by blacklizard for pru13.info
$(document).ready(function() {
	function formatDate(date) {
		var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun','Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

		var dateStr = months[date.getMonth()] + ' ' + date.getDate();

		var timeStr = '';
		var minutesStr = '';

		if (date.getMinutes() < 10) {
			minutesStr = '0' + date.getMinutes();
		} else {
			minutesStr = date.getMinutes().toString();
		}

		if (date.getHours() <= 12) {
			timeStr = date.getHours() + ':' + minutesStr + 'am';
		} else {
			timeStr = (date.getHours() - 12) + ':' + minutesStr + 'pm';
		}

		return dateStr + ', ' + timeStr;
	}

	$.getJSON('https://search.twitter.com/search.json?callback=?&rpp=5&result_type=recent&q=jompantau', function(response) {
		// FIXME: Display error message if no tweets could be loaded

		var feed = $('#twitter-feed');

		$.each(response.results, function(index, entry) {
			var html = '<div class="byline">';

			html += '<span class="by"><a target="_blank" href="https://twitter.com/' + entry.from_user + '">';
			html += entry.from_user;
			html += '</a></span> '; // NOTE: Trailing space needed for spacing
			html += '<span class="date">' + formatDate(new Date(entry.created_at)) + '</span></div>';
			html += '<div class="tweet">' + entry.text + '</div>';
			html += '</div>';

			feed.append($('<div class="result"/>').html(html));
		});
	});
});
