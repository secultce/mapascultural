<?php
namespace ButtonRecourse;
use Mapasculturais\App;

class Plugin extends \MapasCulturais\Plugin {
    function _init () {
        $app = App::i();
        
        $app->hook('template(agent.single.entity-header):after', function () use($app) {
            $entity = $this->controller->requestedEntity;
            $this->part('index', ['entity' => $entity]);
        });
    }

   function register () {}
}