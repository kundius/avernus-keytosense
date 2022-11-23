import dayjs from "dayjs";
import isBetween from "dayjs/plugin/isBetween";
import AirDatepicker from "air-datepicker";
import localeRu from "air-datepicker/locale/ru";
import Scrollbar from "smooth-scrollbar";
import OverscrollPlugin from "smooth-scrollbar/dist/plugins/overscroll";

Scrollbar.use(OverscrollPlugin);

dayjs.extend(isBetween);

const monthLabels = {
  0: "Января",
  1: "Февраля",
  2: "Мая",
  3: "Апреля",
  4: "Мая",
  5: "Июня",
  6: "Июля",
  7: "Августа",
  8: "Сентября",
  9: "Октября",
  10: "Ноября",
  11: "Декабря",
};

const title = {
  past: "Прошедшие события",
  future: "Запланированные события",
};

function renderEvent(event) {
  const renderName = () => {
    if (event.link) {
      return `<a href="${event.link}" class="events-item__name" target="_blank">${event.name}</a>`;
    }
    if (event.html) {
      return `<button class="events-item__name" data-hystmodal="#event-${event.id}">${event.name}</button>`;
    }
    return `<div class="events-item__name">${event.name}</div>`;
  };

  const renderModal = () => {
    if (!event.html) {
      return "";
    }
    return `
  <div class="hystmodal" id="event-${event.id}">
    <div class="hystmodal__wrap">
      <div class="hystmodal__window" role="dialog" aria-modal="true">
        <button data-hystclose class="hystmodal__close"></button>
        ${event.html}
      </div>
    </div>
  </div>
  `;
  };

  const date = dayjs(event.date);
  const clsMod = date.startOf('day') < dayjs().startOf('day') ? "past" : "future";
  return `
<div class="events-item events-item_${clsMod}">
  <div class="events-item__date">
    <div class="events-item__date-day">${date.date()}</div>
    <div class="events-item__date-month">${monthLabels[date.month()]}</div>
  </div>
  <div class="events-item__body">
    ${renderName()}
    ${renderModal()}
    <div class="events-item__desc">
      ${event.description}
    </div>
  </div>
  <div class="events-item__arrow" target="_blank"></div>
</div>
`;
}

