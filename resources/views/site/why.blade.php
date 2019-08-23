<div class="container-wrap-badget">
    <div class="container">
        <div class="m-b-0 text-center">
            <span class="common-title" id="as-we-learn">Почему дети и родители выбирают курсы Upbrain?</span>
        </div>
        <div class="row row-padded homepage-grid p-t text-center">
            <div class="col-sm-2">
                <img class="who-is-icon" data-toggle="modal" data-target="#block-1" src="{!! asset('images/bg/icon_constant/talent.png') !!}" alt="Учись играя">
                <h3 class="font-lite who-is-text">Сильные <br>преподаватели</h3>
            </div>
            <div class="col-sm-2">
                <img class="who-is-icon" data-toggle="modal" data-target="#block-2" src="{!! asset('images/bg/icon_constant/increase_in_knowledge.png') !!}" alt="Статистика ученика">
                <h3 class="font-lite who-is-text">Средний балл<br> больше 80</h3>
            </div>
            <div class="col-sm-2">
                <img class="who-is-icon" data-toggle="modal" data-target="#block-3" src="{!! asset('images/bg/icon_constant/knowledge_control.png') !!}">
                <h3 class="font-lite who-is-text">Контроль<br> знаний</h3>
            </div>
            <div class="col-sm-2">
                <img class="who-is-icon" data-toggle="modal" data-target="#block-4" src="{!! asset('images/bg/icon_constant/free_class.png') !!}">
                <h3 class="font-lite who-is-text">Бесплатное<br> занятие</h3>
            </div>
            <div class="col-sm-2">
                <img class="who-is-icon" data-toggle="modal" data-target="#block-5" src="{!! asset('images/bg/icon_constant/groups.png') !!}">
                <h3 class="font-lite who-is-text">Группа<br> до 8 человек</h3>
            </div>
            <div class="col-sm-2">
                <img class="who-is-icon" data-toggle="modal" data-target="#block-6" src="{!! asset('images/bg/icon_constant/method.png') !!}">
                <h3 class="font-lite who-is-text">Раскрытие<br> потенциала</h3>
            </div>
        </div>
    </div>
    {{--Модальное окно инфорамации--}}
    <div class="modal fade" id="block-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Высокий уровень преподавателей</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="m-x m-y row">
                        <div class="col-md-8">
                                        <span class="font-lite">
                                        Наши преподаватели работают с душой. 1 из 15 становится частью нашей команды.
                                        Основная задача образовательного процесса - не просто давать знания, но и заинтересовать.
                                        У нас лучшие преподаватели. Прежде чем начать работать, каждый преподаватель проходит наше эксклюзивное обучение и сдаёт экзамен.
                                        Мы уделяем этому очень большое значение, и прекрасно знаем - это важно для Вас и вашего ребёнка!
                                        Наши преподаватели - специалисты своего профиля с опытом работы более 5 лет, цель которых делать процесс обучения эффективным и запоминающимся, несмотря на сложность предмета.
                                        Наша команда формируется в процессе постоянного развития, вокруг нас профессионалы и мастера своего дела,
                                        поэтому подготовка к ЕГЭ перестаёт быть стрессом, а превращается в увлекательный и интересный процесс обучения.
                                        </span>
                        </div>
                        <div class="col-md-4">
                            {!! Form::open(['id'=>'who-is-form-1','url'=>'contact', 'method' => 'post', 'class'=>'form-horizontal'])!!}
                            <div class="form-group">
                                {!! Form::text('name', '',  ['class'=>'form-control', 'placeholder' => 'Ваше имя']) !!}
                                {!! Form::text('phone','',  ['class'=>'form-control', 'placeholder' => 'Телефон']) !!}
                                {!! Form::submit('Записаться', ['class'=>'btn btn-block btn-primary m-t'])!!}
                            </div>
                        </div>
                    </div>
                    {!! Form::close()!!}
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="block-2">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Рост уровня знаний</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="m-x m-y row">
                        <div class="col-md-8">
                                        <span class="font-lite">
                                        Средний балл по ЕГЭ начинается с 80, больше половины учеников поднимают свой уровень на 40 баллов.
                                        На наших занятиях каждому ребёнку уделяется досточно внимания, чтобы составить картину о характере, понять стереотип поведения и на основе "плюсов" и "минусов", дать обратную связь после занятий.
                                        Вы заметите, что со временем у вашего ребёнка начнут гореть глаза, появится стремление развиваться и чувство ответственности, расширится кругозор и мировоззрение, улучшаться оценки в школе.
                                        Не удивляйтесь, если ребёнок начнёт проявлять инициативу в учёбе и в других делах.
                                        В обучении мы используем методику, созданную на личном опыте, и пришли к выводу, что ученик в первую очередь - уникальная личность, а потом уже ученик.  
                                        Поэтому феномен роста знаний и по совсем другим предметам - для нас закономерный, ведь мы учим учиться.
                                        </span>
                        </div>
                        <div class="col-md-4">
                            {!! Form::open(['id'=>'who-is-form-2','url'=>'contact', 'method' => 'post', 'class'=>'form-horizontal who-is-form'])!!}
                            <div class="form-group">
                                {!! Form::text('name', '',  ['class'=>'form-control', 'placeholder' => 'Ваше имя']) !!}
                                {!! Form::text('phone','',  ['class'=>'form-control', 'placeholder' => 'Телефон']) !!}
                                {!! Form::submit('Записаться', ['class'=>'btn btn-block btn-primary m-t'])!!}
                            </div>
                        </div>
                    </div>
                    {!! Form::close()!!}
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="block-3">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Контроль знаний</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="m-x m-y row">
                        <div class="col-md-8">
                                        <span class="font-lite">
                                            ﻿Контроль знаний у нас проводится ежедневно.
                                            Во-первых, ведётся обычная ведомость. Во-вторых, работает система "тройной мотивации" (преподаватель-методист-родитель).
                                            Тесный контакт этого треугольника с учеником даёт ему быструю обратную связь. И в-третьих, ведётся рейтинговая система между всеми учениками, заставляющая не сидеть на месте.
                                            При желании, и возможности мы можем предложить обучение в раздельных классах, мальчики и девочки отдельно.
                                            По нашему опыту, это очень позитивно сказывается на обучении и даже на формировании личности в целом, в ценностях, и успехе в жизни.
                                        </span>
                        </div>
                        <div class="col-md-4">
                            {!! Form::open(['id'=>'who-is-form-3','url'=>'contact', 'method' => 'post', 'class'=>'form-horizontal who-is-form'])!!}
                            <div class="form-group">
                                {!! Form::text('name', '',  ['class'=>'form-control', 'placeholder' => 'Ваше имя']) !!}
                                {!! Form::text('phone','',  ['class'=>'form-control', 'placeholder' => 'Телефон']) !!}
                                {!! Form::submit('Записаться', ['class'=>'btn btn-block btn-primary m-t'])!!}
                            </div>
                        </div>
                    </div>
                    {!! Form::close()!!}
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="block-4">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Бесплатное занятие</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="m-x m-y row">
                        <div class="col-md-8">
                                        <span class="font-lite">
                                            Первое занятие для Вас будет бесплатное, вы познакомитесь с методикой преподавания педагога и сможете оценить его уровень.
                                            Также прочувствовать группу и общую атмосферу.
                                        </span>
                        </div>
                        <div class="col-md-4">
                            {!! Form::open(['id'=>'who-is-form-4','url'=>'contact', 'method' => 'post', 'class'=>'form-horizontal who-is-form'])!!}
                            <div class="form-group">
                                {!! Form::text('name', '',  ['class'=>'form-control', 'placeholder' => 'Ваше имя']) !!}
                                {!! Form::text('phone','',  ['class'=>'form-control', 'placeholder' => 'Телефон']) !!}
                                {!! Form::submit('Записаться', ['class'=>'btn btn-block btn-primary m-t'])!!}
                            </div>
                        </div>
                    </div>
                    {!! Form::close()!!}
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="block-5">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Группа до 8 человек</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="m-x m-y row">
                        <div class="col-md-8">
                                        <span class="font-lite">
                                            У нас набираются группы в среднем по 6 человек.
                                            Мы создаём атмосферу комфорта среди учеников, ограничивая набор и открывая новую группу.
                                            Мы стараемся создавать все условия для эффективного усвоения материала.
                                        </span>
                        </div>
                        <div class="col-md-4">
                            {!! Form::open(['id'=>'who-is-form-5','url'=>'contact', 'method' => 'post', 'class'=>'form-horizontal who-is-form'])!!}
                            <div class="form-group">
                                {!! Form::text('name', '',  ['class'=>'form-control', 'placeholder' => 'Ваше имя']) !!}
                                {!! Form::text('phone','',  ['class'=>'form-control', 'placeholder' => 'Телефон']) !!}
                                {!! Form::submit('Записаться', ['class'=>'btn btn-block btn-primary m-t'])!!}
                            </div>
                        </div>
                    </div>
                    {!! Form::close()!!}
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="block-6">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Раскрытие потенциала</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="m-x m-y row">
                        <div class="col-md-8">
                                        <span class="font-lite">
                                        Что должен знать и уметь ребёнок, чтобы комфортно жить в современных условиях?
                                        Мы стараемся соответствовать условиям современных технологий.
                                        Время движется вперёд, и необходимо успевать осознавать себя в этом процессе развития, как целостная личность.
                                        Чтобы избежать конфликтов в социальной среде, необходимо быть морально готовым к реальным условиям жизни, и уметь отвечать себе на вопрос:
                                        "Что я должен знать и уметь делать на будущее, чтобы комфортно жить в современном постоянно меняющемся мире?"
                                        </span>
                        </div>
                        <div class="col-md-4">
                            {!! Form::open(['id'=>'who-is-form-6','url'=>'contact', 'method' => 'post', 'class'=>'form-horizontal who-is-form'])!!}
                            <div class="form-group">
                                {!! Form::text('name', '',  ['class'=>'form-control', 'placeholder' => 'Ваше имя']) !!}
                                {!! Form::text('phone','',  ['class'=>'form-control', 'placeholder' => 'Телефон']) !!}
                                {!! Form::submit('Записаться', ['class'=>'btn btn-block btn-primary m-t'])!!}
                            </div>
                        </div>
                    </div>
                    {!! Form::close()!!}
                </div>
            </div>
        </div>
    </div>
</div>