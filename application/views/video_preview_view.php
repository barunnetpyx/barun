<?php 
//echo "<pre>"; print_r($data); echo "</pre>";
if($data->api == 5) $video = "https://www.youtube.com/watch?v=".$data->video_path;
else $video = HTTP_UPLOADS .$data->video_path;
if(!empty($data->video_thumb)) $image = HTTP_UPLOADS ."images/" .$data->video_thumb;
?>
<div class="modal-header">
	<button class="close" data-dismiss="modal" type=
	"button">×</button>
	<h4 class="modal-title" id="myModalLabel"><?php if(isset($data->title) && !empty($data->title)) echo $data->title; ?></h4>
</div>
<div class="modal-body">
	<div class="center">
		<div id='vidShow' style='text-align:center'></div>
	</div>
	<script type='text/javascript'>
		function loadPlayer() {
			var options = {
				primary: 'flash',
				autostart: true,
				image: '<?php echo $image; ?>',
				width: 555,
				aspectratio: '16:9',
				file: '<?php echo $video ?>',
				advertising: {
					client: 'vast',
					schedule: {
						myPreroll: {
							offset: 'pre',
							tag: 'http://u-ads.adap.tv/a/h/Zn3aGiSnniJx5FpwuzVh_JvqF3uzW2Hq76CVF4PcswCM9UxrKzp0xA==?cb={CACHE_BREAKER}&pageUrl=http%3A%2F%2Ftunechannel.tv&description=VIDEO_DESCRIPTION&duration=VIDEO_DURATION&id=VIDEO_ID&keywords=VIDEO_KEYWORDS&title=VIDEO_TITLE&url=VIDEO_URL&eov=eov'
						}
					}
				}
			};
			jwplayer('vidShow').setup(options);
		}
		loadPlayer();
		var jwp = jwplayer('vidShow');
		jwp.onAdComplete(function() {
			jwp.onBuffer(function(){
				setTimeout(function() {
					jwp.pause();
				}, 10);
				setTimeout(function() {
					jwp.play();
				}, 1000);
			});     
		});
		jwp.onAdError(function(){
			jwp.onBuffer(function(){
				setTimeout(function() {
					jwp.pause();
				}, 10);
				setTimeout(function() {
					jwp.play();
				}, 1000);
			});
		});
	</script>
</div>
