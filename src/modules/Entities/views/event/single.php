<?php
use MapasCulturais\i;
$this->layout = 'entity';

$this->import('
    complaint-suggestion
    entity-actions
    entity-admins
    entity-files-list
    entity-gallery
    entity-gallery-video
    entity-header
    entity-list
    entity-occurrence-list
    entity-owner
    entity-related-agents
    entity-seals
    entity-social-media
    entity-terms
    mc-breadcrumb
    mc-container
    mc-share-links
    mc-tab
    mc-tabs
');

$this->breadcrumb = [
    ['label' => i::__('Painel'), 'url' => $app->createUrl('panel', 'index')],
    ['label' => i::__('Meus Eventos'), 'url' => $app->createUrl('search', 'events')],
    ['label' => $entity->name, 'url' => $app->createUrl('event', 'edit', [$entity->id])],
];
?>
<div class="main-app">
    <mc-breadcrumb></mc-breadcrumb>
    <entity-header :entity="entity">
        <template #metadata>
            <dl>
                <dd>{{entity.subTitle}}</dd>
            </dl>
        </template>
    </entity-header>    
    <mc-tabs class="tabs">
        <mc-tab icon="exclamation" label="<?= i::_e('Informações') ?>" slug="info">
            <div class="tabs__info">
                <mc-container>
                    <main>
                        <div class="grid-12">
                            <div class="col-12">
                                <div class="age-rating">
                                    <label class="age-rating__label">
                                        <?= i::_e("Classificação Etária"); ?>
                                    </label>
                                    <div class="age-rating__content">
                                        {{entity.classificacaoEtaria}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <entity-occurrence-list :entity="entity"></entity-occurrence-list>
                            </div>        
                            <div class="col-12">
                                <div v-if="entity.descricaoSonora || entity.traducaoLibras" class="acessibility">
                                    <span class="acessibility__label"><?php i::_e("Acessibilidade"); ?></span>
                                    <div v-if="entity.descricaoSonora" class="acessibility__audio">
                                        <span class="title"><?php i::_e("Libras:"); ?></span> <span class="content">{{entity.descricaoSonora}}</span>
                                    </div>
                                    <div v-if="entity.traducaoLibras" class="acessibility__libras">
                                        <span class="title"><?php i::_e("Áudio de Descrição:"); ?></span> <span class="content">{{entity.traducaoLibras}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div v-if="entity.event_attendance || entity.telefonePublico || entity.registrationInfo" class=" acessibility event_info__infos">
                                    <span class="acessibility__label"><?php i::_e("Informações adicionais"); ?></span>
                                    <div v-if="entity.event_attendance" class="acessibility__attendance">
                                        <span class="title"><?php i::_e("Total de público:"); ?></span> <span class="content">{{entity.event_attendance}}</span>
                                    </div>
                                    <div v-if="entity.telefonePublico" class="acessibility__phone">
                                        <span  class="title"><?php i::_e("telefone:"); ?></span> <span class="content">{{entity.telefonePublico}}</span>
                                    </div>
                                    <div v-if="entity.registrationInfo" class="acessibility__infos">
                                        <span class="title"><?php i::_e("Informações sobre a inscrição:"); ?></span> <span class="content">{{entity.registrationInfo}}</span>
                                    </div>
                                </div>
                            </div>
                            <div v-if="entity.longDescription" class="col-12 longDescription">
                                <h2><?php i::_e('Descrição Detalhada');?></h2>
                                <p>{{entity.longDescription}}</p>
                            </div>                      
                            <entity-files-list v-if="entity.files.downloads!= null" :entity="entity"  classes="col-12" group="downloads" title="<?php i::esc_attr_e('Arquivos para download') ?>"></entity-files-list>
                            <entity-gallery-video :entity="entity" classes="col-12"></entity-gallery-video>
                            <entity-gallery :entity="entity" classes="col-12"></entity-gallery>
                        </div>
                    </main>
                    <aside>
                        <div class="grid-12">
                            <entity-owner :entity="entity" classes="col-12" title="<?php i::esc_attr_e('Publicado por'); ?>"></entity-owner>
                            <entity-terms :entity="entity" classes="col-12" taxonomy="linguagem" title="<?php i::esc_attr_e('Linguagem cultural');?>"></entity-terms>
                            <entity-social-media :entity="entity" classes="col-12"></entity-social-media>
                            <entity-seals :entity="entity" :editable="entity.currentUserPermissions?.createSealRelation" classes="col-12" title="<?php i::esc_attr_e('Verificações');?>"></entity-seals>
                            <entity-terms :entity="entity" classes="col-12" taxonomy="tag" title="<?php i::esc_attr_e('Tags') ?>"></entity-terms>
                            <entity-related-agents :entity="entity" classes="col-12" title="<?php i::esc_attr_e('Agentes Relacionados'); ?>"></entity-related-agents>
                            <mc-share-links classes="col-12" title="<?php i::esc_attr_e('Compartilhar'); ?>" text="<?php i::esc_attr_e('Veja este link:');?>"></mc-share-links>
                            <entity-admins :entity="entity" classes="col-12"></entity-admins>
                            <div v-if="entity.relatedOpportunities && entity.relatedOpportunities.length > 0" class="col-12">
                                <h4><?php i::_e('Propriedades do Evento');?></h4>
                                <entity-list title="<?php i::esc_attr_e('Oportunidades');?>"  type="opportunity" :ids="[...(entity.ownedOpportunities ? entity.ownedOpportunities : []), ...(entity.relatedOpportunities ? entity.relatedOpportunities : [])]"></entity-list>
                            </div>
                    </aside>
                    <aside>
                        <div class="grid-12">
                            <complaint-suggestion :entity="entity"></complaint-suggestion>
                        </div>
                    </aside>
                </mc-container>
                <entity-actions :entity="entity"></entity-actions>
            </div>  
        </mc-tab>
    </mc-tabs>        
</div>