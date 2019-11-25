document.addEventListener('DOMContentLoaded', function () {
    var Calendar = FullCalendar.Calendar;
    var Draggable = FullCalendarInteraction.Draggable

    /* initialize the external events
     -----------------------------------------------------------------*/

    var containerEl = document.getElementById('external-events-list');
    new Draggable(containerEl, {
        itemSelector: '.fc-event',
        eventData: function (eventEl) {
            return {
                title: eventEl.innerText.trim()
            }
        }
    });

    //// the individual way to do it
    // var containerEl = document.getElementById('external-events-list');
    // var eventEls = Array.prototype.slice.call(
    //   containerEl.querySelectorAll('.fc-event')
    // );
    // eventEls.forEach(function(eventEl) {
    //   new Draggable(eventEl, {
    //     eventData: {
    //       title: eventEl.innerText.trim(),
    //     }
    //   });
    // });

    /* initialize the calendar
     -----------------------------------------------------------------*/

    var calendarEl = document.getElementById('calendar');
    var calendar = new Calendar(calendarEl, {
        plugins: ['interaction', 'dayGrid', 'timeGrid', 'list'],
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        defaultDate: '2019-06-12',
        navLinks: true, // can click day/week names to navigate views
        businessHours: true, // display business hours
        events: [
            {
                title: 'Business Lunch',
                start: '2019-06-03T13:00:00',
                constraint: 'businessHours'
            },
            {
                title: 'Meeting',
                start: '2019-06-13T11:00:00',
                constraint: 'availableForMeeting', // defined below
                color: '#257e4a'
            },
            {
                title: 'Conference',
                start: '2019-06-18',
                end: '2019-06-20'
            },
            {
                title: 'Party',
                start: '2019-06-29T20:00:00'
            },

            // areas where "Meeting" must be dropped
            {
                groupId: 'availableForMeeting',
                start: '2019-06-11T10:00:00',
                end: '2019-06-11T16:00:00',
                rendering: 'background'
            },
            {
                groupId: 'availableForMeeting',
                start: '2019-06-13T10:00:00',
                end: '2019-06-13T16:00:00',
                rendering: 'background'
            },

            // red areas where no events can be dropped
            {
                start: '2019-06-24',
                end: '2019-06-28',
                overlap: false,
                rendering: 'background',
                color: '#ff9f89'
            },
            {
                start: '2019-06-06',
                end: '2019-06-08',
                overlap: false,
                rendering: 'background',
                color: '#ff9f89'
            }
        ],
        editable: true,
        droppable: true, // this allows things to be dropped onto the calendar
        drop: function (arg) {
            // is the "remove after drop" checkbox checked?
            if (document.getElementById('drop-remove').checked) {
                // if so, remove the element from the "Draggable Events" list
                arg.draggedEl.parentNode.removeChild(arg.draggedEl);
            }
        }
    });
    calendar.render();

});