<?php

    class OfferResponse extends Eloquent {

        protected $table = 'offers_responses';

        protected $fillable = ['offer_user_id','offer_id','request_id','request_user_id','initiator_user_id','offer_response','request_response','status'];

        const OFFER_RESPONSE_STATUS_ACTIVE = 1;
        const OFFER_RESPONSE_STATUS_SUCCESS = 2;
        const OFFER_RESPONSE_STATUS_CANCELED = 3;

        public function offerUser()
        {
            return $this->belongsTo('User','offer_user_id');
        }

        public function requestUser()
        {
            return $this->belongsTo('User','request_user_id');
        }

        public function offer()
        {
            return $this->belongsTo('Offer','offer_id');
        }

        public function request()
        {
            return $this->belongsTo('Offer','request_id');
        }

    }