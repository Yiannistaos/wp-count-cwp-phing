/* ======================================================
 # [EXTENSION_REAL_NAME] for [CMS] - v[VERSION] ([FREE_PRO_VERSION] version)
 # -------------------------------------------------------
 # [FOR_CMS]
 # Author: [AUTHOR]
 # [COPYRIGHT]
 # License: [LICENSE]
 # Website: [WEBSITE]
 # Demo: [DEMO]
 # Support: [SUPPORT_EMAIL]
 # Last modified: [LAST_MODIFIED]
 ========================================================= */
 
var jQueryWeb357 = jQuery.noConflict();
jQueryWeb357(document).ready(function ($) {

	function countWords(s) {
		s = s.replace(/\n/g,' '); // newlines to space
		s = s.replace(/(^\s*)|(\s*$)/gi,''); // remove spaces from start + end
		s = s.replace(/[ ]{2,}/gi,' '); // 2 or more spaces to 1
		return s.split(' ').length; 
	}

	// Characters count without space/tags/htmlentities
	function countCharactersWithoutSpace(s)
	{
		var MatchHtmlEntitiesRegex = /&(?:[a-z\d]+|#\d+|#x[a-f\d]+);/gi;
		var MatchHtmlTagsAndSpaceRegex = /(<([^>]+)>)|\s+/gi;
		var charCountNoSpace = s.replace(MatchHtmlEntitiesRegex, '');
		return  charCountNoSpace.replace(MatchHtmlTagsAndSpaceRegex, '').length;
	}
	
	function countParagraphs(s)
	{
		return s.replace(/\n$/gm, '').split(/\n/).length;
    }
	
    counter = function (id, content) {

		// id: e.g. content, acf-field_6008f41e79a79-row-0-field_6008f41e85206

		var div = document.getElementById(id);
		var editor_content = div.value;

		if (content !== undefined)
		{
			var editor_content = content;
		}

		if (editor_content.length == 0) {
			$("#" + id).next().closest('div').find('.w357-wordCount').text(0);
			$("#" + id).next().closest('div').find('.w357-charCountNoSpace').text(0);
			$("#" + id).next().closest('div').find('.w357-paragraphsCount').text(0);
			return;
		}

		var wordCount = countWords(editor_content);
		var charCountNoSpace = countCharactersWithoutSpace(editor_content);
		var paragraphsCount = countParagraphs(editor_content);
		
		$("#" + id).next().closest('div').find('.w357-wordCount').text(wordCount);
		$("#" + id).next().closest('div').find('.w357-charCountNoSpace').text(charCountNoSpace);
		$("#" + id).next().closest('div').find('.w357-paragraphsCount').text(paragraphsCount);
		
	};

	var insertAfter = function (referenceNode, newNode) {
		referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
    };
    
	var wp_textareas = document.querySelectorAll("textarea");

	// get options
	var showCharacters = parseInt(w357CountCWP.show_characters);
	var showWords = parseInt(w357CountCWP.show_words);
	var showParagraphs = parseInt(w357CountCWP.show_paragraphs);
	var showCopyrightLink = parseInt(w357CountCWP.show_copyright_link);

	var num = 1;
	for (var i = 0; i < wp_textareas.length; i++) {

		var id = wp_textareas[i].getAttribute("id");

		var el = document.createElement("div");
		el.setAttribute("class", "web357-count-cwp w357-class-id-" + num);
		el.innerHTML = "";

		if (showWords === 1)
		{
			el.innerHTML += "<div class=\"w357-word-count w357-ml25\" >"+w357CountCWP.words+": <span class=\"w357-wordCount\" id=\"wordCount-" + id + "\">0</span></div>";
		}

		if (showCharacters === 1)
		{
			el.innerHTML += "<div class=\"w357-char-count w357-ml25\">"+w357CountCWP.characters+": <span class=\"w357-charCountNoSpace\" title=\"the count of characters excludes white spaces\" id=\"charCountNoSpace-" + id + "\">0</span></div>";
		}

		if (showParagraphs === 1)
		{
			el.innerHTML += "<div class=\"w357-paragraphs-count w357-ml25\">"+w357CountCWP.paragraphs+": <span class=\"w357-paragraphsCount\" id=\"paragraphsCount-" + id + "\">0</span></div>";
		}
		
		if (showCopyrightLink === 1)
		{
			el.innerHTML += "<div class=\"w357-copyright-link\"><a title=\"Count the Characters/Words/Paragraphs while editing - A plugin developed with 🤍 by Web357\" href=\"https://www.web357.com/product/count-cwp-wordpress-plugin?utm_source=PostPage&utm_medium=MoreLink&utm_content=countcwpwp&utm_campaign=more\" target=\"_blank\">Developed by Web357</a></div>";
		}

		var div = document.getElementById(id);
		insertAfter(div, el);

		$("#" + id).next().closest('div').find('.w357-wordCount').text(0);
		$("#" + id).next().closest('div').find('.w357-charCountNoSpace').text(0);
		$("#" + id).next().closest('div').find('.w357-paragraphsCount').text(0);
		
		$('#' + id).on("setcontent beforeaddundo load propertychange keyup keydown keypress blur focus input paste", function () {
			counter(this.id);
		});

		$('#' + id).trigger('load');

		num++;
	}

	// ACF
	if (typeof acf !== 'undefined') {

        acf.add_action('append', function( $el ){ 

            $('textarea').on('keyup', function(e) {

                var textarea_id = $(this).attr('id');
                var textarea_val = $(this).val();

                counter(textarea_id, textarea_val);

            })

        });

		// This is needed for running the keyup event in the text (HTML) view of the editor
		var fields = acf.getFields({
			type: 'wysiwyg'
		});
		fields.forEach(async function(e) {
			var field = acf.getField(e.data.key);
			$(this).each(function () {
				field.on('keyup', function () {

					// // Get the editor content (html)
					get_ed_content = field.val();
					id = e.data.id;
					counter(id, get_ed_content);

				});
			});
		})
	}
});