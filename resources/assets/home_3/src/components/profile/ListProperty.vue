<template>
    <profile-window class="property">
        <template v-slot:board-mm>
            <div class="board x-title">{{property.class.name}}</div>
        </template>
        <template v-slot:x-info>
            <div class="x-info">
                <div class="header">
                    <div class="image"><img :src="property.class.image" :alt="property.class.name" width="36"></div>
                    <p class="levels" v-for="level in property.class.levels">{{$t('Subjects.'+level.subject)}}: ур. {{level.lvl}}</p>
                    <p class="description">{{property.class.description}}</p>
                </div>
                <div class="details">
                    <div class="stuff-box">
                        <div v-for="(stat, key) in property"
                           v-if="key !== 'created_at' && key !== 'updated_at' && key !== 'id' && key !== 'user_id' && key !== 'class'"
                        ><p>{{$t('Inventory.'+key)}}:</p><p :class="key" class="icon">{{stat}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <template v-slot:x-toolbar>
        </template>
    </profile-window>
</template>

<script>
    export default {
        name: "list-property",
        props:{
            property: {}
        }
    }
</script>

<style scoped>

</style>