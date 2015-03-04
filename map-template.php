<?php 
/* 
Template Name: Map Page
*/
?>
<?php get_header();?>

<?php
$location = icore_get_location();   
$meta = icore_get_multimeta(array('Subheader')); 
?>
<style>
	#map-canvas img{
		max-width: none;
	}
	#map-canvas {
        	height: 500px;
        	width: 500px;
        	margin: 0px;
        	padding: 0px
      	}
      	.show-base-map{
          	display: none;
      	}
	@media all and (max-width: 550px){
		#map-canvas {
			width: 100%;
			//height: auto;
		}
	}
</style>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
<script>
	var map;
       	function initialize() {
        	var startPoint = new google.maps.LatLng(36, -80);
              	var mapOptions = {
                     		zoom: 8,
                     		center: startPoint
              			};
              	map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
		//google.maps.event.addListener(map, 'click', function(event) {
		//	marker = new google.maps.Marker({position: event.latLng, map: map});
		//	var x = event.latLng;
		//	var html = '<p>Hi ' + x + '</p>';
		//	var infowindow = new google.maps.InfoWindow({
      		//				content: html
  		//			});
		//	google.maps.event.addListener(marker, 'click', function() {
    		//		infowindow.open(map,marker);
  		//	});
		//});
		drawGuilfordPolygon(map);	
		drawRandolphPolygon(map);
		drawDavidsonPolygon(map);
              	var bounds = new google.maps.LatLngBounds ();
	      	bounds.extend (startPoint);
              	var baseAddress = document.getElementsByClassName("show-base-map");
              	for(var i = 0; i < baseAddress.length; i++){
			var parts = baseAddress[i].id.split(',');
              		var tmp = new google.maps.LatLng(parts[0], parts[1]);
	      		bounds.extend (tmp);
//alert('part: ' + parts[2]);
			var w = parts[2].toLowerCase();
//alert('w: ' + w);
			var z = parts[2].replace('-', ' ');
//alert('z: ' + z);
			var htmlContent = '<div><a href="' + parts[2].toLowerCase() + '">' + z + '</a></div>';
//alert('htmlContent: ' + htmlContent);
			var myInfowindow = new google.maps.InfoWindow({
						content: htmlContent
					});
              		var marker = new google.maps.Marker({
                               position: tmp,
                               map: map,
                               title: z,
			       infowindow: myInfowindow
             		});
			
			
			google.maps.event.addListener(marker, 'click', function() {
				this.infowindow.open(map,this);
  			});			
     	      	}
		var y = new google.maps.LatLng(36.280371446339196, -80.45150756835938);
		bounds.extend (y);
		y = new google.maps.LatLng(36.309149504411465, -79.45724487304688);
		bounds.extend (y);
		y = new google.maps.LatLng(35.45462948227747, -79.45999145507812);
		bounds.extend (y);
		y = new google.maps.LatLng(35.45686674850834, -80.57785034179688);
		bounds.extend (y);
	      	map.fitBounds (bounds);	
       	}

	function drawGuilfordPolygon(map) {
         	var boundaries = '36.25696068747356, -80.03518581390381|36.25702989897222, -80.03140926361084|36.257168321785606, -80.0282335281372|36.257099110409584, -80.02557277679443|36.25696068747356, -80.02188205718994|36.25689147591358, -80.01844882965088|36.25675305260965, -80.01484394073486|36.25689147591358, -80.0114107131958|36.25668384086573, -80.00823497772217|36.256545417193905, -80.00437259674072|36.25640699327679, -80.00111103057861|36.25626856911445, -79.9975061416626|36.256130144706816, -79.99450206756592|36.255922507635475, -79.99021053314209|36.25543801898963, -79.98531818389893|36.2548151006016, -79.96471881866455|36.25439981891701, -79.94600772857666|36.25128513592332, -79.86464023590088|36.25010844559088, -79.84120845794678|36.25017766315977, -79.838547706604|36.24962392089192, -79.80876445770264|36.24810110942226, -79.78172779083252|36.24803189001399, -79.7806978225708|36.24720125233265, -79.74945545196533|36.246785930181176, -79.7462797164917|36.24290948366661, -79.61693286895752|36.24325560277946, -79.61470127105713|36.24270181146321, -79.5774507522583|36.24117886511193, -79.53221797943115|36.21500724447266, -79.53359127044678|36.21452250221653, -79.53402042388916|36.12104971077941, -79.5369386672973|36.12056438707018, -79.53745365142822|36.082214335306794, -79.5393419265747|36.08103510407459, -79.53908443450928|36.01337313668164, -79.53925609588623|36.00073646301083, -79.53856945037842|35.899778751163936, -79.54226016998291|35.9205644821828, -80.04660129547119';

           	var latLngArray = boundaries.split('|');
                var points = [];
                for (var i = 0; i < latLngArray.length; i++) {
                	pos = latLngArray[i].split(',');
                        points.push(new google.maps.LatLng(parseFloat(pos[0]), parseFloat(pos[1])));
                }
		
                var shape = new google.maps.Polygon({
                        paths: points,
                        strokeColor: '#ff0000',
                        strokeOpacity: 0.8,
                        strokeWeight: 2,
                        fillColor: '#ff0000',
                        fillOpacity: 0.35
                });

                shape.setMap(map);
    	}

	function drawRandolphPolygon(map) {
		
 		var boundaries = '35.9205644821828, -80.04660129547119|35.899778751163936, -79.54226016998291|35.51610367472655, -79.55526351928711|35.50744030892169, -80.06647109985352';

                var latLngArray = boundaries.split('|');
                var points = [];
                for (var i = 0; i < latLngArray.length; i++) {
                	pos = latLngArray[i].split(',');
                        points.push(new google.maps.LatLng(parseFloat(pos[0]), parseFloat(pos[1])));
                }
		
                var shape = new google.maps.Polygon({
                				paths: points,
                        			strokeColor: '#80FF00',
                        			strokeOpacity: 0.8,
                        			strokeWeight: 2,
                        			fillColor: '#80FF00',
                        			fillOpacity: 0.35
                    				});

                shape.setMap(map);
   	}
	function drawDavidsonPolygon(map) {
		
             	var boundaries = '35.50744030892169, -80.06647109985352|35.9205644821828, -80.04660129547119|36.01087373237451, -80.04385471343994|36.02628544236787, -80.1498556137085|36.02628544236787, -80.21379947662354|35.9965700784894, -80.2146577835083|35.996778402731074, -80.3230619430542|35.99059788291874, -80.3234052658081|35.99094511703136, -80.34477710723877|35.97316482069195, -80.39464473724365|35.97149771252342, -80.39232730865479|35.9680939240299, -80.39121150970459|35.96642670877755, -80.38949489593506|35.96607936783552, -80.38674831390381|35.96580149292177, -80.38425922393799|35.9650373347817, -80.38194179534912|35.964273169246425, -80.38013935089111|35.96295322953987, -80.37842273712158|35.961146960504315, -80.37739276885986|35.959340650155106, -80.37644863128662|35.958020628004554, -80.37567615509033|35.95656163048661, -80.37524700164795|35.95371303385044, -80.37413120269775|35.95086433448884, -80.37413120269775|35.949335721751844, -80.37473201751709|35.94551406051708, -80.37456035614014|35.9410668038513, -80.37550449371338|35.937731197112065, -80.37464618682861|35.93168505109958, -80.36983966827393|35.928140543616436, -80.36820888519287|35.92320576861125, -80.36915302276611|35.91827068565936, -80.37327289581299|35.91375238621779, -80.37481784820557|35.91041562707337, -80.37456035614014|35.90422834712615, -80.37147045135498|35.89595471133682, -80.36571979522705|35.89338206009352, -80.36503314971924|35.88545498742213, -80.37001132965088|35.883994650635685, -80.37387371063232|35.88517683011033, -80.3783369064331|35.887054373005135, -80.38108348846436|35.887054373005135, -80.38108348846436|35.8919914029912, -80.39112567901611|35.892478135755574, -80.3973913192749|35.89018351224046, -80.4094934463501|35.88093481005225, -80.4164457321167|35.86973756759877, -80.39206981658936|35.86104296508126, -80.38734912872314|35.85353006043677, -80.3852891921997|35.84344217070587, -80.38949489593506|35.84107654876595, -80.39713382720947|35.84365089866625, -80.40494441986084|35.84365089866625, -80.40494441986084|35.85227784044221, -80.41747570037842|35.851303877884895, -80.42382717132568|35.83711049487854, -80.4270887374878|35.829734499032234, -80.42906284332275|35.827716418449995, -80.43386936187744|35.82994326305995, -80.43713092803955|35.82994326305995, -80.43713092803955|35.83606676353164, -80.4464864730835|35.833700921643256, -80.44863224029541|35.82632460883758, -80.4560136795044|35.82632460883758, -80.46099185943604|35.82750764856416, -80.4644250869751|35.82750764856416, -80.4644250869751|35.841772327248535, -80.47360897064209|35.84309428955129, -80.4779863357544|35.839267496148985, -80.48330783843994|35.83321382779138, -80.48717021942139|35.83077831367873, -80.48656940460205|35.83112624884307, -80.48056125640869|35.82994326305995, -80.47704219818115|35.82451521985134, -80.47180652618408|35.81762524577882, -80.46863079071045|35.80405233580042, -80.46425342559814|35.80029327365701, -80.46648502349854|35.79917944330494, -80.47146320343018|35.79709096930422, -80.47446727752686|35.789641631613904, -80.4768705368042|35.78323603525509, -80.47240734100342|35.772721383168864, -80.4548978805542|35.76694121398373, -80.45069217681885|35.75753883670137, -80.45300960540771|35.75370791996597, -80.45764446258545|35.74562756362683, -80.45979022979736|35.7348292553962, -80.453782081604|35.73496859773219, -80.44605731964111|35.7223571289248, -80.41266918182373|35.72521404540483, -80.39618968963623|35.72047568895225, -80.39018154144287|35.719221370954365, -80.38503170013428|35.718872945784, -80.37902355194092|35.716085489571846, -80.3725004196167|35.7167126757211, -80.36288738250732|35.72068474003213, -80.34297466278076|35.71782766113127, -80.33121585845947|35.71162535681875, -80.32580852508545|35.70430741084701, -80.32409191131592|35.697476704814925, -80.33018589019775|35.68855410728362, -80.33318996429443|35.67949107249936, -80.3303575515747|35.6738435841092, -80.32220363616943|35.667428668116884, -80.3095006942749|35.65968824631061, -80.3051233291626|35.65097065679229, -80.2996301651001|35.638834188134076, -80.29001712799072|35.63360238309948, -80.27791500091553|35.63067242268964, -80.26383876800537|35.620556257812794, -80.25104999542236|35.60932232697874, -80.23869037628174|35.59724932607625, -80.23285388946533|35.588385327931064, -80.22058010101318|35.58112588985184, -80.20933628082275|35.56869955531624, -80.20744800567627|35.556271293256444, -80.20933628082275|35.54824077330695, -80.20495891571045|35.54474899200284, -80.19869327545166|35.53636809653649, -80.19551753997803|35.529662749656346, -80.1963758468628|35.52554147717437, -80.18985271453857|35.519114663841364, -80.18556118011475|35.50982281746826, -80.1846170425415|35.503534491811926, -80.18195629119873';

		var latLngArray = boundaries.split('|');
                var points = [];
                for (var i = 0; i < latLngArray.length; i++) {
                	pos = latLngArray[i].split(',');
                        points.push(new google.maps.LatLng(parseFloat(pos[0]), parseFloat(pos[1])));
                }
		
                var shape = new google.maps.Polygon({
                        paths: points,
                        strokeColor: '#2E2EFE',
                        strokeOpacity: 0.8,
                        strokeWeight: 2,
                        fillColor: '#2E2EFE',
                        fillOpacity: 0.35
                });

                shape.setMap(map);
	}
	google.maps.event.addDomListener(window, 'load', initialize);
