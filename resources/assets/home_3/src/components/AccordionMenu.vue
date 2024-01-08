<template>
    <div class="faq-container">
        <div class="faq-question" :class="{show: isOpen}">
            <div class="faq-description"
                 aria-haspopup="true"
                 :aria-expanded="isOpen"
                 @click="toggleDropDown"
                 v-click-outside="closeDropDown"
                >
                <!-- Слот для отображения кнопки -->
                <slot name="button"></slot>
            </div>


            <v-card class="faq-content" v-show="isOpen">
                <div class="v-offset"></div>
                <!-- Слот для отображения контента в раскрывающемся блоке -->
                <slot name="content"></slot>
            </v-card>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'accordion-menu',

        data() {
            return {
                isOpen: false
            }
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
        position: relative;
    }
    .faq-question {
        padding: 0px;
        transition: all 0.3s;
    }
    .faq-content {
        padding: 20px 40px;
        position: absolute;
        z-index: 2;
    }
    .faq-description {
        font-size: 18px;
        color: #4a4a4a;
        letter-spacing: -1.03px;
        padding: 0 52px 0 30px;
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
        /*background: #f7f7f7;*/
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
    @media (max-width: 500px) {
        .short_answers{
            padding: 5px 7px;
        }
        table.v-table tr td{
            padding: 0 10px;
        }
        .faq-content{
            padding: 20px 10px;
        }
    }
    @media (max-width: 375px) {
        .short_answers{
            padding: 5px 5px;
        }
        table.v-table tr td{
            padding: 0 10px;
        }
        .faq-content{
            padding: 20px 10px;
        }
    }
</style>