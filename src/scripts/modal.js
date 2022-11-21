import HystModal from "hystmodal";

export const modal = new HystModal({
  linkAttributeName: "data-hystmodal",
  beforeOpen: function (modal) {
    if (modal.openedWindow.parentNone !== document.body) {
      document.body.appendChild(modal.openedWindow)
    }

    let videoframe = modal.openedWindow.querySelector("iframe");
    if (videoframe) {
      // console.log('beforeOpen', videoframe)
      videoframe.contentWindow.postMessage(
        '{"event":"command","func":"playVideo","args":""}',
        "*"
      );
    }
  },
  afterClose: function (modal) {
    let videoframe = modal.openedWindow.querySelector("iframe");
    if (videoframe) {
      // console.log('afterClose', videoframe)
      // videoframe.contentWindow.postMessage('{"event":"command","func":"stopVideo","args":""}', '*');
      videoframe.contentWindow.postMessage(
        '{"event":"command","func":"stopVideo","args":""}',
        "*"
      );
    }
  },
});
