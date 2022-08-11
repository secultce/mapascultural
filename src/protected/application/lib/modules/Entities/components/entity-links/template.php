<?php 
use MapasCulturais\i;
?>
<div class="entity-links">
    <h4 class="entity-links__title"> {{title}} </h4>

    <ul class="entity-links__links">
        <li class="entity-links__links--item" v-for="metalist in entity.metalists.links">
            <a class="link" :class="{'editable': editable}" :href="metalist.value" target="_blank" >
                <mc-icon name="link"></mc-icon> 
                {{metalist.title}}
            </a>            
            <div v-if="editable" class="edit">
                <popover @open="metalist.newData = {...metalist}" openside="down-right">
                    <template #button="{ toggle, close }">
                        <a @click="toggle()"> <mc-icon name="edit"></mc-icon> </a>
                    </template>
                    <template #default="{close}">
                        <form @submit="save(metalist).then(close); $event.preventDefault()" class="entity-related-agents__addNew--newGroup">
                            <div class="grid-12">
                                <div class="col-12">
                                    <div class="field">
                                        <label><?php i::_e('Título do link') ?></label>
                                        <input class="input" v-model="metalist.newData.title" type="text" />
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="field">
                                        <label><?php i::_e('Link') ?></label>
                                        <input class="input" v-model="metalist.newData.value" type="url" />
                                    </div>
                                </div>

                                <button class="col-6 button button--text" type="reset" @click="close()"> <?php i::_e("Cancelar") ?> </button>
                                <button class="col-6 button button--primary" type="submit"> <?php i::_e("Confirmar") ?> </button>
                            </div>
                        </form>
                    </template>
                </popover>
                
                <confirm-button @confirm="metalist.delete()">
                    <template #button="{open}">
                        <a @click="open()"> <mc-icon name="trash"></mc-icon> </a>
                    </template> 
                    <template #message="message">
                        <?php i::_e('Deseja remover o link?') ?>
                    </template> 
                </confirm-button>
                
            </div>
        </li>
    </ul>

    <popover v-if="editable" openside="down-right">
        <template #button="{ toggle }">
            <slot name="button" :toggle="toggle"> 
                <a class="button button--primary button--icon button--primary-outline" @click="toggle()">
                    <mc-icon name="add"></mc-icon>
                    <?php i::_e("Adicionar Link")?>
                </a>
            </slot>
        </template>

        <template #default="{ close }">
            <form @submit="create().then(close); $event.preventDefault();" class="entity-links__newLink">
                <div class="grid-12">
                    <div class="col-12">
                        <div class="field">
                            <label><?php i::_e('Título do link') ?></label>
                            <input v-model="metalist.title" class="newLinkTitle" type="text" name="newLinkTitle" />
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="field">
                            <label><?php i::_e('Link') ?></label>
                            <input v-model="metalist.value" class="newLink" type="url" name="newLink" />
                        </div>
                    </div> 

                    <button class="col-6 button button--text" type="reset" @click="close()"> <?php i::_e("Cancelar") ?> </button>
                    <button class="col-6 button button--solid" type="submit"> <?php i::_e("Confirmar") ?> </button>
                </div>
            </form>
        </template>
    </popover>
</div>