<?php

    class Offer extends Eloquent {

        protected $fillable = ['user_id','description','type'];

        const HELP_REQUEST = 1;
        const HELP_OFFER = 2;

        public function user()
        {
            return $this->belongsTo('User');
        }

        public function days()
        {
            return $this->hasMany('OfferDays');
        }

    }