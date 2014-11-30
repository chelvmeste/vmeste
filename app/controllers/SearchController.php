<?php

class SearchController extends BaseController {

    public function offers()
    {

        $formData = Input::get('formData');
        parse_str($formData, $formFields);

        $validator = Validator::make($formFields, array(
            'gender' => 'in:male,female,any',
            'day' => 'in:day_1,day_2,day_3,day_4,day_5,day_6,day_7,any',
            'time' => 'date_format:H:i',
        ));

        if ($validator->fails())
        {
            return Response::json(array('success' => false, 'message' => 'Invalid form data'));
        }

        $postData = $validator->getData();

        $query = new Elastica\Query();
        $queryFilter = new \Elastica\Filter\BoolAnd();

        // set type to offers
        $filterOfferType = new Elastica\Filter\Term();
        $filterOfferType->setTerm('type',Offer::HELP_OFFER);
        $queryFilter->addFilter($filterOfferType);


        if (isset($postData['gender']) && $postData['gender'] !== 'any')
        {
            $filterGender = new Elastica\Filter\Term();
            $filterGender->setTerm('user.gender',$postData['gender']);
            $queryFilter->addFilter($filterGender);
        }

        // + пол
        // расстояние
        // + день
        // + время
        // + тип

        if (isset($postData['day']) && $postData['day'] !== 'any')
        {
            $filterDay = new Elastica\Filter\Term();
            $filterDay->setTerm('days.'.$postData['day'].'.active', true);
            $queryFilter->addFilter($filterDay);
        }

        if (isset($postData['time']) && !empty($postData['time']))
        {
            if (isset($postData['day']) && $postData['day'] !== 'any')
            {
                $filterTime = new Elastica\Filter\Range();
                $filterTime->addField('days.'.$postData['day'].'.time_start', array(
                    'lte' => $postData['time'].':00',
                ));
                $queryFilter->addFilter($filterTime);
                $filterTime = new Elastica\Filter\Range();
                $filterTime->addField('days.'.$postData['day'].'.time_end', array(
                    'gte' => $postData['time'].':00',
                ));
                $queryFilter->addFilter($filterTime);
            }
            else
            {
                $filterTimeOr = new Elastica\Filter\BoolOr();
                for ($i=1;$i<=7;$i++)
                {
                    $filterTimeAnd = new Elastica\Filter\BoolAnd();
                    $filterDay = new Elastica\Filter\Term();
                    $filterDay->setTerm('days.day_'.$i.'.active', true);
                    $filterTimeAnd->addFilter($filterDay);
                    $filterTime = new Elastica\Filter\Range();
                    $filterTime->addField('days.day_'.$i.'.time_start', array(
                        'lte' => $postData['time'].':00',
                    ));
                    $filterTimeAnd->addFilter($filterTime);
                    $filterTime = new Elastica\Filter\Range();
                    $filterTime->addField('days.day_'.$i.'.time_end', array(
                        'gte' => $postData['time'].':00',
                    ));
                    $filterTimeAnd->addFilter($filterTime);
                    $filterTimeOr->addFilter($filterTimeAnd);
                }
                $queryFilter->addFilter($filterTimeOr);
            }
        }

        $query->setPostFilter($queryFilter);
        $rawQuery = $query->toArray();

        $results = Offer::search($rawQuery);

        $results->load(array(
            'user' => function($query) {
                $query->select('id','first_name','last_name','address','address_latitude','address_longitude');
            },
            'days'
        ));

        return Response::json(array('success' => true,'results' => $results/*, 'query' => $rawQuery*/));

    }

}