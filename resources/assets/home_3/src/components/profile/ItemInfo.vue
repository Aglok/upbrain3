<template>
    <div class="item-info">
        <div v-if="notCanBuyOrEquip(item)">Требуется:
            <div v-for="(condition, key) in item[can]">
                <p>{{$t('Items.'+key)}}:</p>
                <p :class="key" class="icon" v-html="conditions(condition, key)" :style="css(condition, key)"></p>
            </div>
            <v-divider class="my-2"></v-divider>
        </div>
        <div v-else-if="item.hasOwnProperty('quantity') && !item.quantity">
            <p class="my-0 py-0">Этого товара нет</p>
            <v-divider class="my-2"></v-divider>
        </div>
        <!--Вывод характеристик артефакта-->
        <div>
            <div v-for="(stat, key) in item.stats" class="property">
                <p>{{$t('Inventory.'+key)}}:</p>
                <p :class="key" class="icon" style="width: 60px">{{stat}}<span v-html="htmlDifferenceStats(item.stats, item.artifact_type.slot_id)[key]"></span></p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "user-item-info",
        props:{
            item:{
                type: Object,
                default: () => {}
            },
            can:{
                type: String,
                default: ''
            }
        },
        methods:{
            conditions(condition, key){
                let html = "";
                self = this;
                console.log(self);
                if(key === "progresses"){
                    condition.forEach(function(progress){
                        let pr = self.$store.state.app.user.progresses.find(i => i.name === progress);
                        html += '<img src="'+pr.image+'" alt="'+pr.name+'" title="'+pr.name+'" width="25px">'
                    })
                }else if(key === "level"){
                    for (let subject in condition){
                        html += this.$t('Subjects.'+subject) +': '+'<span>'+condition[subject]+'</span>\n'
                    }
                }else{
                    html += '<span>'+condition+'</span>';
                }
                return html;
            },
            css: function (condition, key) {
                if(key === "progresses") {
                    return {
                        'width': 25 * condition.length + 'px',
                        'z-index': 4
                    };
                }else if(key === "level"){
                    return {
                        'width': 125 * Object.keys(condition).length + 'px',
                        'z-index': 4
                    };
                }else
                    return false
            },
            differenceStats(stats, slot_id){
                let differenceStats = {};
                let statsItemBySlot = this.findItemStatsBySlot(slot_id);

                if(statsItemBySlot){
                    for (let stat in stats){
                        if(stats.hasOwnProperty(stat) && (stat in statsItemBySlot)){
                            differenceStats[stat] = stats[stat] - statsItemBySlot[stat];
                        }
                    }

                    return differenceStats
                }

                return stats;
            },
            htmlDifferenceStats(stats, slot_id){
                let html = {};
                let differenceStats = this.differenceStats(stats, slot_id);
                for (let stat in differenceStats){
                    if(differenceStats.hasOwnProperty(stat)){
                        let valueStat = differenceStats[stat];
                        if(valueStat > 0)
                            html[stat] = ' <span class="green--text"><i class="fas fa-long-arrow-alt-up"></i>'+valueStat+'</span>';
                        if(valueStat < 0)
                            html[stat] = ' <span class="red--text"><i class="fas fa-long-arrow-alt-down"></i>'+(-1)*valueStat+'</span>';
                        if(valueStat === 0)
                            html[stat] = ''
                    }
                }

                return html;
            },
            //Поиск предмета из массива this.items_bag по индексу
            findItemStatsBySlot(slot_id){
                let slot = this.$store.state.app.slots.find(s => s.id === slot_id);

                if(slot.items.length)
                    return slot.items[0].stats;

                return []
            },

            //Провека на возможность покупки
            notCanBuyOrEquip(artifact){
                let canArray = ['canBuy', 'canEquip'];
                for(let can in canArray){
                    let prop = canArray[can];
                    if(artifact.hasOwnProperty(prop)){
                        return !!Object.keys(artifact[prop]).length;
                    }
                }
            }
        }
    }
</script>

<style scoped>

</style>