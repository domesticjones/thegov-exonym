import $ from 'jquery';
window.jQuery = $;

export default {
  init() {
  	// Wrap embedded objects and force them into 16:9
    const vidRatioForceItems = [
      '.page-content iframe',
      '.page-content embed',
      '.page-content video',
      '#video-player iframe',
    ];
  	$(vidRatioForceItems.join(', ')).not('.ignore-ratio').wrap('<div class="video-container" />');
  },
  finalize() {
  },
};
