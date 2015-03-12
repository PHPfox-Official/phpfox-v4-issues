$(document).ready(function(){
	$('#selectLanguage').change(function(){
		$('#phrasesContainer').html('Loading...');
		$.ajaxCall('language.loadMailPhrases', 'sLanguage=' + $(this).val());		
	});
});

