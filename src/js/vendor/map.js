
var Map = function(geoConfig) {

    this.geoConfig = geoConfig;
    this.mapObject = null;
    this.collections = [];
    this.defaultPreset = 'islands#blueIcon';

    this.createMap = function() {

        if (typeof ymaps === 'undefined') {
            console.log('Ymap not ready yet... Try it later');
            return false;
        }

        this.mapObject = new ymaps.Map('map', {
            center: [this.geoConfig.center.lon, this.geoConfig.center.lat],
            zoom: this.geoConfig.zoom,
            controls: ['zoomControl','typeSelector']
        }, {
            maxZoom: 18
        });

    };

    this.resetCollection = function(collection) {

        this.collections[collection] = new ymaps.GeoObjectCollection();

    };

    this.addPlacemarkToCollection = function(collection, id, lat, lon) {

        var $this = this;

        if (typeof this.collections[collection] === 'undefined') {
            this.collections[collection] = new ymaps.GeoObjectCollection();
        }

        var placemark = new ymaps.GeoObject({
            geometry: {
                type: "Point",
                coordinates: [lat, lon]
            },
            properties: {
                key: id,
                collection: collection
            }
        }, {
            preset: $this.defaultPreset
        });

        placemark.events.add('click', function(e){
            $('li[data-offer-id='+e.get('target').properties.get('key')+'][data-offer-type='+e.get('target').properties.get('collection')+']').trigger('click');
        });
        //placemark.events.add('click', function(e){
        //    e.preventDefault();
        //    $this.resetCollectionPreset(collection);
        //    //var placemark = $this.getPlacemarkFromCollection(collection, id);
        //    placemark.options.set('preset', 'islands#redIcon');
        //});

        this.collections[collection].add(placemark, id);

    };

    this.renderCollection = function(collection, setBounds) {

        setBounds = typeof setBounds === 'boolean' ? setBounds : false;

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

    this.getCollection = function(collection) {

        if (typeof this.collections[collection] === 'undefined') {
            console.log('No collection found: ' + collection);
            return false;
        }

        return this.collections[collection];

    };

    this.getBounds = function() {

        return this.mapObject.getBounds();

    };

    this.setCenter = function(coords) {

        if (coords) {

            this.mapObject.setCenter(coords);

        } else {

            this.mapObject.setCenter([this.geoConfig.center.lon, this.geoConfig.center.lat], this.geoConfig.zoom);

        }

    };

    this.getPlacemarkFromCollection = function(collection, id) {

        if (typeof this.collections[collection] === 'undefined') {
            console.log('No collection found: ' + collection);
            return false;
        }

        return this.collections[collection].get(id);

    };

    this.resetCollectionPreset = function(collection) {

        if (typeof this.collections[collection] === 'undefined') {
            console.log('No collection found: ' + collection);
            return false;
        }

        var iterator = this.collections[collection].getIterator(),
            object,
            $this = this;
        while ((object = iterator.getNext()) != iterator.STOP_ITERATION) {
            object.options.set('preset', $this.defaultPreset);
        }

    };

};
