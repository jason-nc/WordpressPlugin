<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js" type='text/javascript'></script>
<script type="text/javascript">
//<![CDATA[  
	$(function(){ 
		$('#videoTab').click(function(){ 
			//alert( "Handler for .click() called." );
			$('.divTab').css('background-color', '#DDD');
			$(this).css('background-color', '#FFFFFF');
			$('#videoTabContent').css('display', 'block');
			$('#testsTabContent').css('display', 'none');
			$('#documentsTabContent').css('display', 'none');
		});
		$('#testsTab').click(function(){ 
			//alert( "Handler for .click() called." );
			$('.divTab').css('background-color', '#DDD');
			$(this).css('background-color', '#FFFFFF');
			$('#testsTabContent').css('display', 'block');
			$('#videoTabContent').css('display', 'none');
			$('#documentsTabContent').css('display', 'none');
		});
		$('#documentsTab').click(function(){ 
			//alert( "Handler for .click() called." );
			$('.divTab').css('background-color', '#DDD');
			$(this).css('background-color', '#FFFFFF');
			$('#documentsTabContent').css('display', 'block');
			$('#testsTabContent').css('display', 'none');
			$('#videoTabContent').css('display', 'none');
		});
		$('.deleteVideoFile').click(function(){
			//alert('Delete Video ' + $(this).attr('alt'));
			$.ajax({
				url: '<?php echo site_url(); ?>/delete-video',
				type: 'post',
				dataType: 'xml',
				data: 'directory=traingVideos&deleteVideoFile=' + $(this).attr('alt') + '&checkMe=' + $('#checkMe').val(),
        			processData: false,
				error: function(jqXHR, textStatus, errorThrown){
					alert('Failed: ' + textStatus + ' thrown: ' + errorThrown);
				},
				success: function(xml){
					//alert('success delete video ' + $(xml).find('name').text());
                    			$('#listVideofiles li:contains("' + $(xml).find('name').text() + '")').remove();
				}
			});
			return false;
		});
		$('.deleteTestFile').click(function(){
			//alert('Delete Video ' + $(this).attr('alt'));
			$.ajax({
				url: '<?php echo site_url(); ?>/delete-video',
				type: 'post',
				dataType: 'xml',
				data: 'directory=traingTests&deleteVideoFile=' + $(this).attr('alt') + '&checkMe=' + $('#checkMe').val(),
        			processData: false,
				error: function(jqXHR, textStatus, errorThrown){
					alert('Failed: ' + textStatus + ' thrown: ' + errorThrown);
				},
				success: function(xml){
					//alert('success delete video ' + $(xml).find('name').text());
                    			$('#listTestfiles li:contains("' + $(xml).find('name').text() + '")').remove();
				}
			});
			return false;
		});
		$('.deleteDocumentFile').click(function(){
			//alert('Delete Video ' + $(this).attr('alt'));
			$.ajax({
				url: '<?php echo site_url(); ?>/delete-video',
				type: 'post',
				dataType: 'xml',
				data: 'directory=traingDocuments&deleteVideoFile=' + $(this).attr('alt') + '&checkMe=' + $('#checkMe').val(),
        			processData: false,
				error: function(jqXHR, textStatus, errorThrown){
					alert('Failed: ' + textStatus + ' thrown: ' + errorThrown);
				},
				success: function(xml){
					//alert('success delete video ' + $(xml).find('name').text());
                    			$('#listDocumentfiles li:contains("' + $(xml).find('name').text() + '")').remove();
				}
			});
			return false;
		});
		$('.deleteApplicationFile').click(function(){
			//alert('Delete Video ' + $(this).attr('alt'));
			$.ajax({
				url: '<?php echo site_url(); ?>/delete-video',
				type: 'post',
				dataType: 'xml',
				data: 'directory=employmentApplication&deleteVideoFile=' + $(this).attr('alt') + '&checkMe=' + $('#checkMe').val(),
        			processData: false,
				error: function(jqXHR, textStatus, errorThrown){
					alert('Failed: ' + textStatus + ' thrown: ' + errorThrown);
				},
				success: function(xml){
					//alert('success delete video ' + $(xml).find('name').text());
                    			$('#listApplicationfiles li:contains("' + $(xml).find('name').text() + '")').remove();
					//alert('Should delete li that contains: ' + $(xml).find('name').text());
				}
			});
			return false;
		});
		$('#users').bind('change', function () {
			//alert('user selector changed');

			$.ajax({
				url: '<?php echo site_url(); ?>/activity-report',
				type: 'post',
				dataType: 'xml',
				data: 'userId=' + $(this).val() + '&checkMe=' + $(this).attr('alt'),
        			processData: false,
				error: function(jqXHR, textStatus, errorThrown){
					alert('Failed: ' + textStatus + ' thrown: ' + errorThrown);
				},
				success: function(xml){
					//alert('success activity report');
					var tableRows = '<tr><th>Post Id</th><th>Date</th><th>File Name</th><th>Event</th><th>Description</th></tr>';
                    			$('#displayActivity tr').remove();
					$(xml).find('file').each(function(){
						tableRows = tableRows + '<tr><td>' + $(this).find('postId').text() + '</td><td>' + $(this).find('postDate').text() + '</td><td>' + $(this).find('fileName').text() + '</td><td>' + $(this).find('Event').text() + '</td><td>' + $(this).find('Description').text() + '</td></tr>';
                        		});
					//alert('Row ' + tableRows);
                        		$('#displayActivity').append(tableRows);
				}
			});

			return false;
		});
	});
//]]>
</script>