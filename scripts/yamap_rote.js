window.addEventListener('load', function (e) {
    ymaps.ready(init);

    function init() {

        var startPlacemark, endPlacemark, multiRoute
        let coord_start = ['76.888395', '43.246200'];
        // Стоимость за километр.
        var DELIVERY_TARIFF = 100,
            // Минимальная стоимость.
            MINIMUM_COST = 200,
            myMap = new ymaps.Map('map', {
                center: coord_start,
                zoom: 9,
                controls: []
            }),
            zoomControl = new ymaps.control.ZoomControl({
                options: {
                    size: 'small',
                    float: 'none',
                    position: {
                        bottom: 145,
                        right: 10
                    }
                }
            });
        var suggestView = new ymaps.SuggestView('suggest');
        var searchControl = new ymaps.control.SearchControl({
            options: {
                // Будет производиться поиск только по топонимам.
                provider: 'yandex#map',
                noPlacemark: true
            }
        });
        myMap.controls.add(searchControl);


        startPlacemark = new ymaps.Placemark(coord_start, {
                balloonContent: 'Алматы, Розыбакиева, 11',
                //  iconContent: "Алматы, Розыбакиева, 11"
            }
            , {
                //    preset: "islands#blueStretchyIcon",
                // Отключаем кнопку закрытия балуна.
                // balloonCloseButton: false,
                // Балун будем открывать и закрывать кликом по иконке метки.
                hideIconOnBalloonOpen: false
            });

        // событие поиска searchControl
        searchControl.events.add('resultselect', function (e) {
            var results = searchControl.getResultsArray();
            var selected = searchControl.getSelectedIndex();
            coord_end = results[selected].geometry.getCoordinates();

            addRoute(coord_start, coord_end)
        })


        // Создание метки.
        function createPlacemark(coords) {
            return new ymaps.Placemark(coords, {
                iconCaption: 'поиск...'
            }, {
                preset: 'islands#violetDotIconWithCaption',
                draggable: false
            });
        }

        myMap.events.add('click', function (e) {
            //  получить координаты клика
            let coord_end = e.get('coords');

            //Добавить точку на карту
            //addEndPlacemark(coord_end)

            //вывести маршрут
            addRoute(coord_start, coord_end)

        });

        function addEndPlacemark(coord_end) {
            //   переместить метку на новые координаты

            //   Если метка уже создана – просто передвигаем ее.
            if (endPlacemark) {
                endPlacemark.geometry.setCoordinates(end_coords);
            }
            // Если нет – создаем.
            else {
                endPlacemark = createPlacemark(end_coords);
                myMap.geoObjects.add(endPlacemark);
                // Слушаем событие окончания перетаскивания на метке.
                // endPlacemark.events.add('dragend', function () {

                // });
            }
            coord_end = endPlacemark.geometry.getCoordinates()
            getAddress(coord_end);
            myMap.geoObjects.add(endPlacemark);
        }

        // Определяем адрес по координатам (обратное геокодирование).
        function getAddress(coords) {
            endPlacemark.properties.set('iconCaption', 'поиск...');
            ymaps.geocode(coords).then(function (res) {
                var firstGeoObject = res.geoObjects.get(0);

                endPlacemark.properties
                    .set({
                        // Формируем строку с данными об объекте.
                        iconCaption: [
                            // Название населенного пункта или вышестоящее административно-территориальное образование.
                            firstGeoObject.getLocalities().length ? firstGeoObject.getLocalities() : firstGeoObject.getAdministrativeAreas(),
                            // Получаем путь до топонима, если метод вернул null, запрашиваем наименование здания.
                            firstGeoObject.getThoroughfare() || firstGeoObject.getPremise()
                        ].filter(Boolean).join(', '),
                        // В качестве контента балуна задаем строку с адресом объекта.
                        balloonContent: firstGeoObject.getAddressLine()
                    });
            });
        }

        function addRoute(coord_start, coord_end) {

            if (multiRoute) {

                multiRoute.model.setReferencePoints([coord_start, coord_end]);
            } else {
                multiRoute = new ymaps.multiRouter.MultiRoute({

                    // Описание опорных точек мультимаршрута.
                    referencePoints: [
                        coord_start,
                        coord_end
                    ],
                    // Параметры маршрутизации.
                    params: {
                        // Ограничение на максимальное количество маршрутов, возвращаемое маршрутизатором.
                        results: 1
                    }
                }, {
                    // Автоматически устанавливать границы карты так, чтобы маршрут был виден целиком.
                    boundsAutoApply: true
                });
                myMap.geoObjects.add(multiRoute);
            }

            //расчет и вывод значений
            multiRoute.model.events.add('requestsuccess', function () {
                let distance = multiRoute.getActiveRoute().properties.get("distance")
                let distance_km = Math.round(distance.value / 1000)
                let price = calculate(distance_km)

                addResult(distance_km, price)

                console.log(distance_km)
                console.log(price)
            });

        }

        myMap.controls.add(zoomControl);
        myMap.controls.add(searchControl);
        myMap.geoObjects.add(startPlacemark);


        // Функция, вычисляющая стоимость доставки.
        function calculate(routeLength) {
            return Math.max(routeLength * DELIVERY_TARIFF, MINIMUM_COST);
        }

        function addResult(distance, price) {
            let el_distance = document.querySelector('#km')
            let el_summ = document.querySelector('#summ')
            el_distance.innerHTML = distance
            el_summ.innerHTML = price
        }

        document.getElementById('suggest').addEventListener('change', function (e) {
            let adress = e.target.value
            geocode(adress)
            //  console.log(val)
        })

        function geocode(adress) {
            console.log('geocode')
            // Забираем запрос из поля ввода.
            var request = adress //$('#suggest').val();
            // Геокодируем введённые данные.
            ymaps.geocode(request).then(function (res) {
                var obj = res.geoObjects.get(0),
                    error, hint;

                if (obj) {
                    // Об оценке точности ответа геокодера можно прочитать тут: https://tech.yandex.ru/maps/doc/geocoder/desc/reference/precision-docpage/
                    switch (obj.properties.get('metaDataProperty.GeocoderMetaData.precision')) {
                        case 'exact':
                            break;
                        case 'number':
                        case 'near':
                        case 'range':
                            error = 'Неточный адрес, требуется уточнение';
                            hint = 'Уточните номер дома';
                            break;
                        case 'street':
                            error = 'Неполный адрес, требуется уточнение';
                            hint = 'Уточните номер дома';
                            break;
                        case 'other':
                        default:
                            error = 'Неточный адрес, требуется уточнение';
                            hint = 'Уточните адрес';
                    }
                } else {
                    error = 'Адрес не найден';
                    hint = 'Уточните адрес';
                }

                // Если геокодер возвращает пустой массив или неточный результат, то показываем ошибку.
                if (error) {
                    showError(error);
                    //   showMessage(hint);
                } else {
                    console.log('Результат поиска')

                    coord_end = obj.geometry.getCoordinates()

                    addRoute(coord_start, coord_end)
                    // console.log()
                    //   showResult(obj);
                }
            }, function (e) {
                console.log(e)
            })

        }

        function showError(message) {
            alert(message)
        }

    }

})