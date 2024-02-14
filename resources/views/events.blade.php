<x-app-layout title="Calendrier" activeTab="3">
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>

    <div class="flex flex-col justify-center items-center mx-4">

        <div id='calendar' class="mx-4"></div>

        <div class="divider mx-4"></div>

        <h2 class="text-2xl font-bold mt-4">Prochains événements</h2>

        @foreach ($events as $event)
            <div id="event-card-{{ $event->id }}" class="card border border-dashed border-info my-3 w-full">
                <div class="card-body">
                    <div class="flex flex-row items-center gap-1">
                        <img src="{{ $event->community->image }}" class="w-8 rounded-full">
                        <a href="{{ route('community.show', ['community_id' => $event->community->id]) }}"
                            class="text-xs">{{ $event->community->name }}</a>
                    </div>
                    <p class="text-md font-extrabold">{{ $event->name }}</p>
                    <p class="text-xs">{{ $event->description }}</p>
                    <div class="flex flex-col justify-between gap-2">
                        <div class="justify-start items-center card-actions">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                            </svg>
                            <p class="text-xs">{{ $event->date_time->diffForHumans() }} (
                                {{ $event->date_time->format('j F Y - h:m') }} )</p>
                        </div>
                        <div class="justify-start items-center card-actions">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                            </svg>
                            <p class="text-xs">{{ $event->location }}</p>
                        </div>
                        <div class="justify-start items-center w-fit card-actions">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                            </svg>
                            <p class="text-xs">{{ $event->participants }} participant(s)</p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                timeZone: 'local',
                contentHeight: 300,
                buttonText: {
                    today: 'aujourd\'hui',
                    month: 'mois',
                    week: 'semaine',
                    day: 'jour',
                    list: 'liste'
                },
                events: [
                    @foreach ($events as $event)
                        {
                            title: {!! json_encode($event->name) !!},
                            start: {!! json_encode($event->date_time) !!},
                            extendedProps: {
                                id: {!! json_encode($event->id) !!},
                                description: {!! json_encode($event->description) !!},
                                location: {!! json_encode($event->location) !!},
                                max_participants: {!! json_encode($event->max_participants) !!},
                            }
                        },
                    @endforeach
                ],
                eventClick: function(info) {
                    var eventId = info.event._def.extendedProps.id;
                    var eventCard = document.getElementById('event-card-' + eventId);
                    if (eventCard) {
                        eventCard.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center',
                        });
                        eventCard.classList.add('animate-pulse');
                        setTimeout(function() {
                            eventCard.classList.remove('animate-pulse');
                        }, 3000)
                    }
                }
            });

            calendar.render();

            var buttons = calendarEl.querySelectorAll('.fc-button');
            buttons.forEach(function(button) {
                button.classList.add(
                    'btn');
            });
        });
    </script>
</x-app-layout>
