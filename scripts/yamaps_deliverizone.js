window.addEventListener('load', function (e) {

    document.querySelectorAll('.deliveryzone_price').forEach(function (el, indx) {
        el.addEventListener('change', async (e) => {
       //     console.log(el.closest('li').dataset.itemid)
            let data = {
                id: el.closest('li').dataset.itemid,
                price: el.value,
                //app: 'delivery',
                //method: 'updGEOJSON',
                task:'chng_deliveryzone_price'
            }
               // console.log(JSON.stringify(data))
            let url = '/controllers/ajax.php'
            let response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'data='+JSON.stringify(data)
            })

            let result = await response.json();
            console.log(result)

        })
    })


    ymaps.ready(init);

    async function init() {

        // Загружаем GeoJSON файл, экспортированный из Конструктора карт.
        let response = await fetch('/geojson/delivery.geojson');
        let geodata = await response.json(); // читаем ответ в формате JSON

        initZoneMap(geodata)
    }

    function initZoneMap(geodata) {
        var map = new ymaps.Map('delivery', {
            center: [37.62493141565861, 55.70869574653657],
            zoom: 7,
            controls: ['zoomControl']
        })

        map.controls.get('zoomControl').options.set({size: 'small'});

        var searchControl = new ymaps.control.SearchControl({
            options: {
                size: 'auto',
                searchControlProvider: 'yandex#map',
                noPlacemark: true
            }
        });
        map.controls.add(searchControl);

        searchControl.events.add('resultselect', function (e) {
            var results = searchControl.getResultsArray();
            var selected = searchControl.getSelectedIndex();
            var coords = results[selected].geometry.getCoordinates();

            let polygon = deliveryZones.searchContaining(coords).get(0);
            let zone_id = "Вне зоны доставки"
            let zone_color = "#fff"
            if (polygon) {
                zone_id = polygon.properties.balloonContent
                zone_color = polygon.properties.get('fill')
            }

            map.balloon.open(coords,
                {
                    contentHeader: results[selected].properties.get('balloonContent'),
                    contentBody: results[selected].properties.get('balloonContentBody'),
                    contentFooter: '<div>Входит в тариф доставки: <span style="background-color: ' + zone_color + '">' + zone_id + '</span></div>'
                })
        });

        var deliveryZones = ymaps.geoQuery(geodata).addToMap(map);
        // Задаём цвет и контент балунов полигонов.
        deliveryZones.each(function (obj) {
          //  console.log(obj)
            obj.properties.balloonContent = obj.properties.get('description')
            obj.options.set({
                fillColor: obj.properties.get('fill'),
                fillOpacity: obj.properties.get('fill-opacity'),
                strokeColor: obj.properties.get('stroke'),
                strokeWidth: obj.properties.get('stroke-width'),
                strokeOpacity: obj.properties.get('stroke-opacity')
            });
        });

        deliveryZones.addEvents('click', function (e) {
            var coords = e.get('coords');

            let poligon = e.get('target')
            let poligon_porp = poligon.properties

            map.balloon.open(coords,
                {
                    //     contentHeader: 'Вы выбрали адрес',
                    contentBody: poligon_porp.balloonContent,
                    //     contentFooter: ballonResponse,
                }
            );
        })

    }
})