// Sliders & Carousels
var today = new Date();
var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();

$(document).ready(() => {
    $("#calendar-list").fullCalendar({
        header: {
            left: "prev,next today",
            center: "title",
            right: "listDay,listWeek,month",
        },
        themeSystem: "bootstrap4",
        bootstrapFontAwesome: true,
        // customize the button names,
        // otherwise they'd all just say "list"
        views: {
            listDay: {buttonText: "list day"},
            listWeek: {buttonText: "list week"},
        },

        defaultView: "listWeek",
        defaultDate: "2018-03-12",
        navLinks: true, // can click day/week names to navigate views
        editable: true,
        eventLimit: true, // allow "more" link when too many events
        events: [
            {
                title: "All Day Event",
                start: "2018-03-01",
            },
            {
                title: "Long Event",
                start: "2018-03-07",
                end: "2018-03-10",
            },
            {
                id: 999,
                title: "Repeating Event",
                start: "2018-03-09T16:00:00",
            },
            {
                id: 999,
                title: "Repeating Event",
                start: "2018-03-16T16:00:00",
            },
            {
                title: "Conference",
                start: "2018-03-11",
                end: "2018-03-13",
            },
            {
                title: "Meeting",
                start: "2018-03-12T10:30:00",
                end: "2018-03-12T12:30:00",
            },
            {
                title: "Lunch",
                start: "2018-03-12T12:00:00",
            },
            {
                title: "Meeting",
                start: "2018-03-12T14:30:00",
            },
            {
                title: "Happy Hour",
                start: "2018-03-12T17:30:00",
            },
            {
                title: "Dinner",
                start: "2018-03-12T20:00:00",
            },
            {
                title: "Birthday Party",
                start: "2018-03-13T07:00:00",
            },
            {
                title: "Click for Google",
                url: "http://google.com/",
                start: "2018-03-28",
            },
        ],
    });

    $("#calendar").fullCalendar({
        header: {
            left: "prev,next today",
            center: "title",
            right: "month,basicWeek,basicDay",
        },
        themeSystem: "bootstrap4",
        bootstrapFontAwesome: true,
        defaultDate: "2018-03-12",
        navLinks: true, // can click day/week names to navigate views
        editable: true,
        eventLimit: true, // allow "more" link when too many events
        events: [
            {
                title: "All Day Event",
                start: "2018-03-01",
            },
            {
                title: "Long Event",
                start: "2018-03-07",
                end: "2018-03-10",
            },
            {
                id: 999,
                title: "Repeating Event",
                start: "2018-03-09T16:00:00",
            },
            {
                id: 999,
                title: "Repeating Event",
                start: "2018-03-16T16:00:00",
            },
            {
                title: "Conference",
                start: "2018-03-11",
                end: "2018-03-13",
            },
            {
                title: "Meeting",
                start: "2018-03-12T10:30:00",
                end: "2018-03-12T12:30:00",
            },
            {
                title: "Lunch",
                start: "2018-03-12T12:00:00",
            },
            {
                title: "Meeting",
                start: "2018-03-12T14:30:00",
            },
            {
                title: "Happy Hour",
                start: "2018-03-12T17:30:00",
            },
            {
                title: "Dinner",
                start: "2018-03-12T20:00:00",
            },
            {
                title: "Birthday Party",
                start: "2018-03-13T07:00:00",
            },
            {
                title: "Click for Google",
                url: "http://google.com/",
                start: "2018-03-28",
            },
        ],
    });

    $("#calendar-bg-events").fullCalendar({
        header: {
            left: "prev,next today",
            center: "title",
            right: "month,agendaWeek,agendaDay,listMonth",
        },
        themeSystem: "bootstrap4",
        bootstrapFontAwesome: true,
        defaultDate: date,
        navLinks: true, // can click day/week names to navigate views
        businessHours: true, // display business hours
        editable: true,
        googleCalendarApiKey: 'AIzaSyAH6jUmubEYHj9W66GaT6uMknDZjhVH6vc',
        eventSources: [
            {
                googleCalendarId: 'abssce0v033p6av125vb6qrivo@group.calendar.google.com',
                className: 'ORE',
                color: '#039be6',
                /*textColor: 'white',
                backgroundColor: 'white',
                borderColor: '',
                editable: true,*/
            },
        ]
    });

    $("#calendarBSB").fullCalendar({
        header: {
            left: "prev,next today",
            center: "title",
            right: "month,agendaWeek,agendaDay,listMonth",
        },
        themeSystem: "bootstrap4",
        bootstrapFontAwesome: true,
        defaultDate: date,
        navLinks: true, // can click day/week names to navigate views
        businessHours: true, // display business hours
        editable: true,
        googleCalendarApiKey: 'AIzaSyAH6jUmubEYHj9W66GaT6uMknDZjhVH6vc',
        eventSources: [
            {
                googleCalendarId: 'a4bv3s31gpkhtg74lf32csj4t8@group.calendar.google.com',
                className: 'ORE',
                color: '#039be6',
                /*textColor: 'white',
                backgroundColor: 'white',
                borderColor: '',
                editable: true,*/
            },
        ]
    });
});
