import $ from 'jquery';
window.jQuery = $;
require('jquery-scrollify');

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
        const curAccent = cur.data('data-section-color');
        if(curAccent && curAccent.length > 0) {

        }
      },
    });

  },
  finalize() {
  },
};
