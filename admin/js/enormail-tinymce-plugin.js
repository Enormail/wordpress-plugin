(function() {
    tinymce.create('tinymce.plugins.enormail_form', {
        init : function(editor, url) {
            editor.addCommand('enormail_form_dialog', function() {
                    editor.windowManager.open({
                            id: 'enormail_form_dialog',
                            title: editor.getLang( 'enormail.popupTitle', 'Enormail signup form' ),
                            file: ajaxurl + '?action=enormail_tinymce_window',
                            width: 480 + parseInt(editor.getLang('example.delta_width', 0)),
                            height: 240 + parseInt(editor.getLang('example.delta_height', 0)),
                            inline : 1
                        }, {
                            plugin_url : url
                        }
                    );
                }
            );
            editor.addButton('enormail_form', {
                    title : editor.getLang( 'enormail.buttonTitle', 'Add an Enormail signup form' ),
                    image : url + '/../img/enormail-shortcode-icon.png',
                    cmd :  'enormail_form_dialog'
                }
            );
        },
        createControl : function(n, ml) {
            return null;
        }
    });
    tinymce.PluginManager.add('enormail_form', tinymce.plugins.enormail_form);
})();
