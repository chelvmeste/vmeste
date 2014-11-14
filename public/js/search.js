
var Search = function(mapObject) {

    this.mapObject = mapObject;
    this.offers = [];
    this.requests = [];

    this.loadItems = function() {

        var $this = this;

        return $.ajax({
            url: 'ajax/offers',
            type: 'GET',
            success: function(data){
                if (data.help_offers.length > 0) {
                    $this.offers = $this.formatData(data.help_offers);
                    for (var i = 0; i < data.help_offers.length; i++) {
                        $this.mapObject.addPlacemarkToCollection('offers', data.help_offers[i].user.address_latitude, data.help_offers[i].user.address_longitude);
                    }
                }
                if (data.help_requests.length > 0) {
                    $this.requests = $this.formatData(data.help_requests);
                    for (var i = 0; i < data.help_requests.length; i++) {
                        $this.mapObject.addPlacemarkToCollection('requests', data.help_requests[i].user.address_latitude, data.help_requests[i].user.address_longitude);
                    }
                }
            }
        });

    };

    this.showItems = function(type) {

        this.mapObject.renderCollection(type);

    };

    this.hideItems = function(type) {

        this.mapObject.hideCollection(type);

    };

    this.buildSideList = function() {

        var $this = this;

        $template.buildTemplate('home.side-list.container',{offers: this.offers, requests: this.requests},$('#side-list'),'html', function() {
            $this.showItems('requests');
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

        }

        return data;

    };

    this.bindEvents = function() {

        var $this = this;

        $('#side-list-requests-collapse')
            .on('shown.bs.collapse', function () {
                $this.hideItems('offers');
                $this.showItems('requests');
            });
        $('#side-list-offers-collapse')
            .on('shown.bs.collapse', function () {
                $this.showItems('offers');
                $this.hideItems('requests');
            });

    };

};












