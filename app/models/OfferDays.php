<?php

    class OfferDays extends Eloquent {

        protected $table = 'offer_days';

        protected $fillable = ['offer_id','day','time_start','time_end'];

        protected function offer()
        {
            return $this->belongsTo('Offer');
        }

    }