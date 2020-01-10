import $ from 'jquery';
window.jQuery = $;
require('jquery-visible');
require('slick-carousel');

export default {
  init() {
  	// Wrap embedded objects and force them into 16:9
  	$('.page-content iframe, .page-content embed, .page-content video, #video-player iframe').not('.ignore-ratio').wrap('<div class="video-container" />');

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

    // WOOCOMMERCE: Dismiss Notices Wrapper
    $('a[href="#dismiss"]').on('click', e => {
      e.preventDefault();
      $('.woocommerce-notices-wrapper').addClass('dismiss');
    });

    // MODULE: Video Toggle
    $('.video-control').click(e => {
      $('#member-video').get(0).pause();
      const $this = $(e.currentTarget);
      const id = $this.attr('id');
      const thumb = $this.find('img').clone();
      const desc = $this.find('.video-desc').clone();
      $('#video-current-thumb span').html(thumb);
      $('#video-current-info').html(desc);
      $('#video-player, #video-current').addClass('is-active');
      $('.video-control').removeClass('is-active');
      $this.addClass('is-active');
      $('#video-daddy').attr('src', `https://www.youtube.com/embed/${id}?autoplay=1&color=white`);
    });
    $('.video-close').click(e => {
      $('#video-daddy').attr('src', 'about:blank');
      $('#video-current-thumb span').html('');
      $('#video-current-info').html('');
      $('#video-player, #video-current, .video-control').removeClass('is-active');
      $('#member-video').get(0).play();
    });

    // MODULE: Video Tabs Toggle
    $('#video-tabs a').click(e => {
      e.preventDefault();
      $(window).scrollTop(0);
      const $this = $(e.currentTarget);
      const target = $this.attr('href');
      $('.module-video-lists ul.is-active, #video-tabs a').removeClass('is-active');
      $this.addClass('is-active');
      $(target).addClass('is-active');
    });

    // MODULE: Contact Page Photos Aggrigate
    const photosCount = $('#photos-list li').length;
    let photosStart = 5;
    const photosStep = 5;
    let photoNow = 0;
    if(photosCount > 0) {
      for(photoNow = 0; photoNow < photosStart; photoNow++) {
        const getObj = $('#photos-list li').eq(photoNow).find('a');
        const getImg = getObj.data('image');
        const setImg = getObj.append(getImg);
      }
      $('#photos-list-more').click(e => {
        const photoChunk = photosStep + photoNow;
        for(''; photoNow < photoChunk; photoNow++) {
          const getObj = $('#photos-list li').eq(photoNow).find('a');
          const getImg = getObj.data('image');
          const setImg = getObj.append(getImg);
        }
        if(photoNow >= photosCount) {
          $(e.currentTarget).addClass('is-done');
        }
      });
    }
  },
};
