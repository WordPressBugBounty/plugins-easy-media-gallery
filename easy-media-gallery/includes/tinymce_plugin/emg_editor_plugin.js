(function () {

    function emgIsGutenbergActive() {
        return typeof wp !== 'undefined' && typeof wp.blocks !== 'undefined';
    }

    tinymce.create('tinymce.plugins.emgicons', {

        init: function (ed, url) {

            var t = this;
            t.url = url;

            if (emgIsGutenbergActive()) {

                ed.addButton('emgicons', {
                    id: 'emgicons_gut_shorcode',
                    classes: 'emgicons_gut_shorcode_btn',
                    text: 'Easy Media Gallery',
                    title: 'Easy Media Shortcode',
                    cmd: 'mceemgicons_mce',
                    image: url + '/emg-scmanager-icon.png'
                });

            }

        },

    });

    tinymce.PluginManager.add('emgicons', tinymce.plugins.emgicons);
})();