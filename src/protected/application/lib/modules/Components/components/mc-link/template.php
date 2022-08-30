<?php
$this->import('mc-icon');
?>
<a :href="url" :class="classes">
    <mc-icon v-if="icon && entity" :entity="entity"></mc-icon>
    <mc-icon v-if="icon && !entity" :name="icon"></mc-icon>
    <slot><template v-if="entity">{{entity.name}}</template></slot>
</a>