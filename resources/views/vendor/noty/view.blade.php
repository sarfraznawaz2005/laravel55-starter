@if(session()->has('noty.messages'))
    <script type="text/javascript">

        (function () {
            @foreach (session('noty.messages') as $item)
            setTimeout(function () {
                new Noty({
                    text: '{{$item['text']}}',
                    type: '{{$item['type']}}',
                    theme: '{{$item['options']['theme']}}',
                    layout: '{{$item['options']['layout']}}',
                    timeout: '{{$item['options']['timeout']}}',
                    progressBar: '{{$item['options']['progressBar']}}',
                    closeWith: [{!! extractQuoted($item['options']['closeWith']) !!}],
                    animation: {
                        open: function (promise) {
                            var n = this;
                            var Timeline = new mojs.Timeline();
                            var body = new mojs.Html({
                                el: n.barDom,
                                x: {500: 0, delay: 0, duration: 500, easing: 'elastic.out'},
                                isForce3d: true,
                                onComplete: function () {
                                    promise(function (resolve) {
                                        resolve();
                                    })
                                }
                            });

                            var parent = new mojs.Shape({
                                parent: n.barDom,
                                width: 200,
                                height: n.barDom.getBoundingClientRect().height,
                                radius: 0,
                                x: {[150]: -150},
                                duration: 1.2 * 500,
                                isShowStart: true
                            });

                            n.barDom.style['overflow'] = 'visible';
                            parent.el.style['overflow'] = 'hidden';

                            var burst = new mojs.Burst({
                                parent: parent.el,
                                count: 10,
                                top: n.barDom.getBoundingClientRect().height + 75,
                                degree: 90,
                                radius: 75,
                                angle: {[-90]: 40},
                                children: {
                                    fill: '#EBD761',
                                    delay: 'stagger(500, -50)',
                                    radius: 'rand(8, 25)',
                                    direction: -1,
                                    isSwirl: true
                                }
                            });

                            var fadeBurst = new mojs.Burst({
                                parent: parent.el,
                                count: 2,
                                degree: 0,
                                angle: 75,
                                radius: {0: 100},
                                top: '90%',
                                children: {
                                    fill: '#EBD761',
                                    pathScale: [.65, 1],
                                    radius: 'rand(12, 15)',
                                    direction: [-1, 1],
                                    delay: .8 * 500,
                                    isSwirl: true
                                }
                            });

                            Timeline.add(body, burst, fadeBurst, parent);
                            Timeline.play();
                        },
                        close: function (promise) {
                            var n = this;
                            new mojs.Html({
                                el: n.barDom,
                                x: {0: 500, delay: 10, duration: 500, easing: 'cubic.out'},
                                skewY: {0: 10, delay: 10, duration: 500, easing: 'cubic.out'},
                                isForce3d: true,
                                onComplete: function () {
                                    promise(function (resolve) {
                                        resolve();
                                    })
                                }
                            }).play();
                        }
                    },
                    sounds: {
                        sources: [{!! extractQuoted($item['options']['sounds']['sources']) !!}],
                        volume: '{{$item['options']['sounds']['volume']}}',
                        conditions: [{!! extractQuoted($item['options']['sounds']['conditions']) !!}]
                    },
                    docTitle: {
                        conditions: [{!! extractQuoted($item['options']['docTitle']['conditions']) !!}]
                    },
                    modal: '{{$item['options']['modal']}}',
                    force: '{{$item['options']['force']}}',
                    queue: '{{$item['options']['queue']}}',
                    maxVisible: '{{$item['options']['maxVisible']}}',
                    killer: '{{$item['options']['killer']}}',
                    container: '{{$item['options']['container'] ?: ''}}',
                    id: '{{$item['options']['id'] ?: ''}}'
                }).show();
            }, 300);
            @endforeach
        })();
    </script>
@endif
