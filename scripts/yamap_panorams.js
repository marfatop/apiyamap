window.addEventListener('load', function (e){
    ymaps.ready(init);

    function init() {
        //,59.857030, 30.166783
        //59.856699, 30.166794
        let coord_start=['30.166794', '59.856699']
        myMap = new ymaps.Map('map', {
            center: coord_start,
            zoom: 9,
            controls: []
        })
        startPlacemark = new ymaps.Placemark(coord_start,{})

        // Получение объекта Panorama.
        let locateRequest = ymaps.panorama.locate(coord_start);

        locateRequest.then(
            function (panoramas) {
                console.log(panoramas)
                if (panoramas.length) {
                    // Создание на странице плеера панорам.
                    var player = new ymaps.panorama.Player('panoramas', panoramas[0], {
                        // Опции панорамы.
                        // direction - направление взгляда.
                       // direction: [0, -50]
                        direction: [256, 16]
                    });
                } else {
                    console.log("В заданной точке нет панорам.");
                }
            }
        );

        // Ищем панораму в переданной точке.
        // ymaps.panorama.locate(coord_start).done(
        //     function(panoramas) {
        //
        //         // Убеждаемся, что найдена хотя бы одна панорама.
        //         if (panoramas.length > 0) {
        //             // Создаем плеер с одной из полученных панорам.
        //             var player = new ymaps.panorama.Player(
        //                 'player1',
        //                 // Панорамы в ответе отсортированы по расстоянию
        //                 // от переданной в panorama.locate точки. Выбираем первую,
        //                 // она будет ближайшей.
        //                 panoramas[0],
        //                 // Зададим направление взгляда, отличное от значения
        //                 // по умолчанию.
        //                 {
        //                     //locate: coord_start,
        //                     direction: [256, 16]
        //                 }
        //             );
        //         }
        //     })

        myMap.geoObjects.add(startPlacemark);
    }


    })