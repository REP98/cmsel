//LOAD CODE
const CodeMirror = require('codemirror');
window.CodeMirror = CodeMirror;
global.CodeMirror = CodeMirror;
//CODE MODE
require('codemirror/mode/meta.js');
require('codemirror/mode/css/css.js');
require('codemirror/mode/sql/sql.js');
require('codemirror/mode/htmlembedded/htmlembedded.js');
require('codemirror/mode/htmlmixed/htmlmixed.js');
require('codemirror/mode/http/http.js');
require('codemirror/mode/javascript/javascript.js');
require('codemirror/mode/jsx/jsx.js');
require('codemirror/mode/markdown/markdown.js');
require('codemirror/mode/php/php.js');
require('codemirror/mode/properties/properties.js');
require('codemirror/mode/sass/sass.js');
require('codemirror/mode/shell/shell.js');
require('codemirror/mode/stylus/stylus.js');
require('codemirror/mode/vue/vue.js');
require('codemirror/mode/xml/xml.js');
require('codemirror/mode/xquery/xquery.js');
//CODE KEYMAP
require('codemirror/keymap/sublime.js');
//CODE ADDONS
//Fold
require('codemirror/addon/fold/foldcode.js');
require('codemirror/addon/fold/foldgutter.js');
require('codemirror/addon/fold/xml-fold.js');
require('codemirror/addon/fold/brace-fold.js');
require('codemirror/addon/fold/comment-fold.js');
require('codemirror/addon/fold/indent-fold.js');
require('codemirror/addon/fold/markdown-fold.js');
//Hint
require('codemirror/addon/hint/show-hint.js');
require('codemirror/addon/hint/javascript-hint.js');
require('codemirror/addon/hint/xml-hint.js');
require('codemirror/addon/hint/html-hint.js');
require('codemirror/addon/hint/css-hint.js');
require('codemirror/addon/hint/anyword-hint.js');
require('codemirror/addon/hint/sql-hint.js');
//Active Line
require('codemirror/addon/selection/active-line.js');
// EDIT
require('codemirror/addon/edit/matchbrackets.js');
require('codemirror/addon/edit/closebrackets.js');
require('codemirror/addon/edit/matchtags.js');
require('codemirror/addon/edit/trailingspace.js');
require('codemirror/addon/edit/closetag.js');
require('codemirror/addon/edit/continuelist.js');
// Dialog
require('codemirror/addon/dialog/dialog.js');
// SEARCH
require('codemirror/addon/search/searchcursor.js');
require('codemirror/addon/search/search.js');
require('codemirror/addon/search/jump-to-line.js');
require('codemirror/addon/search/matchesonscrollbar.js');
require('codemirror/addon/search/match-highlighter.js');
// Scroll
/*require('codemirror/addon/scroll/annotatescrollbar.js');
require('codemirror/addon/scroll/simplescrollbars.js'); */
// Coments
require('codemirror/addon/comment/comment.js');
require('codemirror/addon/comment/continuecomment.js');
// SECTION
require('codemirror/addon/selection/mark-selection.js');
require('codemirror/addon/selection/selection-pointer.js');
// DISPLAY
require('codemirror/addon/display/placeholder.js');
require('codemirror/addon/display/fullscreen.js');
require('codemirror/addon/display/autorefresh.js');

CodeMirror.commands.autocomplete = function(cm) {
	cm.showHint({hint: CodeMirror.hint.anyword});
}

_$().__proto__.codeditor = function() {
	return this.each((el) => {
		let code = CodeMirror.fromTextArea(el, {
			mode: _$(this).data('lang').trim(),
			lineNumbers: true,
			autoCloseBrackets:true,
			styleActiveLine: true,
			styleSelectedText: true,
			matchBrackets: true,
			theme:'neat',
			autoCloseTags:true,
			keyMap: "sublime",
			height:500,
			highlightSelectionMatches: {showToken: /\w/, annotateScrollbar: true},
			extraKeys: {
				"Ctrl-Space": "autocomplete",
				"Ctrl-Q": function(cm){ cm.foldCode(cm.getCursor()); },
				"F11": function(cm) {
				  cm.setOption("fullScreen", !cm.getOption("fullScreen"));
				},
				"Esc": function(cm) {
				  if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
				},
				"Alt-F": "findPersistent"
			},
			foldGutter: true,
			// scrollbarStyle: "simple",
			gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"]
		})
		_$(el).data('code', code)
		_$.hooks.run('codeditor.init', el, code)
	});
}