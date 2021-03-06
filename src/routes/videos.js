import $ from 'jquery';
window.jQuery = $;

export default {
  init() {
    // MODULE: Video Toggle
    $('.video-control').on('click', e => {
      $('#member-video').get(0).pause();
      const $this = $(e.currentTarget);
      const id = $this.attr('id');
      if ('URLSearchParams' in window) {
        let videoGo = new URLSearchParams(window.location.search)
        videoGo.set('watch', id);
        const newRelativePathQuery = window.location.pathname + '?' + videoGo.toString();
        history.pushState(null, '', newRelativePathQuery);
      }
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
  },
  finalize() {
    // Find Video on Load
    const videoLoad = new URLSearchParams(window.location.search);
    if(videoLoad) {
      const vidTarget = videoLoad.get('watch');
      $(`#${vidTarget}`).click();
    }
  },
};
