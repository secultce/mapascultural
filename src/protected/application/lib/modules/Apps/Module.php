<?php
namespace Apps;

use MapasCulturais\App;
use MapasCulturais\Entities\Subsite;

class Module extends \MapasCulturais\Module {
    function _init()
    {
        $app = App::i();

        // define o JWT como Auth Provider caso venha um header authorization
        $app->hook('app.register:after', function () {
            /** @var App $this */
            if($token = $this->request()->headers->get('authorization')){
                $this->_auth = new \Apps\JWTAuthProvider(['token' => $token]);
            }
        });

        // impossibilita que a API retorne chaves de terceiros
        $app->hook('ApiQuery(UserApp).params', function (&$params) {
            $params['user'] = 'EQ(@me)';
        });

        // reabilita a view create para o BaseV1
        if($app->view instanceof \MapasCulturais\Themes\BaseV1\Theme) {
            $app->hook('GET(app.create)', function() {
                /** @var Controller $this */
                $this->render('create');
            });
        }

        // define o subsite como nulo quando apagar um subsite
        $app->hook('entity(Subsite).remove:before', function () use($app) {
            /** @var Subsite $this */
            $query = "UPDATE \Apps\Entities\UserApp u SET u.subsite = NULL WHERE u._subsiteId = {$this->id}";
            $q = $app->em->createQuery($query);
            $q->execute();
        });
    }

    function register()
    {
        $app = App::i();

        $app->registerController('app', Controller::class);
    }
}