<?php

    class TemplateController extends BaseController {

        public function getTemplate()
        {

            $templates = Input::get('templates');
            if (!$templates || !is_array($templates) || empty($templates)) {
                return Response::json(array('message' => 'No templates requested'),500);
            }

            $templates = array_unique($templates);

            $templates_data = array();

            foreach ($templates as $template) {

                try {

                    $html = View::make('ajax.'.$template)->render();
                    $templates_data[$template] = array(
                        'html' => $html,
                        'timestamp' => time(),
                    );

                } catch (Exception $e) {
                    // TODO render default template
                }

            }

            return Response::json(array('templates' => $templates_data));

        }

    }