<script src="http://www.youtube.com/iframe_api" type='text/javascript'></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js" type='text/javascript'></script>
<script type="text/javascript">
//<![CDATA[  
	//////////////////////
  	// Yout Tube Begin  //
	//////////////////////
	var players = {};
	function onYouTubeIframeAPIReady(){
		trackYouTube();
	}
	function trackYouTube(){
		$('iframe').each(function(i) { 
			var $curVideo = $(this);
			var $frameSrc = $curVideo.attr('src');
			var $questionMarkPosition = $frameSrc.indexOf("?");
			var tmpArray = {};
			//alert('? ' + $questionMarkPosition);
			var $startPosition = 24;
			//alert('start ' + $startPosition);
			var $videoId = $frameSrc.substring($startPosition, $questionMarkPosition);
			$curVideo.attr('id', $videoId);
			//alert($frameSrc + ' substr: ' + $curVideo.attr('id'));
			tmpArray['checkMe'] = $('#checkMe').val();
			$.ajax({
                        	url: 'http://gdata.youtube.com/feeds/api/videos/' + $videoId + '?v=2&alt=json',
                        	dataType: "jsonp",
                        	success: function (data) { 
							tmpArray['title'] = data.entry.title.$t; 
							//return title;
						}
                	});
			tmpArray['player'] = new YT.Player($videoId,{
							videoId: $videoId,
							events:{
								'onStateChange': onPlayerStateChange($videoId)
							}
						}
					);
			players[$videoId] = tmpArray;
		});
	}
	function onPlayerStateChange(videoId){
		return function(event){
			var x = players[videoId]['player'].getDuration();
			var statCode = [];
			statCode['-1'] = 'unstarted';
			statCode['0'] = 'ended';
			statCode['1'] = 'playing';
			statCode['2'] = 'paused';
			statCode['3'] = 'buffering';
			statCode['5'] = 'video cued';
			var txtEvent;
			var txtDescription;
			var fileName = players[videoId]['title'];
			var filePath = 'video';
			var checkme = players[videoId]['checkMe'];
			if(event.data == YT.PlayerState.ENDED){
				//alert('Event: Video finished, Description: Time started - ' + players[videoId]['player'].getCurrentTime() + ', Video Length - ' + x + ' video title: ' + players[videoId]['title'] + ' filePath: video, checkMe: ' + players[videoId]['checkMe']);
				txtEvent = 'Video ended.';
				txtDescription = 'User reached end of video.';
				sendYouTubeTracking(txtEvent, txtDescription, fileName, filePath, checkme);
			}else if(event.data == YT.PlayerState.PLAYING){
				//alert('Event: Video playing, Description: Time started - ' + players[videoId]['player'].getCurrentTime() + ', Video Length - ' + x + ' video title: ' + players[videoId]['title'] + ' filePath: video, checkMe: ' + players[videoId]['checkMe']);
				txtEvent = 'Video started playing.';
				txtDescription = 'Start Time: ' + players[videoId]['player'].getCurrentTime() + ', Video Duration: ' + x;
				sendYouTubeTracking(txtEvent, txtDescription, fileName, filePath, checkme);				
			}else if(event.data == YT.PlayerState.PAUSED){
				//alert('Event: Video puased, Description: Time started - ' + players[videoId]['player'].getCurrentTime() + ', Video Length - ' + x + ' video title: ' + players[videoId]['title'] + ' filePath: video, checkMe: ' + players[videoId]['checkMe']);
				if(players[videoId]['player'].getCurrentTime() == x){
					txtEvent = 'Video finished';
				}else{
					txtEvent = 'Video paused.';
				}
				txtDescription = 'Paused at: ' + players[videoId]['player'].getCurrentTime() + ', Video Duration: ' + x;;
				sendYouTubeTracking(txtEvent, txtDescription, fileName, filePath, checkme);
			}else if(event.data == YT.PlayerState.BUFFERING){
				//alert('Event: Video buffering, Description: Time started - ' + players[videoId]['player'].getCurrentTime() + ', Video Length - ' + x + ' video title: ' + players[videoId]['title'] + ' filePath: video, checkMe: ' + players[videoId]['checkMe']);
				//sendYouTubeTracking(txtEvent, txtDescription, fileName, filePath, checkme);
			}else if(event.data == YT.PlayerState.CUED){
				//alert('Event: Video cued, Description: Time started - ' + players[videoId]['player'].getCurrentTime() + ', Video Length - ' + x + ' video title: ' + players[videoId]['title'] + ' filePath: video, checkMe: ' + players[videoId]['checkMe']);
				//sendYouTubeTracking(txtEvent, txtDescription, fileName, filePath, checkme);
			}
		}
	}
	function sendYouTubeTracking(txtEvent, txtDescription, fileName, filePath, checkMe){$.ajax({
				url: '<?php echo site_url(); ?>/activity-tracker',
				type: 'post',
				dataType: 'xml',
				data: 'txtEvent=' + txtEvent + '&txtDescription=' + txtDescription + '&filePath=' + filePath + '&fileName=' + fileName + '&checkMe=' + checkMe,
        			processData: false,
				error: function(jqXHR, textStatus, errorThrown){
					alert('Failed: ' + textStatus + ' thrown: ' + errorThrown);
				},
				success: function(xml){
					//alert('success tracked');
				}
			});
	}
	/////////////////
	// YouTube End //
	/////////////////


	///////////////////////////
	//JQuery Listeners Begin //
	///////////////////////////
	$(function(){ 
		$('.tabs .tab-links a').on('click', function(e)  {
        		var currentAttrValue = jQuery(this).attr('href');
 
        		// Show/Hide Tabs
        		$('.tabs ' + currentAttrValue).show().siblings().hide();
 
        		// Change/remove current tab to active
        		$(this).parent('li').addClass('active').siblings().removeClass('active');
 
        		e.preventDefault();
    		});
		$('.trackVideoActivity').click(function(){
			//alert('track ' + $(this).text() + '  nonce: ' + $(this).attr('alt'));

			$.ajax({
				url: '<?php echo site_url(); ?>/activity-tracker',
				type: 'post',
				dataType: 'xml',
				data: 'txtEvent=Opened&txtDescription=File+was+opened&filePath=traingVideo&fileName=' + $(this).text() + '&checkMe=' + $(this).attr('alt'),
        			processData: false,
				error: function(jqXHR, textStatus, errorThrown){
					alert('Failed: ' + textStatus + ' thrown: ' + errorThrown);
				},
				success: function(xml){
					//alert('success tracked');
				}
			});

			//return false;
		});
		$('.trackDocumentActivity').click(function(){
			//alert('track ' + $(this).text() + '  nonce: ' + $(this).attr('alt'));

			$.ajax({
				url: '<?php echo site_url(); ?>/activity-tracker',
				type: 'post',
				dataType: 'xml',
				data: 'txtEvent=Opened&txtDescription=File+was+opened&filePath=traingDocuments&fileName=' + $(this).text() + '&checkMe=' + $(this).attr('alt'),
        			processData: false,
				error: function(jqXHR, textStatus, errorThrown){
					alert('Failed: ' + textStatus + ' thrown: ' + errorThrown);
				},
				success: function(xml){
					//alert('success tracked');
				}
			});

			//return false;
		});
		$('.trackTestActivity').click(function(){
			//alert('track ' + $(this).text() + '  nonce: ' + $(this).attr('alt'));

			$.ajax({
				url: '<?php echo site_url(); ?>/activity-tracker',
				type: 'post',
				dataType: 'xml',
				data: 'txtEvent=Opened&txtDescription=File+was+opened&filePath=traingTests&fileName=' + $(this).text() + '&checkMe=' + $(this).attr('alt'),
        			processData: false,
				error: function(jqXHR, textStatus, errorThrown){
					alert('Failed: ' + textStatus + ' thrown: ' + errorThrown);
				},
				success: function(xml){
					//alert('success tracked');
				}
			});

			//return false;
		});
		$('#submitTest').submit(function(){
			var submitAnswer = 'answers=';
			var t;
			$(this).find('ul').each(function(){
				t = $(this).find('input:checked').val();
				var s = $(this).attr('name');
				if(t == undefined){
					alert('Question ' + s + ' is not answered.');
					return false;
				}
				var w = $(this).find('input:checked').attr('name');
				submitAnswer = submitAnswer + w + '_' + t + '_' + s + '-';				
			});
			if(t != undefined){
				submitAnswer = submitAnswer + '&checkMe=' + $('#checkMe').val();
				//alert('submit: ' + submitAnswer);
				$.ajax({
					url: '<?php echo site_url(); ?>/grade-test',
					dataType: 'xml',
					data: submitAnswer,
					error: function(jqXHR, textStatus, errorThrown){
						alert('Failed: ' + textStatus + ' thrown: ' + errorThrown);
					},
					success: function(xml){
						//alert('success graded: ' + $(xml).text());
						$('#submitTest').find('ul').remove();
						var i = '<h2>Test Result</h2>';
						$(xml).find('testResult').each(function(){
							i = i + '<p>Correct: ' + $(this).find('numberCorrect').text() + '</p>';
							i = i + '<p>Incorrect: ' + $(this).find('numberIncorrect').text() + '</p>';
							i = i + '<p>Grade: ' + $(this).find('grade').text() + '</p>';
						});
						$('#submitTest').html(i);
					}
				});
			}
		});
	});
	/////////////////////////
	//JQuery Listeners End //
	/////////////////////////
//]]>
</script>