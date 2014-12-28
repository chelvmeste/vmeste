<?php

use Vmeste\Collections\ElasticOfferCollection;

    class Offer extends Eloquent {

        use Fadion\Bouncy\BouncyTrait;

        protected $mappingProperties = [
            'id' => ['type' => 'integer', 'index' => 'not_analyzed'],
            'user_id' => ['type' => 'integer', 'index' => 'not_analyzed'],
            'type' => ['type' => 'integer', 'index' => 'not_analyzed'],
            'description' => ['type' => 'string', 'index' => 'not_analyzed'],
            'date' => ['type' => 'date', 'format' => 'date'],
            'time' => ['type' => 'date', 'format' => 'hour_minute_second'],
            'user' => ['type' => 'object', 'properties' => [
                'id' => ['type' => 'integer', 'index' => 'not_analyzed'],
                'gender' => ['type' => 'string', 'index' => 'not_analyzed'],
                'first_name' => ['type' => 'string', 'index' => 'not_analyzed'],
                'last_name' => ['type' => 'string', 'index' => 'not_analyzed'],
                'address' => ['type' => 'string', 'index' => 'not_analyzed'],
                'location' => ['type' => 'geo_point']
            ]],
            'days' => ['type' => 'object', 'properties' => [
                'day_1' => ['type' => 'object', 'properties' => [
                    'active' => ['type' => 'boolean', 'index' => 'not_analyzed'],
                    'time_start' => ['type' => 'date', 'format' => 'hour_minute_second'],
                    'time_end' => ['type' => 'date', 'format' => 'hour_minute_second'],
                ]],
                'day_2' => ['type' => 'object', 'properties' => [
                    'active' => ['type' => 'boolean', 'index' => 'not_analyzed'],
                    'time_start' => ['type' => 'date', 'format' => 'hour_minute_second'],
                    'time_end' => ['type' => 'date', 'format' => 'hour_minute_second'],
                ]],
                'day_3' => ['type' => 'object', 'properties' => [
                    'active' => ['type' => 'boolean', 'index' => 'not_analyzed'],
                    'time_start' => ['type' => 'date', 'format' => 'hour_minute_second'],
                    'time_end' => ['type' => 'date', 'format' => 'hour_minute_second'],
                ]],
                'day_4' => ['type' => 'object', 'properties' => [
                    'active' => ['type' => 'boolean', 'index' => 'not_analyzed'],
                    'time_start' => ['type' => 'date', 'format' => 'hour_minute_second'],
                    'time_end' => ['type' => 'date', 'format' => 'hour_minute_second'],
                ]],
                'day_5' => ['type' => 'object', 'properties' => [
                    'active' => ['type' => 'boolean', 'index' => 'not_analyzed'],
                    'time_start' => ['type' => 'date', 'format' => 'hour_minute_second'],
                    'time_end' => ['type' => 'date', 'format' => 'hour_minute_second'],
                ]],
                'day_6' => ['type' => 'object', 'properties' => [
                    'active' => ['type' => 'boolean', 'index' => 'not_analyzed'],
                    'time_start' => ['type' => 'date', 'format' => 'hour_minute_second'],
                    'time_end' => ['type' => 'date', 'format' => 'hour_minute_second'],
                ]],
                'day_7' => ['type' => 'object', 'properties' => [
                    'active' => ['type' => 'boolean', 'index' => 'not_analyzed'],
                    'time_start' => ['type' => 'date', 'format' => 'hour_minute_second'],
                    'time_end' => ['type' => 'date', 'format' => 'hour_minute_second'],
                ]],
            ]],
        ];

        protected $typeName = 'offers';

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

        public function newCollection(array $models = array())
        {
            return new ElasticOfferCollection($models);
        }

    }
