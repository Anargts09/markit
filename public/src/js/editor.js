jQuery(document).ready(function() {
	$('#tags').tagsInput({
	   	'height':'auto',
	   	'width':'100%',
	   	'interactive':true,
	   	'defaultText':'Таг нэмэх',
	   	'delimiter': [','],
	   	'removeWithBackspace' : true,
	   	'minChars' : 3,
	   	'maxChars' : 0,
	   	'autocomplete_url':'http://localhost:8000/api/alltag',
	   	'autocomplete':{autoFill:true}
	});
	var simplemde = new SimpleMDE({
	    autosave: {
	        enabled: false,
	        uniqueId: "MyUniqueID",
	        delay: 1000,
	    },
	    element: document.getElementById("inputPane"),
	    hideIcons: ["guide"],
	    renderingConfig: {
	        singleLineBreaks: true,
	        codeSyntaxHighlighting: true,
	    },
	    showIcons: ["code"],
	    spellChecker: false,
	});
});


var triggerEnter = function(elem) {
   var e = jQuery.Event("keypress");
   e.which = 13; //choose the one you want
   e.keyCode = 13;
   elem.trigger(e);
};

$(document).on('focus', '#tags_addTag input',function(){
    $(this).keypress(function (e) {
		var keyCode = e.keyCode || e.which; 
	   	if ((keyCode === 32)||(keyCode === 9)) {
	    	e.preventDefault();
	      	triggerEnter($(e.target));
	   	}
    });
});

function enableTab(id) {
    var el = document.getElementById(id);
    el.onkeydown = function(e) {
        if (e.keyCode === 9) { // tab was pressed

            // get caret position/selection
            var val = this.value,
                start = this.selectionStart,
                end = this.selectionEnd;

            // set textarea value to: text before caret + tab + text after caret
            this.value = val.substring(0, start) + '\t' + val.substring(end);

            // put caret at right position again
            this.selectionStart = this.selectionEnd = start + 1;

            // prevent the focus lose
            return false;

        }
    };
}

$('#checkbox1').change(function() {
    if($(this).is(":checked")) {
    	$('button[type=submit]').html('Post to Public');
    }else{
    	$('button[type=submit]').html('Save as draft');
    }
});


