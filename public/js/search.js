
var Search = function(mapObject) {

    this.mapObject = mapObject;
    this.offers = [];
    this.requests = [];
    this.activeItemKey = null;
    this.activeItemType = null;
    this.offersFilterForm = '#search-offers-form';
    this.requestsList = '#side-lists-requests';
    this.requestsListCollaple = '#side-list-requests-collapse';
    this.offersList = '#side-lists-offers';
    this.offersListCollaple = '#side-list-offers-collapse';

    this.loadItems = function() {

        var $this = this;

        return $.ajax({
            url: 'ajax/offers',
            type: 'GET',
            success: function(data){
                if (data.help_offers.length > 0) {
                    $this.offers = $this.formatData(data.help_offers);
                    $this.addPlacemarks('offers',data.help_offers,false);
                }
                if (data.help_requests.length > 0) {
                    $this.requests = $this.formatData(data.help_requests);
                    $this.addPlacemarks('requests',data.help_requests,false);
                }
            }
        });

    };

    this.addPlacemarks = function(collection, items, resetCollection) {

        if (resetCollection === true) {
            this.mapObject.resetCollection(collection);
        }

        for (var i = 0; i < items.length; i++) {
            this.mapObject.addPlacemarkToCollection(collection, i, items[i].user.address_latitude, items[i].user.address_longitude);
        }

    };

    this.showItems = function(type) {

        this.mapObject.renderCollection(type);

    };

    this.hideItems = function(type) {

        this.mapObject.hideCollection(type);

    };

    this.buildSideList = function(callback) {

        var $this = this;

        $template.buildTemplate('home.side-list.container',{offers: this.offers, requests: this.requests},$('#side-list'),'html', function() {
            if (typeof callback === 'function') {
                callback();
            } else {
                $this.showItems('requests');
            }
        },{
            offerItem: 'home.side-list.offer-item',
            requestItem: 'home.side-list.requests-item'
        });
        $template.renderTemplates();

    };

    this.formatData = function(data) {

        for (var i = 0; i < data.length; i++) {

            if (typeof data[i].date !== 'undefined' && data[i].date !== '') {
                data[i].date = moment(data[i].date).format('Do MMMM YYYY');
            }
            if (typeof data[i].time !== 'undefined' && data[i].time !== '') {
                data[i].time = moment(data[i].time,'hh:mm:ss').format('HH:mm');
            }
            if (typeof data[i].days !== 'undefined' && data[i].days.length > 0) {
                for (var j = 0; j < data[i].days.length; j++) {
                    data[i].days[j].day_f = moment(data[i].days[j].day, 'E').format('dddd');
                    data[i].days[j].time_start = moment(data[i].days[j].time_start,'hh:mm:ss').format('HH:mm');
                    data[i].days[j].time_end = moment(data[i].days[j].time_end,'hh:mm:ss').format('HH:mm');
                    if (j === data[i].days.length-1) {
                        data[i].days[j].last = true;
                    }
                }
            }
            data[i].key = i;

        }

        return data;

    };

    this.showOffersList = function() {
        $(this.offersList).find('a').trigger('click');
    };

    this.showRequestsList = function() {
        $(this.requestsList).find('a').trigger('click');
    };

    this.bindEvents = function() {

        var $this = this;

        $(document).on('shown.bs.collapse',$this.requestsListCollaple, function() {
            $this.mapObject.resetCollectionPreset('offers');
            $('.select-offer').removeClass('active');
            $this.hideItems('offers');
            $this.showItems('requests');
        });
        $(document).on('shown.bs.collapse',$this.offersListCollaple, function() {
            $this.mapObject.resetCollectionPreset('requests');
            $('.select-offer').removeClass('active');
            $this.showItems('offers');
            $this.hideItems('requests');
        });

        $(document).on('click','.select-offer',function(e){

            e.preventDefault();

            var li = $(this),
                offerKey = li.attr('data-offer-id'),
                offerCollectionType = li.attr('data-offer-type');

            $('.select-offer').removeClass('active');
            li.addClass('active');

            $this.mapObject.resetCollectionPreset(offerCollectionType);

            var placemark = $this.mapObject.getPlacemarkFromCollection(offerCollectionType, offerKey);
            placemark.options.set('preset', 'islands#redIcon');

            $this.loadItemInfo(offerCollectionType, offerKey);

        });

        $(document).on('change','.offers-search-filter',function(e){

            e.preventDefault();

            $this.makeSearch();

        });

        $(document).on('dp.change','#offer-time',function(){
            $this.makeSearch();
        });

    };

    this.makeSearch = function() {

        var $this = this,
            formData = $(this.offersFilterForm).serialize();

        $this.hideItems('offers');

        $.ajax({
            url: '/ajax/search/offers',
            type: 'POST',
            data: {
                formData: formData
            },
            success: function(data) {
                if (data.success === true) {
                    if (typeof data.results !== 'undefined') {
                        $this.offers = $this.formatData(data.results);
                        $this.addPlacemarks('offers',data.results, true);
                        $this.buildSideList(function(){
                            $this.showOffersList();
                        });
                    }
                } else {
                    console.log('Search ajax error.');
                }
            }
        });

    };

    this.loadItemInfo = function(collection, key) {

        if (this.activeItemType === collection && this.activeItemKey === key) {
            console.log('Item already activated');
            return false;
        }

        var item;

        this.activeItemKey = key;
        this.activeItemType = collection;

        if (collection === 'requests') {
            item = this.requests[key];
        } else if (collection === 'offers') {
            item = this.offers[key];
        }

        if (item === null) {
            console.log('No item found...');
            return false;
        }

        $.ajax({
            url: '/ajax/offer/'+item.id,
            type: 'GET',
            success: function(data) {
                if (typeof data.html !== 'undefined' && data.html !== '') {
                    $('#offer-info').html(data.html);
                }
            }
        });

    };

};