async function initCalendar() {
  const sectionEl = document.getElementById("events");
  const calendarEl = document.getElementById("calendar");
  const buttonMonth = document.getElementById("calendar-button-month");
  const buttonWeek = document.getElementById("calendar-button-week");
  const eventsTitle = document.getElementById("calendar-events-title");
  const eventsScroll = document.getElementById("calendar-events-scroll");
  const eventsList = document.getElementById("calendar-events-list");

  let silentCalendar = false;
  let currentMonth = new Date().getMonth();
  let currentYear = new Date().getFullYear();

  class Queue {
    constructor() {
      this._items = [];
    }
    enqueue(item) {
      this._items.push(item);
    }
    dequeue() {
      return this._items.shift();
    }
    get size() {
      return this._items.length;
    }
  }

  class AutoQueue extends Queue {
    constructor() {
      super();
      this._pendingPromise = false;
    }

    enqueue(action) {
      return new Promise((resolve, reject) => {
        super.enqueue({ action, resolve, reject });
        this.dequeue();
      });
    }

    async dequeue() {
      if (this._pendingPromise) return false;

      let item = super.dequeue();

      if (!item) return false;

      try {
        this._pendingPromise = true;

        let payload = await item.action(this);

        this._pendingPromise = false;
        item.resolve(payload);
      } catch (e) {
        this._pendingPromise = false;
        item.reject(e);
      } finally {
        this.dequeue();
      }

      return true;
    }
  }

  const aQueue = new AutoQueue();

  const eventsScrollbar = Scrollbar.init(eventsScroll, {
    alwaysShowTracks: true,
    plugins: {
      overscroll: {},
    },
  });

  const eventsCalendar = new AirDatepicker(calendarEl, {
    inline: true,
    locale: localeRu,
    nextHtml: "",
    prevHtml: "",
    navTitles: {
      days: "<div>MMMM</div><span>yyyy</span>",
    },
    onChangeView(view) {
      if (view === "months" || view === "years") {
        eventsCalendar.setCurrentView("days");
        eventsCalendar.clear({ silent: true });

        if (!silentCalendar) {
          selectMonth(currentMonth, currentYear);
        }
      }
    },
    onSelect({ date, ...dd }) {
      if (!silentCalendar) {
        if (typeof date !== "undefined") {
          selectDate(date);
        } else {
          selectNear();
        }
      }
    },
    onChangeViewDate({ month, year }) {
      eventsCalendar.clear({ silent: true });

      currentMonth = month;
      currentYear = year;

      if (!silentCalendar) {
        selectMonth(month, year);
      }
    },
  });
  
  function selectDate(date) {
    if (dayjs(date).startOf("day") < dayjs().startOf("day")) {
      eventsTitle.innerText = title.past
    } else {
      eventsTitle.innerText = title.future
    }
    aQueue.enqueue(() =>
      showEventsByDate(dayjs(date).format("YYYY-MM-DD"))
    );
  }

  function selectMonth(month, year) {
    if (
      dayjs().set("month", month).set("year", year).startOf("month") <
      dayjs().startOf("month")
    ) {
      eventsTitle.innerText = title.past;
    } else {
      eventsTitle.innerText = title.future;
    }

    aQueue.enqueue(async () => {
      await showEventsByRange(
        dayjs()
          .set("month", month)
          .set("year", year)
          .startOf("month")
          .format("YYYY-MM-DD"),
        dayjs()
          .set("month", month)
          .set("year", year)
          .endOf("month")
          .format("YYYY-MM-DD")
      );
      const firstFutureEvent = eventsList.querySelector(
        ".events-item_future"
      );
      const offsetTop =
        firstFutureEvent?.previousElementSibling?.previousElementSibling
          ?.offsetTop || 0;
      eventsScrollbar.update();
      eventsScrollbar.scrollTo(0, offsetTop);
    });
  }

  function selectWeek() {
    eventsTitle.innerText = title.future;

    aQueue.enqueue(() => {
      showEventsByRange(
        dayjs().format("YYYY-MM-DD"),
        dayjs().add(7, "day").format("YYYY-MM-DD")
      );
      eventsScrollbar.update();
      eventsScrollbar.scrollTo(0, 0);
    });
  }

  function selectNear() {
    eventsTitle.innerText = title.future;

    aQueue.enqueue(() =>
      showEventsByNear(
        dayjs().format("YYYY-MM-DD"),
        10
      )
    );
  }

  function showEvents(events) {
    sectionEl.classList.remove("-empty-list-");
    if (events.length === 0) {
      sectionEl.classList.add("-empty-list-");
    }

    let html = "";

    events.forEach((event) => {
      html += renderEvent(event);
    });

    eventsList.innerHTML = html;
  }

  async function showEventsByNear(date, count) {
    sectionEl.classList.add("-loading-list-");
    const response = await fetch(
      `${calendarActionUrl}?action=events-by-near&date=${date}&count=${count}`
    );
    const json = await response.json();
    sectionEl.classList.remove("-loading-list-");

    if (json.success) {
      showEvents(json.data);
    }
  }

  async function showEventsByDate(date) {
    sectionEl.classList.add("-loading-list-");
    const response = await fetch(
      `${calendarActionUrl}?action=events-by-date&date=${date}`
    );
    const json = await response.json();
    sectionEl.classList.remove("-loading-list-");

    if (json.success) {
      showEvents(json.data);
    }
  }

  async function showEventsByRange(from, to) {
    sectionEl.classList.add("-loading-list-");
    const response = await fetch(
      `${calendarActionUrl}?action=events-by-date-range&from=${from}&to=${to}`
    );
    const json = await response.json();
    sectionEl.classList.remove("-loading-list-");

    if (json.success) {
      showEvents(json.data);
    }
  }

  async function loadCalendarEvents() {
    const response = await fetch(`${calendarActionUrl}?action=dates-with-events`);
    const json = await response.json();

    if (json.success) {
      eventsCalendar.update({
        onRenderCell({ date, cellType }) {
          if (cellType === "day") {
            const hasEvent = json.data.includes(
              dayjs(date).format("YYYY-MM-DD")
            );
            const isPast = date < new Date();
            return {
              classes: hasEvent ? (isPast ? "-past-" : "-upcoming-") : "",
            };
          }
        },
      });
    }
  }

  buttonMonth.addEventListener("click", async () => {
    await eventsCalendar.clear({ silent: true });

    silentCalendar = true;
    await eventsCalendar.setViewDate(new Date());
    silentCalendar = false;

    selectMonth(new Date().getMonth(), new Date().getFullYear());
  });

  buttonWeek.addEventListener("click", async () => {
    await eventsCalendar.clear({ silent: true });

    silentCalendar = true;
    await eventsCalendar.setViewDate(new Date());
    silentCalendar = false;

    selectWeek();
  });

  await loadCalendarEvents();

  selectNear();
}

initCalendar();
