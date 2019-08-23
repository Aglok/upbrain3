<template>
    <div class="faq-container">
        <div class="faq-question" :class="{show: isOpen}" v-for="(item, index) in contents">
            <div class="faq-description"
                 aria-haspopup="true"
                 :aria-expanded="isOpen"
                 @click="toggleDropDown"
                 v-click-outside="closeDropDown"
                >
                <span class="faq-number">{{index + 1}}</span>{{item.title}}<span>+</span>
            </div>
            <div class="faq-content" v-show="isOpen">
                <!--<p>{{item.msg}}</p>-->
                <p class="my-2"><b>Результаты с кратким ответом</b></p>
                <p>
                    <span class="short_answers" v-for="(ball, index) in item.result_short_answers">
                        <span>{{ball}}</span>
                    </span>
                </p>
                <p class="my-2"><b>Результаты с развёрнутым ответом</b></p>
                <p>
                    <span class="expanded_answers" v-for="(ball, index) in item.result_expanded_answers">
                        <span v-if="index < 3">{{ball}}(2)</span>
                        <span v-else-if="index > 2 && index < 5">{{ball}}(3)</span>
                        <span v-else>{{ball}}(4)</span>
                    </span>
                </p>
                <router-link :to="{ name: 'Table List', params: { id: item.exam_id }}">Подробнее</router-link>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'vue-accordion-menu',

        data() {
            return {
                isOpen: false
            }
        },
        props: {
            contents: {
                type: Array,
                default: [
                    {
                        exam_id: 1,
                        title: 'How are you?',
                        msg: 'I am fine thank you.',
                    },
                ],
            },
        },
        methods: {
            toggleDropDown () {
                this.isOpen = !this.isOpen
                this.$emit('change', this.isOpen)
            },
            closeDropDown () {
                this.isOpen = false
                this.$emit('change', this.isOpen)
            }
        },
    }
</script>

<style scoped>
    .faq-container {
        width: 100%;
        margin: 0 auto;
    }
    .faq-question {
        padding: 0px;
        transition: all 0.3s;
    }
    .faq-content {
        padding: 20px 40px;
    }
    .faq-description {
        font-size: 18px;
        color: #4a4a4a;
        letter-spacing: -1.03px;
        padding: 23px 100px 20px 40px;
        border-top: none;
        position: relative;
        -webkit-transition: all 0.3s;
        -moz-transition: all 0.3s;
        transition: all 0.3s;
        cursor: pointer;
    }
    .faq-description:hover{
        color: #5d93cb;
    }
    .faq-description span:last-child {
        cursor: pointer;
        -webkit-transition: all 0.3s;
        -moz-transition: all 0.3s;
        transition: all 0.3s;
        position: absolute;
        right: 20px;
        top: 0px;
        color: #979797;
        font-size: 2em;
    }
    .faq-description .faq-number {
        width: 30px;
        height: 30px;
        line-height: 28px;
        border: 1px solid black;
        padding-right: 1px;
        display: none;
        text-align: center;
        border-radius: 100px;
        -webkit-border-radius: 100px;
        margin-right: 10px;
        font-size: 20px;
        color: #4a4a4a;
        letter-spacing: -0.86px;
        position: absolute;
        z-index: 1;
        top: 20px;
        left: 5px;
        -webkit-transition: all 0.3s;
        -moz-transition: all 0.3s;
        transition: all 0.3s;
        font-weight: normal;
    }
    .faq-question.show {
        background: #f7f7f7;
    }
    .faq-question.show .faq-description {
        font-weight: 600;
    }
    .faq-question.show .faq-description .faq-number {
        color: white;
        background: #4a4a4a;
    }
    .faq-question.show .faq-description span:last-child {
        -moz-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        -webkit-transform: rotate(45deg);
        -o-transform: rotate(45deg);
        transform: rotate(45deg);
        font-weight: normal;
    }
    .short_answers{
        border: 1px solid #ccc5b9;
        padding: 5px 10px;
        border-right: 0;
    }
    .short_answers:last-child{
        border-right: 1px solid #ccc5b9;
    }
    .expanded_answers{
        margin: 5px 3px;
    }
    @media (max-width: 767px) {
        .faq-container {
            width: 100%;
            border-radius: 0;
            border: 1px solid transparent;
            border-bottom: 1px solid #D9D9D9;
            padding: 0;
        }
        .content-title {
            font-size: 28px;
            text-align: center;
            font-weight: 600;
        }
        .faq-description {
            font-size: 18px;
        }
        .faq-question .faq-description span:last-child {
            top: 8px;
        }
    }
</style>