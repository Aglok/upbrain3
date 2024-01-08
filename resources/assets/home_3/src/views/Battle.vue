<template>
    <v-container fluid game battle>
        <v-row>
            <material-card title="Арена" text="" offset="0" v-on:click="" :ripple="false">
                <v-row class="d-flex align-content-end flex-wrap">
                    <v-col cols="12" sm="8" md="8" lg="8">
                        Задача №102:
                        <accordion-menu>
                            <template v-slot:button>
                                <img class="icon" src="images/bg/profile/battle/quest.png">
                            </template>
                            <template v-slot:content>
                                <div class="justify-center">
                                    {{task.task}}
                                </div>
                                <v-text-field label="Ответ" :rules="rules" hide-details="auto">
                                    <v-icon slot="append" color="green" @click="request()">mdi-plus</v-icon>
                                </v-text-field>
                            </template>
                        </accordion-menu>
                    </v-col>
                    <v-col cols="12" sm="4" md="4" lg="4">
                        <v-progress-linear value="20" color="cyan darken-2" height="25" ></v-progress-linear>
                        <v-img class="monster" src="images/items/monsters/abomination.png" width="50%"></v-img>
                    </v-col>
                </v-row>
                <v-row class="d-flex align-content-end flex-wrap">
                    <v-col cols="12" sm="4" md="4" lg="4">
                        <v-progress-linear value="50" color="cyan darken-2" height="25" ></v-progress-linear>
                        <v-img class="user" src="images/items/characters/woman/dwarf.png" width="50%"></v-img>
                    </v-col>
                    <v-col cols="12" sm="8" md="8" lg="8">
                        Лог битвы:
                        <accordion-menu>
                            <template v-slot:button>
                                <img class="icon" src="images/bg/profile/battle/quest.png">
                            </template>
                            <template v-slot:content>
                                <div class="justify-center">
                                    Текст задачи Текст задачи Текст задачи Текст задачи Текст задачи Текст задачи Текст задачи Текст задачи Текст задачи Текст задачи Текст задачи Текст задачи Текст задачи Текст задачи Текст задачи
                                    Текст задачи Текст задачи Текст задачи Текст задачи Текст задачи Текст задачи Текст задачи Текст задачи Текст задачи Текст задачи Текст задачи Текст задачи Текст задачи Текст задачи Текст задачи
                                </div>
                            </template>
                        </accordion-menu>
                    </v-col>
                </v-row>
                <v-row class="d-flex align-content-end flex-wrap button-battle">
                    <v-col cols="12">
                        <img class="icon" src="images/bg/profile/battle/attack.png">
                        <img class="icon" src="images/bg/profile/battle/defence.png">
                        <img class="icon" src="images/bg/profile/battle/wait.png">
                        <img class="icon" src="images/bg/profile/battle/pass.png">
                        <img class="icon" src="images/bg/profile/battle/potion.png">
                    </v-col>
                </v-row>
            </material-card>
        </v-row>
    </v-container>
</template>

<script>
    export default {
        name: "Battle.vue",

        data: () => ({
            log: false,
            battle: {
                type: Object,
                default: () => {}
            },
            mission_id: 0,
            task: {
                type: Object,
                default: () => {}
            },
            monster_property: {
                type: Object,
                default: () => {}
            },
            params:{
                type: Object,
                default: () => {}
            },
            monsters: [
                {id : '1', name: 'abandoned', type: 'undead', hp: 500, mp: 40},
                {id : '2', name: 'skeleton', type: 'undead', hp: 550}
            ],
            rules: [
                value => !!value || 'Required.',
                value => (value && value.length >= 3) || 'Min 3 characters',
            ],
        }),
        methods:{
            buildParams(){

                return {
                    user_id: 28,
                    subject: 'math',
                    mission_id: this.mission_id,
                    battle_id: this.battle.id,
                    answer: 'answer',
                    action: {},
                    current_time: 1231324,
                }
            },

            request(){
                let app = this;
                app.params = app.buildParams();
                //Чтобы Battle обновилась необходимо отсылать battle_id
                app.params.battle_id = app.battle.id;
                this.$dataUser.getPostData('battle', (response) => {
                    console.log(response)
                }, app.params);
            },

            redirectIfNeed(){
                if(!this.$route.params.mission_id || !this.battle){
                    this.$router.push({ name: 'Main'});
                    return false;
                }

                return true;
            },

            setData(data){
                let app = this;

                //let battle = data.battle;
                let task = data.task;
                let monster_property = data.monster_property;

                //app.battle = battle;
                app.task = task;
                app.monster_property = monster_property;

            }
        },
        created(){
            let app = this;
            this.mission_id = this.$route.params.mission_id;

            if(this.mission_id)
                this.battle = this.$store.state.app.battles.find(b => b.mission_id === parseInt(this.mission_id));

            if(this.redirectIfNeed()){

                app.params = app.buildParams();
                this.$dataUser.getPostData('battle', (response) => {
                    app.setData(response.data);
                }, app.params);
            }
        }
    }
</script>

<style scoped>
.game.battle .monster{
    transform : scale(-1, 1)
}
.game.battle .button-battle{
    position: fixed;
    top: 50%;
    width: 60px;
    opacity: 0.1;
}
</style>