</script>
<div id="entry-full">
    <div id="page-top">	 
    	<h1 class="title"><?php /* the_title(); */ ?></h1> 
    	<?php if( isset($meta['Subheader'] ) && $meta['Subheader'] <> '') { ?>
        	<span class="subheader"><?php echo $meta['Subheader']; ?></span>
    	<?php } ?>
    </div> <!-- #page-top  -->

    <div id="left" class="full-width">
        <div class="post-full single full-width">

                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    	
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	 
                             <?php if ( has_post_thumbnail() && isset($options[$location . '_thumb']) && $options[$location . '_thumb'] == '1' ) :
								  	$thumbid = get_post_thumbnail_id($post->ID);
									$img = wp_get_attachment_image_src($thumbid,'full');
									$img['title'] = get_the_title($thumbid); ?>

		                            <div class="thumb loading"> 
		                            	<?php the_post_thumbnail("large"); ?>
		                            	<a href="<?php echo $img[0]; ?>" class="zoom-icon" rel="shadowbox" ></a>                                    		
									</div> <!-- .thumbnail  -->                        
							<?php endif; ?>
							    
                        	<?php the_content(); ?> 

							<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>                         
					</article>

                    <!--<div class="meta">
                        <?php the_time('M j, Y | ');  _e('Posted by ','InterStellar');  the_author_posts_link(); ?> | <?php comments_popup_link(__('0 comments','InterStellar'), __('1 comment','InterStellar'), '% '.__('comments','InterStellar')); ?>
                    </div>-->  <!-- .meta  -->
	<?php /* comments_template(); */ ?>

	<?php endwhile; else: ?>

		<p><?php _e('Sorry, no posts matched your criteria.','InterStellar'); ?></p>

<?php endif; ?>
            
         </div> <!-- .post-full  -->
    </div> <!-- #left  -->
</div> <!-- #entry-full  -->
<?php get_footer(); ?>