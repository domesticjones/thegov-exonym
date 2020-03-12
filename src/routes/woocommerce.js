import $ from 'jquery';
window.jQuery = $;

export default {
  init() {
  },
  finalize() {
    // WOOCOMMERCE: Dismiss Notices Wrapper
    $('a[href="#dismiss"]').on('click', e => {
      e.preventDefault();
      $('.woocommerce-notices-wrapper').addClass('dismiss');
    });
  },
};
