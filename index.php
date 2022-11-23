<?php

function get_lessons() {
  $events = [];
  if (($handle = fopen(__DIR__ . "/lessons.txt", "r")) !== FALSE) {
    $index = -2;
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
      $index++;
      if ($index === -1) continue;
      $events[] = [
        'id' => $index,
        'name' => $data[0],
        'description' => $data[1],
        'image' => $data[2],
        'video' => $data[3],
      ];
    }
    fclose($handle);
  }
  return $events;
}

function get_announcements() {
  $events = [];
  if (($handle = fopen(__DIR__ . "/announcements.txt", "r")) !== FALSE) {
    $index = -2;
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
      $index++;
      if ($index === -1) continue;
      $events[] = [
        'id' => $index,
        'name' => $data[0],
        'description' => $data[1],
        'image' => $data[2],
        'link' => $data[3],
      ];
    }
    fclose($handle);
  }
  return $events;
}

?>
<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Александр Петров</title>
    <link href="dist/styles/bundle.css" rel="stylesheet" />

    <script>
      var calendarActionUrl = "calendar.php";
    </script>
    <meta property="og:title" content="Александр Петров эксперт в области оперативной психологии. Подполковник запаса" />
    <meta property="og:description" content="Обучение искусству разбираться в людях. Выстраивание долговременных эффективных взаимоотношений. Развитие навыков незаметного влияния на людей." />
    <meta property="og:image" content="static/expert.jpg" />
  </head>

  <body>
    <div class="page">
      <header class="header">
        <div class="ui-container">
          <div class="header__inner">
            <div class="header__logo">
              <img src="dist/images/logo.png" alt="" />
            </div>
            <ul class="header__menu">
              <li><a href="#about" data-scroll="#about">об эксперте</a></li>
              <li>
                <a href="#method" data-scroll="#method">о методике</a>
              </li>
              <li>
                <a href="#program" data-scroll="#program">обучающие программы</a>
              </li>
              <li>
                <a href="#individual" data-scroll="#individual">ИНДИВИДУАЛЬНОЕ ОБУЧЕНИЕ</a>
              </li>
              <li>
                <a href="#contacts" data-scroll="#contacts">контакты</a>
              </li>
            </ul>
            <button class="header__toggle">
              <span></span>
              <span></span>
              <span></span>
            </button>
          </div>
        </div>
      </header>

      <section class="section-about" id="about">
        <div class="section-about__container ui-container">
          <div class="section-about__suptitle">
            АЛЕКСАНДР ПЕТРОВ
          </div>
          <div class="section-about__title">
            Эксперт в области 
            оперативной психологии. 
            Подполковник запаса
          </div>
          <ul class="section-about__list">
            <li>Обучение искусству <strong>разбираться в людях</strong>.</li>

            <li>Выстраивание долговременных <strong>эффективных взаимоотношений</strong>.</li>

            <li>Развитие навыков незаметного <strong>влияния на людей</strong>.</li>
          </ul>
          <div class="section-about__button">
            <a href="https://master.avernus.ru/expert#details" class="ui-button-primary">
              Подробнее об эксперте
            </a>
          </div>
        </div>
      </section>

      <section class="section-method" id="method">
        <div class="ui-container section-method__container">
          <div class="section-method__title">
            <span>МЕТОДИКА</span> «КЛЮЧИ ДОСТУПА К ЛЮДЯМ»
          </div>
          <div class="section-method__video" data-modal-video="https://www.youtube-nocookie.com/embed/zg8vQ2xio5Q?rel=0">
            <img src="dist/images/method-video-preview.png" alt="" />
          </div>
          <div class="section-method__text">
            <p>
              <span>Ключи доступа</span> – это методика поиска 
              подхода к нужным вам людям на основе 
              анализа их индивидуальных психологических 
              уязвимостей: потребностей и мотивов, 
              страхов, сомнений, внутренних конфликтов, 
              ценностей, убеждений и личных стратегий 
              принятия&nbsp;решений.
            </p>
            <p>
              Обучаясь на курсах <span>Александра Петрова</span>, 
              вы научитесь хорошо разбираться в людях, 
              понимать их сильные и слабые стороны, 
              а также прогнозировать их поведение. 
              Для каждого человека вы сможете подбирать 
              те методы воздействия, которые будут 
              действовать на него максимально эффективно. И чем дольше вы будете общаться с людьми, 
              тем&nbsp;сильнее будет ваше влияние&nbsp;на&nbsp;них.
            </p>
          </div>
        </div>
      </section>

      <section class="section-program" id="program">
        <div class="ui-container section-program__container">
          <div class="section-program__title">
            ОБУЧАЮЩИЕ ПРОГРАММЫ
          </div>

          <div class="lessons">
            <div class="lessons__title">Записи открытых уроков</div>
            <div class="lessons__list">
              <div class="swiper lessons-swiper">
                <div class="swiper-wrapper">
                  <?php foreach(array_chunk(get_lessons(), 2) as $chunk): ?>
                  <div class="swiper-slide">
                    <?php foreach ($chunk as $item): ?>
                    <div class="lessons-item" data-modal-video="<?php echo $item['video'] ?>">
                      <div class="lessons-item__image">
                        <img src="<?php echo $item['image'] ?>" alt="" />
                      </div>
                      <div class="lessons-item__name"><?php echo $item['name'] ?></div>
                      <div class="lessons-item__desc"><?php echo $item['description'] ?></div>
                    </div>
                    <?php endforeach ?>
                  </div>
                  <?php endforeach ?>
                </div>
              </div>

              <div class="swiper-button-prev lessons-swiper-button-prev"></div>
              <div class="swiper-button-next lessons-swiper-button-next"></div>
            </div>
          </div>

          <div class="events" id="events">
            <div class="events__title">Ближайшие мероприятия</div>
            <div class="events-layout">
              <div class="events-layout__calendar">
                <div id="calendar"></div>
              </div>
              <div class="events-layout__events">
                <div class="calendar-events">
                  <div class="calendar-events__title" id="calendar-events-title">Запланированные события</div>
                  <div class="calendar-events__scroll" id="calendar-events-scroll">
                    <div class="calendar-events__list" id="calendar-events-list"></div>
                  </div>
                  <div class="calendar-events__loader">
                    <div class="ui-loader"></div>
                  </div>
                  <div class="calendar-events__empty">
                    Нет мероприятий
                  </div>
                </div>
              </div>
              <div class="events-layout__buttons">
                <div class="calendar-buttons">
                  <div class="calendar-buttons__button">
                    <button class="ui-secondary-button" id="calendar-button-month">Весь месяц</button>
                  </div>
                  <div class="calendar-buttons__button">
                    <button class="ui-secondary-button" id="calendar-button-week">Ближайшая неделя</button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="announcements">
            <div class="announcements__title">Ожидаемые мероприятия</div>
            <div class="announcements__list">
              <div class="swiper announcements-swiper">
                <div class="swiper-wrapper">
                  <?php foreach (get_announcements() as $item): ?>
                  <div class="swiper-slide">
                    <div class="announcements-item">
                      <div class="announcements-item__image">
                        <img src="<?php echo $item['image'] ?>" alt="" />
                      </div>
                      <div class="announcements-item__name">
                        <?php if (!empty($item['link'])): ?><a href="<?php echo $item['link'] ?>" target="_blank"><?php endif ?>
                        <?php echo $item['name'] ?>
                        <?php if (!empty($item['link'])): ?></a><?php endif ?>
                      </div>
                      <div class="announcements-item__desc"><?php echo $item['description'] ?></div>
                    </div>
                  </div>
                  <?php endforeach ?>
                </div>
              </div>

              <div class="swiper-button-prev announcements-swiper-button-prev"></div>
              <div class="swiper-button-next announcements-swiper-button-next"></div>
            </div>
          </div>
        </div>
      </section>

      <div class="background-keyboard">
        <section class="section-individual" id="individual">
          <div class="ui-container">
            <div class="section-individual__title">ИНДИВИДУАЛЬНОЕ ОБУЧЕНИЕ</div>
            <div class="section-individual__layout">
              <div class="section-individual__layout-text">
                <div class="section-individual__subtitle"><span>Индивидуальные занятия –</span></div>
                <div class="section-individual__text">
                  это ваша личная<br />
                  программа обучения.<br />
                  Она подбирается<br />
                  из ваших личных запросов<br />
                  и целей и строится<br />
                  по мере вашего<br />
                  «взросления».
                </div>
              </div>
              <div class="section-individual__layout-graphics">
                <div class="section-individual-graphics">
                  <div class="section-individual-graphics__image-1"></div>
                  <div class="section-individual-graphics__image-2"></div>
                  <div class="section-individual-graphics__image-3"></div>
                  <div class="section-individual-graphics__image-4"></div>
                  <div class="section-individual-graphics__image-5"></div>
                  <div class="section-individual-graphics__text-1">
                    Хочу научиться понимать, с кем выстраивать отношения
                  </div>
                  <div class="section-individual-graphics__text-2">
                    В приоритете карьерный рост
                  </div>
                  <div class="section-individual-graphics__text-3">
                    Хочу уметь постоять за себя
                  </div>
                </div>
              </div>
              <div class="section-individual__layout-button">
                <a href="https://master.avernus.ru/profiler" class="ui-button-primary" target="_blank">
                  Подробнее
                </a>
              </div>
            </div>
          </div>
        </section>

        <section class="section-contacts" id="contacts">
          <div class="ui-container">
            <div class="section-contacts__title">
              ВЫ МОЖЕТЕ ЗАДАТЬ СВОЙ ВОПРОС
              <span>АЛЕКСАНДРУ ПЕТРОВУ</span>
            </div>
            <div class="section-contacts__buttons">
              <div class="section-contacts__grid">
                <div class="section-contacts__cell">
                  <a href="https://t.me/suggestor" class="section-contacts__button section-contacts__button_telegram" target="_blank">
                    <svg fill="#000000" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 50 50" width="50px" height="50px"><path d="M46.137,6.552c-0.75-0.636-1.928-0.727-3.146-0.238l-0.002,0C41.708,6.828,6.728,21.832,5.304,22.445	c-0.259,0.09-2.521,0.934-2.288,2.814c0.208,1.695,2.026,2.397,2.248,2.478l8.893,3.045c0.59,1.964,2.765,9.21,3.246,10.758	c0.3,0.965,0.789,2.233,1.646,2.494c0.752,0.29,1.5,0.025,1.984-0.355l5.437-5.043l8.777,6.845l0.209,0.125	c0.596,0.264,1.167,0.396,1.712,0.396c0.421,0,0.825-0.079,1.211-0.237c1.315-0.54,1.841-1.793,1.896-1.935l6.556-34.077	C47.231,7.933,46.675,7.007,46.137,6.552z M22,32l-3,8l-3-10l23-17L22,32z"/></svg>
                    Telegram
                  </a>
                </div>
                <div class="section-contacts__cell">
                  <button class="section-contacts__button section-contacts__button_whatsapp" data-whatsapp="whatsapp://send?text=Добрый+день%21&phone=+79617816076">
                    <svg fill="#000000" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 50 50" width="50px" height="50px">    <path d="M25,2C12.318,2,2,12.318,2,25c0,3.96,1.023,7.854,2.963,11.29L2.037,46.73c-0.096,0.343-0.003,0.711,0.245,0.966 C2.473,47.893,2.733,48,3,48c0.08,0,0.161-0.01,0.24-0.029l10.896-2.699C17.463,47.058,21.21,48,25,48c12.682,0,23-10.318,23-23 S37.682,2,25,2z M36.57,33.116c-0.492,1.362-2.852,2.605-3.986,2.772c-1.018,0.149-2.306,0.213-3.72-0.231 c-0.857-0.27-1.957-0.628-3.366-1.229c-5.923-2.526-9.791-8.415-10.087-8.804C15.116,25.235,13,22.463,13,19.594 s1.525-4.28,2.067-4.864c0.542-0.584,1.181-0.73,1.575-0.73s0.787,0.005,1.132,0.021c0.363,0.018,0.85-0.137,1.329,1.001 c0.492,1.168,1.673,4.037,1.819,4.33c0.148,0.292,0.246,0.633,0.05,1.022c-0.196,0.389-0.294,0.632-0.59,0.973 s-0.62,0.76-0.886,1.022c-0.296,0.291-0.603,0.606-0.259,1.19c0.344,0.584,1.529,2.493,3.285,4.039 c2.255,1.986,4.158,2.602,4.748,2.894c0.59,0.292,0.935,0.243,1.279-0.146c0.344-0.39,1.476-1.703,1.869-2.286 s0.787-0.487,1.329-0.292c0.542,0.194,3.445,1.604,4.035,1.896c0.59,0.292,0.984,0.438,1.132,0.681 C37.062,30.587,37.062,31.755,36.57,33.116z"/></svg>
                    WhatsApp
                  </button>
                  <div class="hystmodal" id="whatsapp-modal">
                    <div class="hystmodal__wrap">
                      <div class="hystmodal__window" role="dialog" aria-modal="true">
                        <button data-hystclose class="hystmodal__close"></button>
                        <div class="whatsapp-modal">
                          <div class="whatsapp-modal__title">Мы на связи в WhatsApp</div>
                          <div class="whatsapp-modal__button">
                            <a class="ui-button-primary" href="https://api.whatsapp.com/send/?phone=79617816076&text=%D0%94%D0%BE%D0%B1%D1%80%D1%8B%D0%B9+%D0%B4%D0%B5%D0%BD%D1%8C%21&type=phone_number&app_absent=0" target="_blank">Написать</a>
                          </div>
                          <div class="whatsapp-modal__label">
                            <div class="whatsapp-modal__label-inner">
                              или <span>с телефона</span>
                              <svg class="whatsapp-modal__label-arrow" width="20" height="68" viewBox="0 0 20 68" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.80472 1.10981C2.31308 0.665381 1.55425 0.703647 1.10981 1.19528C0.665381 1.68692 0.703647 2.44575 1.19528 2.89019L2.80472 1.10981ZM0.803237 65.9119C0.754593 66.5729 1.25097 67.1481 1.91192 67.1968L12.6828 67.9895C13.3437 68.0381 13.919 67.5417 13.9676 66.8808C14.0163 66.2198 13.5199 65.6446 12.8589 65.5959L3.28484 64.8913L3.98946 55.3172C4.0381 54.6563 3.54173 54.081 2.88077 54.0324C2.21982 53.9837 1.64458 54.4801 1.59593 55.1411L0.803237 65.9119ZM1.19528 2.89019C7.09926 8.22731 14.1621 17.7551 16.214 28.9329C18.2466 40.0051 15.3974 52.8544 1.21604 65.0915L2.78396 66.9085C17.5801 54.1409 20.7679 40.4476 18.5746 28.4996C16.4007 16.6573 8.97472 6.68742 2.80472 1.10981L1.19528 2.89019Z" fill="currentColor"></path>
                              </svg>
                            </div>
                          </div>
                          <div class="whatsapp-modal__qr">
                            <img src="dist/images/whatsapp-qr-code.svg" alt="">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="section-contacts__cell">
                  <a href="https://vk.com/keytosense" class="section-contacts__button section-contacts__button_vk" target="_blank">
                    <svg fill="#000000" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 48 48" width="48px" height="48px"><path d="M45.763,35.202c-1.797-3.234-6.426-7.12-8.337-8.811c-0.523-0.463-0.579-1.264-0.103-1.776 c3.647-3.919,6.564-8.422,7.568-11.143C45.334,12.27,44.417,11,43.125,11l-3.753,0c-1.237,0-1.961,0.444-2.306,1.151 c-3.031,6.211-5.631,8.899-7.451,10.47c-1.019,0.88-2.608,0.151-2.608-1.188c0-2.58,0-5.915,0-8.28 c0-1.147-0.938-2.075-2.095-2.075L18.056,11c-0.863,0-1.356,0.977-0.838,1.662l1.132,1.625c0.426,0.563,0.656,1.248,0.656,1.951 L19,23.556c0,1.273-1.543,1.895-2.459,1.003c-3.099-3.018-5.788-9.181-6.756-12.128C9.505,11.578,8.706,11.002,7.8,11l-3.697-0.009 c-1.387,0-2.401,1.315-2.024,2.639c3.378,11.857,10.309,23.137,22.661,24.36c1.217,0.12,2.267-0.86,2.267-2.073l0-3.846 c0-1.103,0.865-2.051,1.977-2.079c0.039-0.001,0.078-0.001,0.117-0.001c3.267,0,6.926,4.755,8.206,6.979 c0.368,0.64,1.056,1.03,1.8,1.03l4.973,0C45.531,38,46.462,36.461,45.763,35.202z"/></svg>
                    ВКонтакте
                  </a>
                </div>
                <div class="section-contacts__cell">
                  <a href="https://www.instagram.com/keytosense" class="section-contacts__button section-contacts__button_instagram" target="_blank">
                    <svg fill="#000000" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 24 24" width="48px" height="48px">    <path d="M 8 3 C 5.243 3 3 5.243 3 8 L 3 16 C 3 18.757 5.243 21 8 21 L 16 21 C 18.757 21 21 18.757 21 16 L 21 8 C 21 5.243 18.757 3 16 3 L 8 3 z M 8 5 L 16 5 C 17.654 5 19 6.346 19 8 L 19 16 C 19 17.654 17.654 19 16 19 L 8 19 C 6.346 19 5 17.654 5 16 L 5 8 C 5 6.346 6.346 5 8 5 z M 17 6 A 1 1 0 0 0 16 7 A 1 1 0 0 0 17 8 A 1 1 0 0 0 18 7 A 1 1 0 0 0 17 6 z M 12 7 C 9.243 7 7 9.243 7 12 C 7 14.757 9.243 17 12 17 C 14.757 17 17 14.757 17 12 C 17 9.243 14.757 7 12 7 z M 12 9 C 13.654 9 15 10.346 15 12 C 15 13.654 13.654 15 12 15 C 10.346 15 9 13.654 9 12 C 9 10.346 10.346 9 12 9 z"/></svg>
                    Инстаграм
                  </a>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>

      <!-- <section class="section-faq" id="faq">
        <div class="ui-container">
          <div class="section-faq__title">
            <span>Остались вопросы?</span>
          </div>
          <div class="section-faq__body">
            <div class="accordion" data-accordion>
  
              <div class="accordion-row" data-accordion-row>
                <div class="accordion-row__header" data-accordion-header>Смогу ли я освоить этот курс? Я в этом ничего не понимаю.</div>
                <div class="accordion-row__content" data-accordion-content>
                  <p>Базовый курс манипуляций рассчитан на начинающих. Поэтому проблем при изучении курса у вас не возникнет.</p>
                </div>
              </div>
  
              <div class="accordion-row" data-accordion-row>
                <div class="accordion-row__header" data-accordion-header>Получу ли я сертификат после прохождения курса?</div>
                <div class="accordion-row__content" data-accordion-content>
      <p>Да, если вы присутствовали на занятиях и выполняли домашние задания, то по окончании курса вы получите соответствующий сертификат в электронном виде.</p>
                </div>
              </div>
              
            </div>
          </div>
          <div class="section-faq__button">
            <button
              class="ui-button-primary ui-button-primary_dark"
              data-hystmodal="#question"
            >
              Задать вопрос
            </button>
          </div>
        </div>
      </section> -->

      <footer class="footer">
        <div class="ui-container">
          <div class="footer-grid">
            <div class="footer-first-cell">
              <div class="footer__first">
                <a href="/" class="footer__logo"
                  ><img src="dist/images/logo.png" alt=""
                /></a>
                <div class="footer__sitename">Тренинговый Центр</div>
                <div class="footer__behalf">"Авернус"</div>

                <div class="footer__copyright">
                  Все права защищены. Копирование материалов сайта возможно при
                  указании активной ссылки на источник.
                </div>
              </div>

              <a
                href="http://domenart-studio.ru/"
                target="_blank"
                class="footer__creator"
              >
                Разработка сайта<br />
                веб-студия “ДоменАрт”
              </a>
            </div>

            <div class="footer-second-cell">
              <ul class="footer__menu">
                <li><a href="http://master.avernus.ru">О центре</a></li>
                <li>
                  <a href="http://avernus.ru/zakritie-stati/blog"
                    >Расширенные курсы</a
                  >
                </li>
                <li>
                  <a href="http://master.avernus.ru/policy"
                    >Политика конфиденциальности</a
                  >
                </li>
              </ul>
            </div>

            <div class="footer-third-cell">
              <div class="footer__contacts">
                Мы в социальных сетях
                <div class="footer-socials">
                  <a href="https://vk.com/suggestor" target="_blank">
                    <svg
                      enable-background="new 0 0 24 24"
                      height="18"
                      viewBox="0 0 24 24"
                      width="18"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="m19.915 13.028c-.388-.49-.277-.708 0-1.146.005-.005 3.208-4.431 3.538-5.932l.002-.001c.164-.547 0-.949-.793-.949h-2.624c-.668 0-.976.345-1.141.731 0 0-1.336 3.198-3.226 5.271-.61.599-.892.791-1.225.791-.164 0-.419-.192-.419-.739v-5.105c0-.656-.187-.949-.74-.949h-4.126c-.419 0-.668.306-.668.591 0 .622.945.765 1.043 2.515v3.797c0 .832-.151.985-.486.985-.892 0-3.057-3.211-4.34-6.886-.259-.713-.512-1.001-1.185-1.001h-2.625c-.749 0-.9.345-.9.731 0 .682.892 4.073 4.148 8.553 2.17 3.058 5.226 4.715 8.006 4.715 1.671 0 1.875-.368 1.875-1.001 0-2.922-.151-3.198.686-3.198.388 0 1.056.192 2.616 1.667 1.783 1.749 2.076 2.532 3.074 2.532div.624c.748 0 1.127-.368.909-1.094-.499-1.527-3.871-4.668-4.023-4.878z"
                      />
                    </svg>
                  </a>
                  <a href="https://ok.ru/suggestor" target="_blank">
                    <svg
                      enable-background="new 0 0 24 24"
                      height="18"
                      viewBox="0 0 24 24"
                      width="18"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="m4.721 12.881c-.613 1.205.083 1.781 1.671 2.765 1.35.834 3.215 1.139 4.413 1.261-.491.472 1.759-1.692-4.721 4.541-1.374 1.317.838 3.43 2.211 2.141l3.717-3.585c1.423 1.369 2.787 2.681 3.717 3.59 1.374 1.294 3.585-.801 2.226-2.141-.102-.097-5.037-4.831-4.736-4.541 1.213-.122 3.05-.445 4.384-1.261l-.001-.001c1.588-.989 2.284-1.564 1.68-2.769-.365-.684-1.349-1.256-2.659-.267 0 0-1.769 1.355-4.622 1.355-2.854 0-4.622-1.355-4.622-1.355-1.309-.994-2.297-.417-2.658.267z"
                      />
                      <path
                        d="m11.999 12.142c3.478 0 6.318-2.718 6.318-6.064 0-3.36-2.84-6.078-6.318-6.078-3.479 0-6.319 2.718-6.319 6.078 0 3.346 2.84 6.064 6.319 6.064zm0-9.063c1.709 0 3.103 1.341 3.103 2.999 0 1.644-1.394 2.985-3.103 2.985s-3.103-1.341-3.103-2.985c-.001-1.659 1.393-2.999 3.103-2.999z"
                      />
                    </svg>
                  </a>
                  <a
                    href="https://www.facebook.com/avernuslab/"
                    target="_blank"
                  >
                    <svg
                      enable-background="new 0 0 24 24"
                      height="18"
                      viewBox="0 0 24 24"
                      width="18"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="m15.997 3.985div.191v-3.816c-.378-.052-1.678-.169-3.192-.169-3.159 0-5.323 1.987-5.323 5.639v3.361h-3.486v4.266div.486v10.734h4.274v-10.733div.345l.531-4.266h-3.877v-2.939c.001-1.233.333-2.077 2.051-2.077z"
                      />
                    </svg>
                  </a>
                  <a href="https://twitter.com/darkon30" target="_blank">
                    <svg
                      height="18"
                      width="18"
                      version="1.1"
                      xmlns="http://www.w3.org/2000/svg"
                      xmlns:xlink="http://www.w3.org/1999/xlink"
                      x="0px"
                      y="0px"
                      viewBox="0 0 512 512"
                      style="enable-background: new 0 0 512 512"
                      xml:space="preserve"
                    >
                      <path
                        d="M512,97.248c-19.04,8.352-39.328,13.888-60.48,16.576c21.76-12.992,38.368-33.408,46.176-58.016 c-20.288,12.096-42.688,20.64-66.56,25.408C411.872,60.704,384.416,48,354.464,48c-58.112,0-104.896,47.168-104.896,104.992 c0,8.32,0.704,16.32,2.432,23.936c-87.264-4.256-164.48-46.08-216.352-109.792c-9.056,15.712-14.368,33.696-14.368,53.056 c0,36.352,18.72,68.576,46.624,87.232c-16.864-0.32-33.408-5.216-47.424-12.928c0,0.32,0,0.736,0,1.152 c0,51.008,36.384,93.376,84.096,103.136c-8.544,2.336-17.856,3.456-27.52,3.456c-6.72,0-13.504-0.384-19.872-1.792 c13.6,41.568,52.192,72.128,98.08,73.12c-35.712,27.936-81.056,44.768-130.144,44.768c-8.608,0-16.864-0.384-25.12-1.44 C46.496,446.88,101.6,464,161.024,464c193.152,0,298.752-160,298.752-298.688c0-4.64-0.16-9.12-0.384-13.568 C480.224,136.96,497.728,118.496,512,97.248z"
                      />
                    </svg>
                  </a>
                </div>
                <span>Контакты и поддержка</span>
                <a href="mailto:support@avernus.ru">support@avernus.ru</a>
              </div>

              <div class="footer__buttons">
                <a
                  href="mailto:support@avernus.ru"
                  data-hystmodal="#question"
                  >Задать вопрос</a
                >
                <a href="/login">Вход</a>
              </div>

              <div class="footer__counters"></div>
            </div>
          </div>
        </div>
      </footer>


      <div class="hystmodal hystmodal--small" id="question">
        <div class="hystmodal__wrap">
          <div class="hystmodal__window" role="dialog" aria-modal="true">
            <button data-hystclose class="hystmodal__close"></button>
            <div class="modal__title">
              Есть вопросы?<br />
              Напишите нам
            </div>
            <div class="modal__body">
              <form
                action="/email/question"
                method="post"
                class="modal-form"
                id="faq-form"
                data-from
              >
                <input type="hidden" name="action" value="faq-form" />
                <input type="hidden" name="subject" value='Вопрос с курса "Коррекция убеждений"' />
                <div data-from-messages></div>
                <div class="modal-form__row">
                  <input
                    type="email"
                    name="email"
                    placeholder="E-mail*"
                    class="ui-input"
                    required
                  />
                </div>
                <div class="modal-form__row">
                  <input
                    type="text"
                    name="name"
                    placeholder="Имя"
                    class="ui-input"
                  />
                </div>
                <div class="modal-form__row">
                  <textarea
                    name="message"
                    placeholder="Напишите Ваш вопрос"
                    class="ui-textarea"
                    rows="6"
                  ></textarea>
                </div>
                <div class="modal-form__row">
                  <input
                    type="text"
                    name="whatsapp"
                    placeholder="Ваш Whatsapp (по желанию)"
                    class="ui-input"
                  />
                </div>
                <div class="modal-form__row">
                  <label class="modal-form__approve">
                    <input
                      type="checkbox"
                      name="approve"
                      value="1"
                      checked
                      required
                    />
                    <span
                      >Прочитал(-а) и соглашаюсь с
                      <a href="/policy" target="_blank"
                        >политикой конфиденциальности</a
                      ></span
                    >
                  </label>
                </div>
                <div class="modal-form__row">
                  <button
                    class="modal-form__submit ui-button-primary ui-button-primary_dark"
                    type="submit"
                  >
                    Отправить
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <button class="ui-scrollup" data-scroll></button>

      <script src="dist/scripts/bundle.js"></script>
    </div>
  </body>
</html>
