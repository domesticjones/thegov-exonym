import $ from 'jquery';
window.jQuery = $;
require('jquery-scrollify');

// TODO: Pause videos on section change

export default {
  init() {
    $.scrollify({
      section: '.module',
      before: () => {
        const cur = $.scrollify.current();
        const curPlayer = cur.find('.home-bgvideo');
        if(curPlayer && curPlayer.length) {
          const curSource = curPlayer.find('source');
          const curVid = curSource.data('realvideo');
          curSource.attr('src', curVid);
          curPlayer[0].load();
          curPlayer[0].play();
        }
        const curHex = cur.data('section-hex');
        const curAccent = cur.data('section-color');
        const colorDefault = '#f2f2f2';
        const shadowDefault = '0 0 1rem';
        const coloring = [
          '#header',
          '#header .social-info',
          '.home-heading',
          '.home-heading span',
          '.home-cta',
          '.home-vids-list .release',
        ];
        const colorSet = coloring.join(', ');
        if(curHex && curHex.length > 0) {
          $(colorSet).css({'color': curHex, 'background-color': curHex, 'box-shadow': `${shadowDefault} ${curHex}`, 'border-color': curHex});
        } else {
          $(colorSet).css({'color': colorDefault, 'background-color': colorDefault, 'box-shadow': `${shadowDefault} ${colorDefault}`, 'border-color': colorDefault});
        }
      },
    });
  },
  finalize() {
  },
};
