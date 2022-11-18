import { modal } from "./modal";

const triggerButtons = document.querySelectorAll("[data-modal-video]") || [];

triggerButtons.forEach((button) => {
  button.addEventListener("click", (e) => {
    e.preventDefault();

    if (!button.dataset.videoModalId) {
      button.dataset.videoModalId = `modal-${Date.now()}`;
      const urlWithParams = new URL(button.dataset.modalVideo);
      urlWithParams.searchParams.append("enablejsapi", 1);
      urlWithParams.searchParams.append("showinfo", 0);
      urlWithParams.searchParams.append("autoplay", 1);
      const el = document.createElement("div");
      el.classList.add(
        "hystmodal",
        "hystmodal--video",
        button.dataset.videoModalId
      );
      el.innerHTML = `
        <div class="hystmodal__wrap">
          <div class="hystmodal__window" role="dialog" aria-modal="true">
            <button data-hystclose class="hystmodal__close"></button>
            <div class="modal__video">
              <iframe src="${urlWithParams.href}" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen frameborder="0"></iframe>
            </div>
          </div>
        </div>
      `;
      document.body.appendChild(el);
    }

    modal.open(`.${button.dataset.videoModalId}`);
  });
});
