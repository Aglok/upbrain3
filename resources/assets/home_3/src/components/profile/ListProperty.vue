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
                        <div v-for="(stat, key) in property.invariant" v-if="key !== 'name' && key !== 'description' && key !== 'image' && key !== 'sex' && key !== 'pivot' && key !== 'id' && key !== 'type_id'">
                            <p>{{$t('Inventory.'+key)}}:</p>
                            <p :class="key" :style="css()" class="icon">{{stat}}<span class="size-10" v-html="htmlAddStats(key, stat, property)"></span></p>
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
        },
        methods: {
            htmlAddStats(key, stat, property) {
                let property_artifact = property.artifact_stats;
                if (property_artifact.hasOwnProperty(key)) {
                    let prop = property_artifact[key];
                    if (prop > 0)
                        return ' <span class="green--text"><i class="fas fa-plus"></i>' + prop + '</span>';
                    if (prop < 0)
                        return ' <span class="red--text"><i class="fas fa-minus"></i>' + (-1) * prop + '</span>';
                    if (prop === 0)
                        return stat;
                }
            },
            css: function () {
                return {
                    'width': '62px',
                    //'z-index': 4
                };
            }
        }
    }
</script>

<style scoped>
.size-10{
    font-size: 10px;
}
</style>