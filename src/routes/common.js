import $ from 'jquery';
window.jQuery = $;
require('jquery-visible');
require('slick-carousel');

export default {
  init() {
  	// Wrap embedded objects and force them into 16:9
  	$('.page-content iframe, .page-content embed, .page-content video').not('.ignore-ratio').wrap('<div class="video-container" />');

  	// HEADER: Responsive Nav Toggle
  	$('#responsive-nav-toggle').click(e => {
  		const $this = $(e.currentTarget);
  		$this.toggleClass('is-active');
  	});

    // MODULES: Parallax Animation
  	$(window).on('load resize scroll', () => {
  	   // MODULES: Parallax
  		const d_scroll = $(window).scrollTop();
  		const w_height = $(window).height();
  		$('.animate-parallax').each((i, e) => {
  			const $this = $(e);
  			const $thisBg = $this.find('.module-bg');
  			const p_position = $this.offset().top;
  			const e_height = $this.outerHeight();
  			const ebg_height = $this.find('.module-bg').outerHeight();
  			const bg_diff = ebg_height - e_height;
  			const dhit_in = p_position - w_height;
  			const dhit_out = p_position + e_height;
  			const dhit_read = p_position - w_height - d_scroll;
  			// Boolean hit Check
  			if (dhit_read <= 0 && d_scroll <= dhit_out) {
  				const per_scrolled = (d_scroll - dhit_in) / (dhit_out - dhit_in);
  				const offset = (bg_diff * per_scrolled);
  				$thisBg.css('transform', `translateY(-${offset}px)`);
  			}
  		});
  	});

    // MODULES: Add Visible Class to First Module onLoad
    $('.module').first().addClass('is-visible');
  },
  finalize() {
  	// MODULES: Animate onScreen
  	$(window).on('load resize scroll', () => {
  		$('.animate-on-enter').each((i,e) => {
  			const $this = $(e);
  			if ($this.visible(true)) {
  				$this.addClass('is-visible');
  			}
  		});
  		$('.animate-on-leave').each((i,e) => {
  			const $this = $(e);
  			if (!$this.visible(true)) {
  				$this.removeClass('is-visible');
  			}
  		});
  	});

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
          const thatLow = $that.replace(/\s+/g, '-').toLowerCase();
          let thatActive = '';
          if($that == val) {
            thatActive = 'is-active';
          }
          if($that.length > 0) {
            attrs.push(`<li><label class="${thatActive}" data-target="${id}">${$that}</label></li>`);
          }
        });
        $prodSelectCheck.append(`<ul class="product-attrs-buttons">${attrs.join('')}</ul>`);
      });
      $($prodSelectCheck).find('label').on('click', (e) => {
        const $event = $(e.currentTarget);
        const target = $event.data('target');
        const eValue = $event.text();
        $(`#${target}`).val(eValue).trigger('change');
        $event.closest('ul').find('label').removeClass('is-active');
        $event.addClass('is-active');
      });
    }

    // WOOCOMMERCE: Dismiss Notices Wrapper
    $('a[href="#dismiss"]').on('click', e => {
      e.preventDefault();
      $('.woocommerce-notices-wrapper').addClass('dismiss');
    });
  },
};
