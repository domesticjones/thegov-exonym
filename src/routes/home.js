import $ from 'jquery';
window.jQuery = $;
require('jquery-scrollify');

export default {
  init() {
    $.scrollify({
      section: '.module',
    });
  },
  finalize() {
  },
};
