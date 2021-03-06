<?php

namespace Vmeste\Collections;
use \Illuminate\Database\Eloquent\Collection;
use Fadion\Bouncy\BouncyCollectionTrait;

class ElasticOfferCollection extends Collection {

    use BouncyCollectionTrait;

    public function index()
    {
        if ($this->isEmpty()) {
            return false;
        }

        $params = array();

        foreach ($this->all() as $item1) {
            $params['body'][] = array(
                'index' => array(
                    '_index' => $item1->getIndex(),
                    '_type' => $item1->getTypeName(),
                    '_id' => $item1->getKey()
                )
            );

            $item = $item1->toArray();

            $days = array();

            if (!isset($item['days']) && $item1->type == \Offer::HELP_OFFER) {

                $offerDays = $item1->days;
                if ($offerDays) {
                    foreach($offerDays as $d) {
                        $item['days'][] = $d->toArray();
                    }
                }

            }

            if (isset($item['days']) && !empty($item['days']))
            {
                foreach($item['days'] as $day)
                {
                    $days['day_'.$day['day']] = array(
                        'day' => $day['day'],
                        'active' => true,
                        'time_start' => $day['time_start'],
                        'time_end' => $day['time_end'],
                    );
                }
                for($i=1;$i<=7;$i++)
                {
                    if (!isset($days['day_'.$i])) {
                        $days['day_'.$i] = array(
                            'day' => $i,
                            'active' => false
                        );
                    }
                }

            }

            $item['days'] = $days;

            $item['user']['location']['lat'] = $item['user']['address_latitude'];
            $item['user']['location']['lon'] = $item['user']['address_longitude'];

            if ($item['type'] == \Offer::HELP_OFFER)
            {
                unset($item['time'], $item['date']);
            }
            unset($item['user']['address_longitude'], $item['user']['address_latitude'], $item['created_at'], $item['updated_at'], $item['birthdate']);


            $params['body'][] = $item;
        }

        return $this->getElasticClient()->bulk($params);

    }

}
