import $ from 'jquery';
window.jQuery = $;

export default {
  init() {
  },
  finalize() {
    // PRODUCT: Transmute Product Variable Selects into Radio Buttons
    const $prodSelectCheck = $('#product-select-flag');
    if($prodSelectCheck.length > 0) {
      $('.variations_form select').each((i,e) => {
        const $this = $(e);
        const id = $this.attr('id');
        const val = $this.val();
        const valLabel = $(`label[for="${id}"]`).text();
        let attrs = [`<li class="product-attrs-heading">Choose a ${valLabel}</li>`];
        $this.find('option').each((c,o) => {
          const $that = $(o).val();
          const $thatName = $(o).text();
          let thatActive = '';
          if($that == val) {
            thatActive = 'is-active';
          }
          if($that.length > 0) {
            attrs.push(`<li><label class="${thatActive}" data-target="${id}" data-choice="${$that}">${$thatName}</label></li>`);
          }
        });
        $prodSelectCheck.append(`<ul class="product-attrs-buttons">${attrs.join('')}</ul>`);
      });
      $($prodSelectCheck).find('label').on('click', (e) => {
        const $event = $(e.currentTarget);
        const target = $event.data('target');
        const choice = $event.data('choice');
        $(`#${target}`).val(choice).trigger('change');
        $event.closest('ul').find('label').removeClass('is-active');
        $event.addClass('is-active');
      });
    }
  },
};
