/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

require('@fortawesome/fontawesome-free/js/all')

require('tinymce');
require('tinymce/themes/silver/theme');

require('tinymce/plugins/advlist/plugin');
require('tinymce/plugins/autolink/plugin');
require('tinymce/plugins/lists/plugin');
require('tinymce/plugins/image/plugin');
require('tinymce/plugins/link/plugin');
require('tinymce/plugins/charmap/plugin');
require('tinymce/plugins/print/plugin');
require('tinymce/plugins/preview/plugin');
require('tinymce/plugins/hr/plugin');
require('tinymce/plugins/anchor/plugin');
require('tinymce/plugins/pagebreak/plugin');
require('tinymce/plugins/wordcount/plugin');
require('tinymce/plugins/visualblocks/plugin');
require('tinymce/plugins/code/plugin');
require('tinymce/plugins/fullscreen/plugin');
require('tinymce/plugins/media/plugin');
require('tinymce/plugins/nonbreaking/plugin');
require('tinymce/plugins/save/plugin');
require('tinymce/plugins/table/plugin');
require('tinymce/plugins/contextmenu/plugin');
require('tinymce/plugins/directionality/plugin');
require('tinymce/plugins/emoticons/js/emojis');
require('tinymce/plugins/emoticons/plugin');
require('tinymce/plugins/template/plugin');
require('tinymce/plugins/paste/plugin');
require('tinymce/plugins/textcolor/plugin');
require('tinymce/plugins/colorpicker/plugin');
require('tinymce/plugins/textpattern/plugin');
require('tinymce/plugins/searchreplace/plugin');
require('tinymce/plugins/visualchars/plugin');
require('tinymce/plugins/insertdatetime/plugin');

require.context(
    'file-loader?name=[path][name].[ext]&context=node_modules/tinymce!tinymce/skins',
    true,
    /.*/
  );
