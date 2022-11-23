<?php

function get_events() {
  $events = [];
  if (($handle = fopen(__DIR__ . "/events.txt", "r")) !== FALSE) {
    $index = -2;
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
      $index++;
      if ($index === -1) continue;
      $events[] = [
        'id' => $index,
        'name' => $data[0],
        'description' => $data[1],
        'date' => $data[2],
        'link' => $data[3],
        'html' => $data[4],
      ];
    }
    fclose($handle);
  }
  return $events;
}

if (empty($_REQUEST['action'])) {
  exit(json_encode([
    'success' => false,
    'message' => 'Не указано действие'
  ]));
}

if ($_REQUEST['action'] === 'events-by-date') {
  if (empty($_REQUEST['date'])) {
    exit(json_encode([
      'success' => false,
      'message' => 'Не указана дата'
    ]));
  }

  $filtered = array_filter(get_events(), function($event) {
    return $event['date'] === $_REQUEST['date'];
  });

  usort($filtered, function($a, $b) {
    if (strtotime($a['date']) == strtotime($b['date'])) {
      return 0;
    }
    return strtotime($a['date']) < strtotime($b['date']) ? -1 : 1;
  });

  exit(json_encode([
    'success' => true,
    'data' => array_values($filtered)
  ]));
}

if ($_REQUEST['action'] === 'events-by-date-range') {
  if (empty($_REQUEST['from'])) {
    exit(json_encode([
      'success' => false,
      'message' => 'Не указана дата от'
    ]));
  }
  if (empty($_REQUEST['to'])) {
    exit(json_encode([
      'success' => false,
      'message' => 'Не указана дата до'
    ]));
  }

  $time_from = strtotime($_REQUEST['from']);
  $time_to = strtotime($_REQUEST['to']);

  $filtered = array_filter(get_events(), function($event) use($time_from, $time_to) {
    $time = strtotime($event['date']);
    return $time >= $time_from && $time < $time_to;
  });

  usort($filtered, function($a, $b) {
    if (strtotime($a['date']) == strtotime($b['date'])) {
      return 0;
    }
    return strtotime($a['date']) < strtotime($b['date']) ? -1 : 1;
  });

  exit(json_encode([
    'success' => true,
    'data' => array_values($filtered)
  ]));
}

if ($_REQUEST['action'] === 'events-by-near') {
  if (empty($_REQUEST['date'])) {
    exit(json_encode([
      'success' => false,
      'message' => 'Не указана дата от'
    ]));
  }
  if (empty($_REQUEST['count'])) {
    exit(json_encode([
      'success' => false,
      'message' => 'Не указано количество'
    ]));
  }

  $date_time = strtotime($_REQUEST['date']);

  $filtered = array_filter(get_events(), function($event) use($date_time) {
    $time = strtotime($event['date']);
    return $date_time <= $time;
  });

  usort($filtered, function($a, $b) {
    if (strtotime($a['date']) == strtotime($b['date'])) {
      return 0;
    }
    return strtotime($a['date']) < strtotime($b['date']) ? -1 : 1;
  });

  exit(json_encode([
    'success' => true,
    'data' => array_values(array_slice($filtered, 0, $_REQUEST['count']))
  ]));
}

if ($_REQUEST['action'] === 'dates-with-events') {
  $events = get_events();
  $dates = [];
  foreach ($events as $event) {
    $dates[$event['date']] = true;
  }
  exit(json_encode([
    'success' => true,
    'data' => array_keys($dates)
  ]));
}
