<?php
  $required = isset($input['required']) ? 'required' : '';
  $value = isset($data) ? $data->$label : old($label);
?>

<div class="form-group">
  <label for="" class="col-sm-2 control-label">{{ trans('model.' . $label) }}</label>

  <div class="col-sm-10">
    <input type="text" class="form-control location-inputs" id="" placeholder="" name="{{ $label }}" value="{{ $value }}" {{ $required }}>
  </div>

  @if ($label == 'long')
      <div id="station_long_input">
          
      </div>
        <script src="https://api-maps.yandex.ru/2.0-stable/?load=package.standard&lang=ru-RU" type="text/javascript"></script>
      <script>
          $(function () {
            var map_container = $('<div id="map" style="width: 600px; height: 400px; position: relative; left: 20%; margin-top: 50px;"></div>'),
                map,
                marker,
                lat_input = $('input[name="lat"]'),
                long_input = $('input[name="long"]'),
                coords;

            $('#station_long_input').append(map_container);

            if (lat_input.val() && long_input.val()) {
              coords = [lat_input.val(), long_input.val()];
            } else {
              coords = [43.2551, 76.9126];
            }

            ymaps.ready(init);

            function init () {
                var myMap = new ymaps.Map("map", {
                        center: coords,
                        zoom: 10,
                        behaviors:['default', 'scrollZoom']
                    }, {
                        searchControlProvider: 'yandex#search'
                    }),

                myPlacemark = new ymaps.Placemark(coords, {hintContent: ''}, {draggable: true});

                myMap.controls
                        // Кнопка изменения масштаба.
                        .add('zoomControl', { left: 5, top: 5 })
                        // Список типов карты
                        .add('typeSelector')
                        // Стандартный набор кнопок
                        .add('mapTools', { left: 35, top: 5 });


                myMap.geoObjects.add(myPlacemark);

                myPlacemark.events.add('dragend', function (e) {

                    coords = myPlacemark.geometry.getCoordinates();
                    lat_input.val(coords[0]);
                    long_input.val(coords[1]);

                });

                myMap.events.add("click", function(e) {
                    coords = e.get('coordPosition')
                    myPlacemark.geometry.setCoordinates(coords);
                    lat_input.val(coords[0]);
                    long_input.val(coords[1]);
                })

                $('.location-inputs').on('keyup', function () {
                    coords = [lat_input.val(), long_input.val()];
                    myPlacemark.geometry.setCoordinates(coords);
                    myMap.setCenter(coords);
                });

            }


          });
      </script>

  @endif
</div>

