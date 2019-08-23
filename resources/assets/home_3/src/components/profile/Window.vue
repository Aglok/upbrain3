<!--Шаблон для вывода диалового окна -->
<template>
    <div class="x-window">
        <!--Верхняя панель -->
        <div class="t-board">
            <div class="board tr"></div>
            <div class="board tm"></div>
            <div class="board tl"></div>
            <div class="board mm">
                <slot name="board-mm"></slot>
            </div>
            <div class="board br"></div>
            <div class="board bm"></div>
            <div class="board bl"></div>
        </div>
        <!--Нижняя панель панель -->
        <div class="b-board">
            <div class="board br"></div>
            <div class="board mm"></div>
            <div class="board bl"></div>

            <slot name="x-info"></slot>

            <slot name="x-toolbar"></slot>
        </div>
    </div>
</template>
