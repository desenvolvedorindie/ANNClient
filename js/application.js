!function($) {
    $(function() {
        var mime = 'text/x-annsql';
        window.editor = CodeMirror.fromTextArea(document.getElementById('code'), {
            mode: mime,
            indentWithTabs: true,
            smartIndent: true,
            lineNumbers: true,
            matchBrackets: true,
            autofocus: true
        });
    });

}(window.jQuery);