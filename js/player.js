var play = false;
var searched = false;

$(function(){

	$('#container a').each(function(){
		$(this).attr('target','').click(function(){
			search = $(this).attr('title');
			
			url = 'http://gdata.youtube.com/feeds/videos?vq=' + encodeURI( search ) + '&orderby=relevance&alt=json&callback=?';
			
			if( searched != search || !play ){
				searched = search;
			
				$('#secret').html('');
				$('#container a').css('cursor', 'wait');
			
				$.getJSON(url, function(data) {
				
					if( data.feed.entry[0] ){
						id = data.feed.entry[0].id.$t.replace('http://gdata.youtube.com/feeds/videos/','');
						
						$('#secret').html('<iframe width="420" height="315" src="http://www.youtube.com/embed/' + id + '?autoplay=1" frameborder="0" allowfullscreen></iframe>');
						play = true;
						
						$('#container a').css('cursor', 'default');
					
					}else{
						alert('no se puede reproducir');
					}
				});
			}else if( play ){
				$('#secret').html('');
				play = false;
			}			
			
			return false;
		})
	});

});