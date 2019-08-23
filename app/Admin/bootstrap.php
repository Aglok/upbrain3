<?php

// PackageManager::load('admin-default')
//    ->css('extend', resources_url('css/extend.css'));
Meta::addJs('aglok', asset('js/aglok.js'),'admin-default', true)
    ->addJs('newsletters', asset('js/aglok/newsletters.js'),'admin-default', true)
    ->addCss('tasks', 'css/aglok/tasks.css','admin-default');

Meta::addJs('exam_results', asset('js/vue/exam_results.js'),'admin-default',true);
Meta::addJs('exam_answers', asset('js/vue/exam_answers.js'),'admin-default',true);
Meta::addJs('tasks_button', asset('js/vue/tasks_button.js'),'admin-default',true);
Meta::addJs('tasks_cart', asset('js/vue/tasks_cart.js'),'admin-default',true);
//Meta::addJs('dt1', asset('js/aglok.js'),'admin-default', true);
//Meta::addCss('custom2', asset('css/responsive.dataTables.min.css'),'admin-default');