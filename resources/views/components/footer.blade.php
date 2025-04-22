<footer
    class="container mx-auto max-w-[1280px] p-4 flex max-md:flex-col items-center md:justify-between gap-6 mt-auto border-t border-black/10">
    <a href="index.html">
    <P class="text-[36px]">КЗНА</P>
    </a>
    <div id="map" class="w-[30%] h-[10vw]"></div>
  
    <script src="https://api-maps.yandex.ru/2.1/?apikey=545c88f5-848e-4123-8c7d-6090568cdc0dч&lang=ru_RU" type="text/javascript"></script>
    <script type="text/javascript">
        ymaps.ready(init);
        function init() {
            var myMap = new ymaps.Map("map", {
                center: [52.283148, 104.281361], // Координаты центра карты
                zoom: 10 // Масштаб карты
            });

            // Создание метки
            var myPlacemark = new ymaps.Placemark([52.283148, 104.281361], {
                hintContent: 'Ул.',
                balloonContent: 'Описание вашего адреса'
            });

            // Добавление метки на карту
            myMap.geoObjects.add(myPlacemark);
        }
    </script> 
</footer>
