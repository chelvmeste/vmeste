
var Map = function(geoConfig) {

    this.geoConfig = geoConfig;
    this.mapObject = null;

    this.createMap = function() {

        var $this = this;

        ymaps.ready(function() {

            $this.mapObject = new ymaps.Map('map', {
                center: [$this.geoConfig.center.lon, $this.geoConfig.center.lat],
                zoom: $this.geoConfig.zoom,
                controls: ['zoomControl','typeSelector']
            });

        });

    };

    this.addMapObject = function(lat, lon, content, color, preset) {

        color = color || '#0095b6';
        preset = preset || 'islands#icon';
        var $this = this;

        ymaps.ready(function() {

            if ($this.mapObject === null) {
                console.log('No map found. Create it first');
                return;
            }

            $this.mapObject.geoObjects
                .add(new ymaps.Placemark([lat, lon], {
                    balloonContent: content
                }, {
                    preset: preset,
                    iconColor: color
                }));

        });

    };

};