<?php

use MapasCulturais\i;

$this->layout = 'entity';

$this->import('
    confirm-before-exit
    entity-actions
    entity-admins
    entity-cover
    entity-field
    entity-files-list
    entity-gallery
    entity-gallery-video
    entity-header
    entity-links
    entity-location
    entity-owner
    entity-profile
    entity-related-agents
    entity-social-media
    entity-terms
    entity-status
    mc-breadcrumb
    mc-card
    mc-container
    mc-tabs
    mc-tab

');

$label = $this->isRequestedEntityMine() ? i::__('Meus agentes') : i::__('Agentes');
$this->breadcrumb = [
    ['label' => i::__('Painel'), 'url' => $app->createUrl('panel', 'index')],
    ['label' => $label, 'url' => $app->createUrl('panel', 'agents')],
    ['label' => $entity->name, 'url' => $app->createUrl('agent', 'edit', [$entity->id])],
];
?>

<div class="main-app">
    <mc-breadcrumb></mc-breadcrumb>
    <entity-header :entity="entity" editable></entity-header>

    <mc-tabs class="tabs">
        <?php $this->applyTemplateHook('tabs','begin') ?>
        <mc-tab label="<?= i::_e('Meu Perfil') ?>" slug="info">
            <mc-container>
                <entity-status :entity="entity"></entity-status>
                <mc-card class="feature">
                    <template #title>
                        <label><?php i::_e("Informações de Apresentação") ?></label>
                        <p><?php i::_e("Os dados inseridos abaixo serão exibidos para todos os usuários") ?></p>
                    </template>
                    <template #content>
                        <div class="left">
                            <div class="grid-12 v-bottom">
                                <entity-cover :entity="entity" classes="col-12"></entity-cover>

                                <div class="col-12 grid-12">
                                    <?php $this->applyTemplateHook('entity-info','begin') ?>
                                    <div class="col-3 sm:col-12">
                                        <entity-profile :entity="entity"></entity-profile>
                                    </div>
                                    <div class="col-9 sm:col-12 grid-12 v-bottom">
                                        <entity-field :entity="entity" classes="col-12" prop="name" label="<?php i::_e('Nome do Agente') ?>"></entity-field>
                                    </div>
                                    <?php $this->applyTemplateHook('entity-info','end') ?>
                                </div>

                                <entity-field :entity="entity" classes="col-12" prop="shortDescription"></entity-field>
                                <entity-field :entity="entity" classes="col-12" prop="site"></entity-field>
                            </div>
                        </div>
                        <div class="divider"></div>
                        <div class="right">
                            <div class="grid-12">
                                <?php $this->applyTemplateHook('edit2-entity-info-taxonomie-area','before') ?>
                                <entity-terms :entity="entity" taxonomy="area" editable classes="col-12" title="<?php i::_e('Área de atuação'); ?>"></entity-terms>
                                <?php $this->applyTemplateHook('edit2-entity-info-taxonomie-area','after') ?>

                                <entity-social-media :entity="entity" classes="col-12" editable></entity-social-media>
                            </div>
                        </div>
                    </template>
                </mc-card>
                <main>
                    <mc-card>
                        <template #title>
                            <label><?php i::_e("Dados do Agente Coletivo"); ?></label>
                            <p class="data-subtitle"><?php i::_e("Os dados inseridos abaixo serão registrados apenas no sistemas e não serão exibidos publicamente") ?></p>
                        </template>
                        <template #content>
                            <div class="grid-12">
                                <entity-field :entity="entity" classes="col-9 sm:col-12" prop="name" label="<?php i::_e('Nome fantasia ou razão social') ?>"></entity-field>
                                <entity-field v-if="global.auth.is('admin')" :entity="entity" prop="type" @change="entity.save(true).then(() => global.reload())" classes="col-12"></entity-field>
                                <entity-field :entity="entity" classes="col-12" prop="cnpj" label="CNPJ"></entity-field>
                                <entity-field :entity="entity" classes="col-12" prop="dataDeNascimento" label="<?= i::__('Data de fundação') ?>"></entity-field>
                                <entity-field :entity="entity" classes="col-12" prop="emailPrivado" label="<?= i::__('E-mail privado ') ?>"></entity-field>
                                <entity-field :entity="entity" classes="col-12" prop="telefonePublico" label="<?= i::__('Telefone público com DDD') ?>"></entity-field>
                                <entity-field :entity="entity" classes="col-12" prop="emailPublico" label="<?= i::__('E-mail público') ?>"></entity-field>
                                <entity-field :entity="entity" classes="col-6 sm:col-12" prop="telefone1" label="<?= i::__('Telefone privado 1 com DDD') ?>"></entity-field>
                                <entity-field :entity="entity" classes="col-6 sm:col-12" prop="telefone2" label="<?= i::__('Telefone privado 2 com DDD') ?>"></entity-field>
                                <div class="col-12 divider"></div>
                                <entity-location :entity="entity" classes="col-12" editable></entity-location>
                            </div>
                        </template>
                    </mc-card>
                    <mc-card>
                        <template #title>
                            <label><?php i::_e("informações públicas"); ?></label>
                            <p><?php i::_e("Os dados inseridos abaixo assim como as informações de apresentação também são exibidos publicamente"); ?></p>
                        </template>
                        <template #content>
                            <div class="grid-12">
                                <entity-field :entity="entity" classes="col-12" prop="longDescription" editable></entity-field>
                                <entity-files-list :entity="entity" classes="col-12" group="downloads" title="Adicionar arquivos para download" editable></entity-files-list>
                                <entity-links :entity="entity" classes="col-12" title="<?php i::_e('Adicionar links'); ?>" editable></entity-links>
                                <entity-gallery-video title="<?php i::_e('Adicionar vídeos') ?>" :entity="entity" classes="col-12" editable></entity-gallery-video>
                                <entity-gallery title="<?php i::_e('Adicionar fotos na galeria') ?>" :entity="entity" classes="col-12" editable></entity-gallery>
                            </div>
                        </template>
                    </mc-card>
                </main>
                <aside>
                    <mc-card>
                        <template #content>
                            <div class="grid-12">
                                <entity-admins :entity="entity" classes="col-12" editable></entity-admins>
                                <entity-terms :entity="entity" taxonomy="tag" classes="col-12" title="Tags" editable></entity-terms>
                                <entity-related-agents :entity="entity" classes="col-12" editable></entity-related-agents>
                                <entity-owner :entity="entity" title="Publicado por" classes="col-12" editable></entity-owner>
                            </div>
                        </template>
                    </mc-card>
                </aside>
            </mc-container>
        </mc-tab>
        <mc-tab label="<?= i::_e('Selos') ?>" slug="seals"></mc-tab>
        <mc-tab label="<?= i::_e('Administração') ?>" slug="admin"></mc-tab>
        <mc-tab label="<?= i::_e('Organizações') ?>" slug="organization"></mc-tab>
        <mc-tab label="<?= i::_e('Propriedades') ?>" slug="properties"></mc-tab>
        <mc-tab label="<?= i::_e('Documentos') ?>" slug="documents"></mc-tab>

            <mc-container>
                <entity-status :entity="entity"></entity-status>
                <mc-card class="feature">
                    <template #title>
                        <label><?php i::_e("Informações de Apresentação") ?></label>
                        <p><?php i::_e("Os dados inseridos abaixo serão exibidos para todos os usuários") ?></p>
                    </template>
                    <template #content>
                        <div class="left">
                            <div class="grid-12 v-bottom">
                                <entity-cover :entity="entity" classes="col-12"></entity-cover>

                                <div class="col-12 grid-12">
                                    <?php $this->applyTemplateHook('entity-info','begin') ?>
                                    <div class="col-3 sm:col-12">
                                        <entity-profile :entity="entity"></entity-profile>
                                    </div>
                                    <div class="col-9 sm:col-12 grid-12 v-bottom">
                                        <entity-field :entity="entity" classes="col-12" prop="name" label="<?php i::_e('Nome do Agente') ?>"></entity-field>
                                    </div>
                                    <?php $this->applyTemplateHook('entity-info','end') ?>
                                </div>
                                
                                <?php $this->applyTemplateHook('edit1-entity-info-taxonomie-area','before') ?>
                                <entity-terms :entity="entity" taxonomy="area" editable classes="col-12" title="<?php i::_e('Áreas de atuação'); ?>"></entity-terms>
                                <?php $this->applyTemplateHook('edit1-entity-info-taxonomie-area','after') ?>

                                <?php $this->applyTemplateHook('edit1-entity-info-shortDescription','before') ?>
                                <entity-field :entity="entity" classes="col-12" prop="shortDescription" label="<?php i::_e('Mini bio') ?>"></entity-field>
                                <?php $this->applyTemplateHook('edit1-entity-info-shortDescription','after') ?>

                                <?php $this->applyTemplateHook('edit1-entity-info-site','before') ?>
                                <entity-field :entity="entity" classes="col-12" prop="site"></entity-field>
                                <?php $this->applyTemplateHook('edit1-entity-info-site','after') ?>
                            </div>
                        </div>
                        <div class="divider"></div>
                        <div class="right">
                            <div class="grid-12">
                                <entity-terms :entity="entity" taxonomy="funcao" editable classes="col-12" title="<?php i::_e('Informe sua função na cultura'); ?>"></entity-terms>
                                <entity-social-media :entity="entity" editable classes="col-12"></entity-social-media>
                            </div>
                        </div>
                    </template>
                </mc-card>
                <main>
                    <mc-card>
                        <template #title>
                            <h3 class="bold"><?php i::_e("Dados Pessoais"); ?></h3>
                            <p><?php i::_e("Não se preocupe, esses dados não serão exibidos publicamente."); ?></p>
                        </template>
                        <template #content>
                            <div class="grid-12">
                                <entity-field :entity="entity" classes="col-12" prop="nomeSocial" label="<?= i::__('Nome Social') ?>"></entity-field>
                                <entity-field :entity="entity" classes="col-12" prop="nomeCompleto" label="<?= i::__('Nome Completo') ?>"></entity-field>
                                <entity-field v-if="global.auth.is('admin')" :entity="entity" prop="type" @change="entity.save(true).then(() => global.reload())" classes="col-12"></entity-field>
                                <entity-field :entity="entity" classes="col-12" prop="cpf"></entity-field>
                                <entity-field :entity="entity" classes="col-12" prop="cnpj" label="<?= i::__('MEI (CNPJ do MEI)') ?>"></entity-field>
                                <entity-field :entity="entity" classes="col-12" prop="emailPrivado" label="<?= i::__('E-mail pessoal') ?>"></entity-field>
                                <entity-field :entity="entity" classes="col-12" prop="telefonePublico" label="<?= i::__('Telefone público com DDD') ?>"></entity-field>
                                <entity-field :entity="entity" classes="col-12" prop="emailPublico" label="<?= i::__('E-mail público') ?>"></entity-field>
                                <entity-field :entity="entity" classes="col-6 sm:col-12" prop="telefone1" label="<?= i::__('Telefone privado 1 com DDD') ?>"></entity-field>
                                <entity-field :entity="entity" classes="col-6 sm:col-12" prop="telefone2" label="<?= i::__('Telefone privado 2 com DDD') ?>"></entity-field>
                                <div class="col-12 divider"></div>
                                <entity-location :entity="entity" classes="col-12" editable></entity-location>
                            </div>
                        </template>
                    </mc-card>
                    <mc-card>
                        <template #title>
                            <h3 class="bold"><?php i::_e("Dados pessoais sensíveis"); ?></h3>
                            <p class="data-subtitle"><?php i::_e("Os dados inseridos abaixo serão registrados apenas no sistemas e não serão exibidos publicamente"); ?></p>
                        </template>
                        <template #content>
                            <div class="grid-12">
                                <entity-field :entity="entity" classes="col-6 sm:col-12" prop="dataDeNascimento" label="<?= i::__('Data de Nascimento') ?>"></entity-field>
                                <div class="field col-6">
                                    <label>{{entity.$PROPERTIES['idoso'].label}}</label>
                                    <input type="text" disabled :value="entity.idoso ? 'Sim' : 'Não'" />
                                </div>    
                                <entity-field :entity="entity" classes="col-6 sm:col-12" prop="genero" label="<?= i::__('Selecione o Gênero') ?>"></entity-field>
                                <entity-field :entity="entity" classes="col-6 sm:col-12" prop="orientacaoSexual" label="<?= i::__('Selecione a Orientação Sexual') ?>"></entity-field>
                                <entity-field :entity="entity" classes="col-6 sm:col-12" prop="raca" label="<?= i::__('Selecione a Raça/Cor') ?>"></entity-field>
                                <entity-field :entity="entity" classes="col-6 sm:col-12" prop="escolaridade" label="<?= i::__('Selecione a sua Escolaridade') ?>"></entity-field>
                                <entity-field :entity="entity" classes="col-6 sm:col-12" prop="agenteItinerante" label="<?= i::__('É agente itinerante?') ?>"></entity-field>
                                <entity-field :entity="entity" classes="col-6 sm:col-12" prop="payment_bank_account_type"></entity-field>
                                <entity-field :entity="entity" classes="col-6 sm:col-12" prop="payment_bank_number"></entity-field>
                                <entity-field :entity="entity" classes="col-7 sm:col-12" prop="payment_bank_account_number"></entity-field>
                                <entity-field :entity="entity" classes="col-5 sm:col-12" prop="payment_bank_dv_account_number"></entity-field>
                                <entity-field :entity="entity" classes="col-7 sm:col-12" prop="payment_bank_branch"></entity-field>
                                <entity-field :entity="entity" classes="col-5 sm:col-12" prop="payment_bank_dv_branch"></entity-field>
                                <entity-field :entity="entity" classes="col-12" prop="pessoaDeficiente" class="pcd col-12" label="<?= i::__('Pessoa com Deficiência') ?>"></entity-field>
                                <entity-field :entity="entity" classes="col-12" prop="comunidadesTradicional" label="<?= i::__('Comunidades tradicionais') ?>"></entity-field>
                                <entity-field :entity="entity" classes="col-12" prop="comunidadesTradicionalOutros" label="<?= i::__('Não encontrou sua comunidade Tradicional') ?>"></entity-field>
                            </div>
                        </template>
                    </mc-card>
                    <mc-card>
                        <template #title>
                            <label><?php i::_e("Informações públicas"); ?></label>
                            <p><?php i::_e("Os dados inseridos abaixo assim como as informações de apresentação também são exibidos publicamente"); ?></p>
                        </template>
                        <template #content>
                            <div class="grid-12">
                                <entity-field :entity="entity" classes="col-12" prop="longDescription" editable></entity-field>
                                <entity-files-list :entity="entity" classes="col-12" group="downloads" title="<?php i::_e('Adicionar arquivos para download'); ?>" editable></entity-files-list>
                                <entity-links :entity="entity" classes="col-12" title="<?php i::_e('Adicionar links'); ?>" editable></entity-links>
                                <entity-gallery-video :entity="entity" classes="col-12" title="<?php i::_e('Adicionar vídeos') ?>" editable></entity-gallery-video>
                                <entity-gallery :entity="entity" classes="col-12" title="<?php i::_e('Adicionar fotos na galeria') ?>" editable></entity-gallery>
                            </div>
                        </template>
                    </mc-card>
                </main>
                <aside>
                    <mc-card>
                        <template #content>
                            <div class="grid-12">
                                <entity-admins :entity="entity" classes="col-12" editable></entity-admins>
                                <entity-related-agents :entity="entity" classes="col-12" editable></entity-related-agents>
                                <entity-terms :entity="entity" taxonomy="tag" classes="col-12" title="Tags" editable></entity-terms>
                                <entity-owner :entity="entity" classes="col-12" title="Publicado por" editable></entity-owner>
                            </div>
                        </template>
                    </mc-card>
                </aside>
            </mc-container>
        </mc-tab>
        <?php $this->applyTemplateHook('tabs','end') ?>
    </mc-tabs>
    
    <entity-actions :entity="entity" editable></entity-actions>
</div>
<confirm-before-exit :entity="entity"></confirm-before-exit>