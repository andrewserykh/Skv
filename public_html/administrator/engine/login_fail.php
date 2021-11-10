<link rel="stylesheet" type="text/css" href="css/fs-normalize.css" />
<link rel="stylesheet" type="text/css" href="css/fs-form.css" />
<link rel="stylesheet" type="text/css" href="css/fs-component.css" />
<link rel="stylesheet" type="text/css" href="css/fs-cs-select.css" />
<link rel="stylesheet" type="text/css" href="css/fs-cs-skin-boxes.css" />
<script src="js/modernizr.custom.js"></script>
<div class="container">

	<div class="fs-form-wrap" id="fs-form-wrap">
		<div class="fs-title">
			<h1><?=$settings['sitename'];?> - вход в разел администрирования</h1>
		</div>
		<form id="myform" class="fs-form fs-form-full" action="/administrator/engine/login_auth.php" autocomplete="on">
			<ol class="fs-fields">
				<li>
					<label class="fs-field-label fs-anim-upper" for="authname">Имя пользователя:</label>
					<input class="fs-anim-lower" id="authname" name="authname" type="text" placeholder="логин" required/>
				</li>
				<li>
					<label class="fs-field-label fs-anim-upper" for="authpassw">Пароль:</label>
					<input class="fs-anim-lower" id="authpassw" name="authpassw" type="password" placeholder="пароль" required/>
				</li>
			</ol><!-- /fs-fields -->
			<button class="fs-submit" type="submit">Отправить</button>
		</form><!-- /fs-form -->
	</div><!-- /fs-form-wrap -->
</div><!-- /container -->

		<script src="js/classie.js"></script>
		<script src="js/selectFx.js"></script>
		<script src="js/fullscreenForm.js"></script>
		<script>
			(function() {
				var formWrap = document.getElementById( 'fs-form-wrap' );

				[].slice.call( document.querySelectorAll( 'select.cs-select' ) ).forEach( function(el) {	
					new SelectFx( el, {
						stickyPlaceholder: false,
						onChange: function(val){
							document.querySelector('span.cs-placeholder').style.backgroundColor = val;
						}
					});
				} );

				new FForm( formWrap, {
					onReview : function() {
						classie.add( document.body, 'overview' ); 
					}
				} );
			})();
		</script>

<?
quit();
?>