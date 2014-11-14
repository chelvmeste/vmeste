
var Map = function(geoConfig) {

    this.geoConfig = geoConfig;
    this.mapObject = null;
    this.collections = [];

    this.createMap = function() {

        if (typeof ymaps === 'undefined') {
            console.log('Ymap not ready yet... Try it later');
            return false;
        }

        this.mapObject = new ymaps.Map('map', {
            center: [this.geoConfig.center.lon, this.geoConfig.center.lat],
            zoom: this.geoConfig.zoom,
            controls: ['zoomControl','typeSelector']
        });

    };

    this.addPlacemarkToCollection = function(collection, lat, lon, content, color, preset) {

        color = color || '#0095b6';
        preset = preset || 'islands#icon';

        if (typeof this.collections[collection] === 'undefined') {
            this.collections[collection] = new ymaps.GeoObjectCollection();
        }

        var placemark = new ymaps.Placemark([lat, lon], {
            balloonContent: content
        }, {
            preset: preset,
            iconColor: color
        });

        this.collections[collection].add(placemark);

    };

    this.renderCollection = function(collection, setBounds) {

        setBounds = setBounds || true;

        if (typeof this.collections[collection] === 'undefined') {
            console.log('No collection found: ' + collection);
            return false;
        }

        if (this.mapObject === null) {
            console.log('No map found. Create it first');
            return false;
        }

        this.mapObject.geoObjects.add(this.collections[collection]);

        if (setBounds && this.collections[collection].getLength() > 0) {
            this.mapObject.setBounds(this.collections[collection].getBounds());
        }

    };

    this.hideCollection = function(collection) {

        if (typeof this.collections[collection] === 'undefined') {
            console.log('No collection found: ' + collection);
            return false;
        }

        if (this.mapObject === null) {
            console.log('No map found. Create it first');
            return false;
        }

        this.mapObject.geoObjects.remove(this.collections[collection]);

    };

    // DEPRECATED
    //this.addMapObject = function(lat, lon, content, color, preset) {
    //
    //    color = color || '#0095b6';
    //    preset = preset || 'islands#icon';
    //    var $this = this;
    //
    //    ymaps.ready(function() {
    //
    //        if ($this.mapObject === null) {
    //            console.log('No map found. Create it first');
    //            return;
    //        }
    //
    //        $this.mapObject.geoObjects
    //            .add(new ymaps.Placemark([lat, lon], {
    //                balloonContent: content
    //            }, {
    //                preset: preset,
    //                iconColor: color
    //            }));
    //
    //    });
    //
    //};

};