<?php

    class Offer extends Eloquent {

        protected $fillable = ['user_id','description','type'];

        public function user()
        {
            return $this->belongsTo('User');
        }

    }