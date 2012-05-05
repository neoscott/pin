<!doctype html>
<head>
	<title><?=$apptitle?></title>
	<meta charset="utf-8" />
	<link href="css/generic.css" media="screen" rel="stylesheet" type="text/css" />
	<link href="css/<?=$apptitle?>_style.css" media="screen" rel="stylesheet" type="text/css" />
</head>
<body>

<div id="header">
	<form>
	<b><?=$apptitle?></b><br/><br/>
	<?=$placeholder?> <input size="30" id="search" name="q" placeholder="<?=$placeholder?>" value="<?=$q?>"/> 
	<input type="submit" value="<?=$btn_search?>"/>
	</form>
</div>

<div id="container">
	<?php if( $items ): ?>
		<?php foreach( $items as $item ): extract( $item ); if( !$img ) $img = 'img/photo.png'; ?>
		<div class="item">
			<?php if( $total ): ?><div class="total"><?=$total?></div><?php endif ?>
			<a href="<?=$url?>" title="<?=$title?>" target="_blank">
				<img src="img/blank.png" style="background:url('<?=$img?>') no-repeat left top" width="210" height="200"/><br/>
				<?=$title?>
			</a><br/>
			<?=$text?>
		</div>
		<?php endforeach ?>
	<?php else: ?>
		<p align="center">sin resultados</p>
	<?php endif ?>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
<script src="js/jquery.masonry.min.js"></script>

<div id="footer">
	<?=$credits?>
</div>


<script>
$(function(){
	$('#search').focus();

	$('#container').masonry({
	  // options...
	  isAnimated: true,
	  animationOptions: {
	    duration: 750,
	    easing: 'linear',
	    queue: false
	  }
	});
});
</script>

</body>
</html>