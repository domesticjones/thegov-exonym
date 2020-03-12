import $ from 'jquery';
window.jQuery = $;

export default {
  init() {
  },
  finalize() {
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
